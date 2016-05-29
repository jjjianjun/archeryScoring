<?php
include '../Connections/dbConnMysqli.php';

$queryAllPlayer = "select player_id from players where player_bow_cat = 'Recurve' and player_gender = 'Male'";
$allPlayer = mysqli_query($wifiAtt, $queryAllPlayer);
//$row_RecordsetPlayers = mysqli_fetch_all($allPlayer,MYSQLI_ASSOC);
$cntPlayerRecurveMale = mysqli_num_rows($allPlayer);
$recommendedLaneRecurveMale = ceil(($cntPlayerRecurveMale/4));

$queryAllPlayer = "select player_id from players where player_bow_cat = 'Recurve' and player_gender = 'Female'";
$allPlayer = mysqli_query($wifiAtt, $queryAllPlayer);
$cntPlayerRecurveFemale = mysqli_num_rows($allPlayer);
$recommendedLaneRecurveFemale= ceil(($cntPlayerRecurveFemale/4));

$queryAllPlayer = "select player_id from players where player_bow_cat = 'Compound' and player_gender = 'Male'";
$allPlayer = mysqli_query($wifiAtt, $queryAllPlayer);
$cntPlayerCompoundMale = mysqli_num_rows($allPlayer);
$recommendedLaneCompMale= ceil(($cntPlayerCompoundMale/4));

$queryAllPlayer = "select player_id from players where player_bow_cat = 'Compound' and player_gender = 'Female'";
$allPlayer = mysqli_query($wifiAtt, $queryAllPlayer);
$cntPlayerCompoundFemale = mysqli_num_rows($allPlayer);
$recommendedLaneCompFemale= ceil(($cntPlayerCompoundFemale/4));

$recommendedLaneQty = $recommendedLaneRecurveMale + $recommendedLaneRecurveFemale + $recommendedLaneCompMale + $recommendedLaneCompFemale;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/jquery-ui.css" />
        <script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="../js/jquery-ui.js" ></script>
    <script>
     $(document).ready(function() {
         $('#archerNo').click(function(){  
          $( "#popupDialog" ).dialog();       
        }); 
  });
  </script>
    </head>
    <body>
        
        
<!--        <form method="POST">
            <table>
                <tr>
                    <td>Enter Lane Number Quantity</td>
                    <td><input type="number" id="numLaneQty" name="numLaneQty"></td>
                    <td><input type="submit" id="btnSubmit" name="btnSubmit"></td>
                </tr>
                <tr>
                    <td colspan="3">Recommended Lane Required:<?php echo $recommendedLaneQty; ?></td>
                </tr>
            </table>
        </form>-->
        <?php
//        
//        // Archer no will be assign order by recurve male, recurve female, comp.male and last comp.female  
            $querySortedPlayer = "select * from players where player_bow_cat = 'Recurve' and player_gender = 'Male' ORDER BY player_bow_cat desc,player_gender desc, team asc";
            $allPlayer = mysqli_query($wifiAtt, $querySortedPlayer);
            $row_RecordsetPlayers = mysqli_fetch_all($allPlayer,MYSQLI_ASSOC);
            
        
        ?>
<table class="table table-bordered table-condensed"><div id="popupDialog" hidden  >macam ni buleh?</div>
            <form method="POST">
            <tr>
                <td >Archer No <input type="button" id="archerNo" value="tekan saya"></td>
                <td>Archer Name</td>
                <td>Gender</td>
                <td>Category</td>
                <td>Team</td>
            </tr>
            <?php
                $counter =1;
                $cntAlph = "A";
                $tempTeam = "";
                
                foreach( $row_RecordsetPlayers as $rowPlayer )
                {  
                    $archerNo = $counter.$cntAlph;
                    $strArchNo = "txtArchNo-".$archerNo;
                    ?>
            <tr>
                <td><input type="text" id="<?php echo $strArchNo ?>"  style="width:25px;" name="<?php echo $strArchNo ?>" value="<?php echo $archerNo; ?>"></td>
                <td><?php echo $rowPlayer['player_name'];  ?></td>
                <td><?php echo $rowPlayer['player_gender'];  ?></td>
                <td><?php echo $rowPlayer['player_bow_cat'];  ?></td>
                <td><?php echo $rowPlayer['team'];  ?></td>
            </tr>    
                    <?php
                  $tempTeam = $rowPlayer['team']; 
                                  
                  if($counter == $recommendedLaneRecurveMale) // reset $counter and increment $cntApl if reached recommendedLane
                  {
                      $counter = 1;
                      $cntAlph++;
                  }
                  else
                  $counter++;
                  
                  if(isset($_POST['btnSave']))
                  {
                      fnAssignArcherNo($rowPlayer['player_id'], $_POST[$strArchNo]);
                  }
                }
                
            $querySortedPlayer = "select * from players where player_bow_cat = 'Recurve' and player_gender = 'Female' ORDER BY player_bow_cat desc,player_gender desc, team asc";
            $allPlayer = mysqli_query($wifiAtt, $querySortedPlayer);
            $row_RecordsetPlayers = mysqli_fetch_all($allPlayer,MYSQLI_ASSOC);
            $cntAlph = "A";  
            $tempTeam = "";
            $counter = $recommendedLaneRecurveMale + 1;  // counter should start after recurveMale
            $counterRecFemale = 1;
                foreach( $row_RecordsetPlayers as $rowPlayer )
                {  
                    $archerNo = $counter.$cntAlph;
                    $strArchNo = "txtArchNo-".$archerNo;
                    ?>
            <tr>
                <td><input type="text" id="<?php echo $strArchNo ?>"  style="width:25px;" name="<?php echo $strArchNo ?>" value="<?php echo $archerNo; ?>"></td>
                <td><?php echo $rowPlayer['player_name'];  ?></td>
                <td><?php echo $rowPlayer['player_gender'];  ?></td>
                <td><?php echo $rowPlayer['player_bow_cat'];  ?></td>
                <td><?php echo $rowPlayer['team'];  ?></td>
            </tr>    
                    <?php
                  $tempTeam = $rowPlayer['team']; 
                                  
                  if($counterRecFemale == $recommendedLaneRecurveFemale ) // reset $counter and increment $cntApl if reached recommendedLane
                  {
                    $counter = $recommendedLaneRecurveMale + 1;
                    $cntAlph++;
                    $counterRecFemale = 1;
                  }
                  else
                  {
                    $counter++;
                    $counterRecFemale++;
                  }
                  
                  if(isset($_POST['btnSave']))
                  {
                      fnAssignArcherNo($rowPlayer['player_id'], $_POST[$strArchNo]);
                  }
                }
                
            $querySortedPlayer = "select * from players where player_bow_cat = 'Compound' and player_gender = 'Male' ORDER BY player_bow_cat desc,player_gender desc, team asc";
            $allPlayer = mysqli_query($wifiAtt, $querySortedPlayer);
            $row_RecordsetPlayers = mysqli_fetch_all($allPlayer,MYSQLI_ASSOC);
            $cntAlph = "A";  
            $tempTeam = "";
            $counter = $recommendedLaneRecurveMale + $recommendedLaneRecurveFemale + 1;  // counter should start after recurveMale and recurveFemale
            $counterComMale = 1;
                foreach( $row_RecordsetPlayers as $rowPlayer )
                {  
                    $archerNo = $counter.$cntAlph;
                    $strArchNo = "txtArchNo-".$archerNo;
                    ?>
            <tr>
                <td><input type="text" id="<?php echo $strArchNo ?>"  style="width:25px;" name="<?php echo $strArchNo ?>" value="<?php echo $archerNo; ?>"></td>
                <td><?php echo $rowPlayer['player_name'];  ?></td>
                <td><?php echo $rowPlayer['player_gender'];  ?></td>
                <td><?php echo $rowPlayer['player_bow_cat'];  ?></td>
                <td><?php echo $rowPlayer['team'];  ?></td>
            </tr>    
                    <?php
                  $tempTeam = $rowPlayer['team']; 
                                  
                  if($counterComMale == $recommendedLaneCompMale )
                  {
                    $counter = $recommendedLaneRecurveMale + $recommendedLaneRecurveFemale  + 1;
                    $cntAlph++;
                    $counterComMale = 1;
                  }
                  else
                  {
                    $counter++;
                    $counterComMale++;
                  }
                  
                  if(isset($_POST['btnSave']))
                  {
                      fnAssignArcherNo($rowPlayer['player_id'], $_POST[$strArchNo]);
                  }
                }
                
            $querySortedPlayer = "select * from players where player_bow_cat = 'Compound' and player_gender = 'Female' ORDER BY player_bow_cat desc,player_gender desc, team asc";
            $allPlayer = mysqli_query($wifiAtt, $querySortedPlayer);
            $row_RecordsetPlayers = mysqli_fetch_all($allPlayer,MYSQLI_ASSOC);
            $cntAlph = "A";  
            $tempTeam = "";
            $counter = $recommendedLaneRecurveMale + $recommendedLaneRecurveFemale + $recommendedLaneCompMale + 1;  // counter should start after recurveMale and recurveFemale and compMale
            $counterComFemale = 1;
                foreach( $row_RecordsetPlayers as $rowPlayer )
                {  
                    $archerNo = $counter.$cntAlph;
                    $strArchNo = "txtArchNo-".$archerNo;
                    ?>
            <tr>
                <td><input type="text" id="<?php echo $strArchNo ?>"  style="width:25px;" name="<?php echo $strArchNo ?>" value="<?php echo $archerNo; ?>"></td>
                <td><?php echo $rowPlayer['player_name'];  ?></td>
                <td><?php echo $rowPlayer['player_gender'];  ?></td>
                <td><?php echo $rowPlayer['player_bow_cat'];  ?></td>
                <td><?php echo $rowPlayer['team'];  ?></td>
            </tr>    
                    <?php
                  $tempTeam = $rowPlayer['team']; 
                                  
                  if($counterComFemale == $recommendedLaneCompFemale )
                  {
                    $counter = $recommendedLaneRecurveMale + $recommendedLaneRecurveFemale + $recommendedLaneCompMale + 1;
                    $cntAlph++;
                    $counterComFemale = 1;
                  }
                  else
                  {
                    $counter++;
                    $counterComFemale++;
                  }
                  
                  if(isset($_POST['btnSave']))
                  {
                      fnAssignArcherNo($rowPlayer['player_id'], $_POST[$strArchNo]);
                  }
                }  
            ?>
            <tr>
                <td colspan="4" align="center"><input type="submit" value="Save" id="btnSave" name="btnSave"></td>
            </tr>
            </form>
        </table>
        <?php // } ?>
    </body>
</html>
