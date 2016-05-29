<?php
//include '../Connections/dbConnMysqli.php';
//
//$queryAllPlayer = "Select * from players";
//$allPlayer = mysqli_query($wifiAtt, $queryAllPlayer);
//$row_RecordsetPlayers = mysqli_fetch_all($allPlayer,MYSQLI_ASSOC);
//$cntRowPlayer = mysqli_num_rows($allPlayer);
include '../Connections/wifiAtt.php';
$_SESSION['prevSelGender'] = "";
$_SESSION['prevSelTeam'] = "";
$_SESSION['prevSelCat'] = "";
if(isset($_POST['btnSubmit']))
  {
      
      $stmtSelect = $db->prepare("select max(player_id) as currentId from players ");        
      $stmtSelect->execute();
      $row_maxPlayerId = $stmtSelect->fetch(PDO::FETCH_ASSOC);
      
//      $qryMaxPlyrId = "select max(player_id) as currentId from players";
//      $MaxPlayerId = mysqli_query($wifiAtt, $qryMaxPlyrId);
//      $row_maxPlayerId = mysqli_fetch_assoc($MaxPlayerId);
      $playerId = $row_maxPlayerId['currentId'] +1;
      if($_POST['btnSubmit'] == "Save")
      {
         $stmt = $db->prepare("INSERT into players (player_name,player_gender,team,player_bow_cat ) VALUES (:player_name,:player_gender,:team,:player_bow_cat) ");
         $stmt->execute(array(':player_name' => $_POST['txtBoxArcherName'], ':player_gender' => $_POST['slctGender'],':team' =>$_POST['txtBoxTeam'],':player_bow_cat' =>$_POST['slctCat'] ));
         $_SESSION['prevSelGender'] = $_POST['slctGender'];
         $_SESSION['prevSelTeam'] = $_POST['txtBoxTeam'];
         $_SESSION['prevSelCat'] = $_POST['slctCat'];
      }
      else
      {
         $stmt = $db->prepare("UPDATE players SET player_name=:player_name, player_gender=:player_gender, team=:team, player_bow_cat=:player_bow_cat,player_no = :player_no  where player_id = :player_id "); 
         $stmt->execute(array(':player_name' => $_POST['txtBoxArcherName'], ':player_gender' => $_POST['slctGender'],':team' =>$_POST['txtBoxTeam'],':player_bow_cat' =>$_POST['slctCat'],':player_id'=> $_POST['hidPlayerId'],':player_no'=>$_POST['txtBoxArcherNo']));
         header("Location: ListNAddPlayer.php");
      }
      //echo $stmt->rowCount().' were affected' ;
      
      

  }
  $recordSet = null;
 if(isset($_GET['action']))
  {
     if($_GET['action']=="Delete")
     {
      $stmt = $db->prepare("delete from players where player_id =:player_id ");
      $stmt->bindParam(':player_id',$_GET['playerId'],PDO::PARAM_INT);
      $stmt->execute();  
     }
     else if ($_GET['action']=="Edit")
     {
      $stmt = $db->prepare("select * from players where player_id =:player_id ");
      $stmt->bindParam(':player_id',$_GET['playerId'],PDO::PARAM_INT);
      $stmt->execute(); 
      
      $recordSet = $stmt->fetch();
      
      $_SESSION['prevSelGender'] = "";
      $_SESSION['prevSelTeam'] = "";
      $_SESSION['prevSelCat'] = "";
     }

  }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="../js/jquery-ui.js" ></script>
        <link rel="stylesheet" href="../css/jquery-ui.css" />
        <link rel="stylesheet" href="../css/style_1.css" />
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<style>
			.table-striped > tbody > tr:nth-child(even) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
				background-color: #e3f2fd;
			}
		</style>
		
    </head>
    <body>
        <script type="text/javascript">
        $(document).ready(function() {
            
           $('#notification').change(function(){
               
              $.ajax({ 
                  url:'../generalFN/genericFn.php',
                  data:{action:'checkArcherNo',archerNo:$('#txtBoxArcherNo').val()},
                  type:'post',
                  success: function(response){
                      if(response > 0)
                      {
                          alert("Archer No already exist!");
                          $('#btnSubmit').attr('disabled','disabled');
                      }
                      else
                      {
                          $('#btnSubmit').removeAttr('disabled');
                      }
                  }
              }); 
           });   
        });
        </script>
        <form class="form-horizontal" name="frmPlayerAdd" method="post">
        <table>
<!--            <tr>
                <td>Archer No: </td>
                <td><div id="notification" name="notification"><input type="text" id="txtBoxArcherNo" name="txtBoxArcherNo"></div></td>
            </tr>-->
            <!--tr>
                <td>Archer Name: <input type="hidden" name="hidPlayerId" id="hidPlayerId" value="<?php echo ($recordSet == null ?"" :$recordSet['player_id']) ?>"></td>
                <td><input type="text" id="txtBoxArcherName" name="txtBoxArcherName" value="<?php echo ($recordSet == null ?"" :$recordSet['player_name']) ?>"></td>
            </tr-->
			<div class="form-group">
				<label for="txtBoxArcherName" class="col-sm-2 control-label">Archer Name:</label>
				<input type="hidden" name="hidPlayerId" id="hidPlayerId" value="<?php echo ($recordSet == null ?"" :$recordSet['player_id']) ?>">
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxArcherName" name="txtBoxArcherName" value="<?php echo ($recordSet == null ?"" :$recordSet['player_name']) ?>">
				</div>
			</div>
            <?php
            if(isset($_GET['action']) && $_GET['action'] == 'Edit' )
            {	?>
            <!--tr>
                <td>Archer No:</td>
                <td><input type="text" id="txtBoxArcherNo" class="txtBoxUpperCase" name="txtBoxArcherNo" value="<?php echo ($recordSet == null ?"" :$recordSet['player_no']) ?>"></td>
            </tr-->
			
			<div class="form-group">
				<label for="txtBoxArcherNo" class="col-sm-2 control-label">Archer No:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxArcherNo" name="txtBoxArcherNo" value="<?php echo ($recordSet == null ?"" :$recordSet['player_no']) ?>">
				</div>
			</div>  
            <?php 
            }	?>
            <!--tr>
                <td>Gender: </td>
                <td><select id="slctGender" name="slctGender" >
                        <option value="Male" <?php echo ($recordSet['player_gender'] == "Male" ? "Selected" :"") ?>>Male</option>   
                        <option value="Female" <?php echo ($recordSet['player_gender'] == "Female" ? "Selected" :"") ?>>Female</option>
                    </select></td>
            </tr-->
			<div class="form-group">
				<label for="txtBoxGender" class="col-sm-2 control-label">Gender:</label>
				<div class="col-sm-8">
					<select class="form-control" id="slctGender" name="slctGender">
						<option value="Male" <?php echo ($recordSet['player_gender'] == "Male" ? "Selected" :"") ?>>Male</option>   
                        <option value="Female" <?php echo ($recordSet['player_gender'] == "Female" ? "Selected" :"") ?>>Female</option>
					</select>					
				</div>
			</div>			
            <!--tr>
                <td>Team: </td>
                <td><select id="txtBoxTeam" name="txtBoxTeam">
                    <?php 
                    $stmtSelect = $db->prepare("SELECT TeamCode from teams ");
                    $stmtSelect->execute();
                    $row_RecordsetTeam = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($row_RecordsetTeam as $row)
                    {  ?>
                        <option value="<?php echo $row['TeamCode'] ?>"  
                            <?php echo ($recordSet['team'] == $row['TeamCode'] ? "Selected" :"") ?> 
                            <?php echo ($_SESSION['prevSelTeam'] == $row['TeamCode'] ? "Selected" :"") ?>   >
                                <?php echo $row['TeamCode'] ?></option>
                <?php    }
                ?>
                     </select></td>
            </tr-->
			<div class="form-group">
				<label for="txtBoxTeam" class="col-sm-2 control-label">Team:</label>
				<div class="col-sm-8">
					<select class="form-control" id="txtBoxTeam" name="txtBoxTeam">
						                    <?php 
                    $stmtSelect = $db->prepare("SELECT TeamCode from teams ");
                    $stmtSelect->execute();
                    $row_RecordsetTeam = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($row_RecordsetTeam as $row)
                    {  ?>
                        <option value="<?php echo $row['TeamCode'] ?>"  
                            <?php echo ($recordSet['team'] == $row['TeamCode'] ? "Selected" :"") ?> 
                            <?php echo ($_SESSION['prevSelTeam'] == $row['TeamCode'] ? "Selected" :"") ?>   >
                            <?php echo $row['TeamCode'] ?></option>
					<?php    }
					?>
					</select>					
				</div>
			</div>			
            <!--tr>
                <td>Category: </td>
                <td><select id="slctCat" name="slctCat" >
                <?php 
                    $stmtSelect = $db->prepare("SELECT bow_category from bowcategories ");
                    $stmtSelect->execute();
                    $row_RecordsetBowCat = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($row_RecordsetBowCat as $row)
                    {  ?>
                        <option value="<?php echo $row['bow_category'] ?>" 
                            <?php echo ($recordSet['player_bow_cat'] == $row['bow_category'] ? "Selected" :"") ?>
                            <?php echo ($_SESSION['prevSelCat'] == $row['bow_category'] ? "Selected" :"") ?>    >
                                <?php echo $row['bow_category'] ?></option>
                <?php    }
                ?>
                    </select></td>
            </tr-->
			<div class="form-group">
				<label for="slctCat" class="col-sm-2 control-label">Category:</label>
				<div class="col-sm-8">
					<select class="form-control" id="slctCat" name="slctCat">
					<?php 
                    $stmtSelect = $db->prepare("SELECT bow_category from bowcategories ");
                    $stmtSelect->execute();
                    $row_RecordsetBowCat = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($row_RecordsetBowCat as $row)
                    {  ?>
                        <option value="<?php echo $row['bow_category'] ?>" 
                            <?php echo ($recordSet['player_bow_cat'] == $row['bow_category'] ? "Selected" :"") ?>
                            <?php echo ($_SESSION['prevSelCat'] == $row['bow_category'] ? "Selected" :"") ?>    >
                                <?php echo $row['bow_category'] ?></option>
					<?php    }
					?>
					</select>					
				</div>
			</div>			
            <!--tr>
                <td colspan="2" align="center"><input type="submit" id="btnSubmit" name="btnSubmit" value="<?php echo ($recordSet == null ?"Save" :"Update") ?>"></td>
            </tr-->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-4">
					<button type="submit" class="btn btn-default" id="btnSubmit" name="btnSubmit" style="padding: 6px 12px; font-size:14px;" value="<?php echo ($recordSet == null ?"Save" :"Update") ?>"><?php echo ($recordSet == null ?"Save" :"Update") ?></button>
				</div>
				<!--div class="col-sm-2">
					<button type="submit" class="btn btn-default" style="padding: 6px 12px; font-size:14px;" onclick="window.location.assign('assignArcherNoV2.php')">Assign Archer No</button>
				</div>	
				<div class="col-sm-2">
					<button type="submit" class="btn btn-default" style="padding: 6px 12px; font-size:14px;" onclick="window.open('viewListArchersInfo.php','_target');">View List Archers</button>
				</div-->					
			</div>			
        </table>
        </form>
        <?php
            $stmtSelect = $db->prepare("SELECT * from players ");
            
            $stmtSelect->execute();

            $row_RecordsetPlayers = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
            $cntRow = $stmtSelect -> rowCount();
            if($cntRow >0)
            {
        ?>
	<div class="form-horizontal">	
	
		<div class="form-group col-sm-8">
		<label for="assignArcherNo" class="col-sm-2 control-label">Extras:</label>
			<div class="col-sm-6">
				<form action="assignArcherNoV2.php" method="POST"><button type="submit" class="btn btn-default" name="assignArcherNo">Assign Archer No</button></form>	
			</div>
			<div class="col-sm-4">
				<form action="viewListArchersInfo.php" method="POST" target="_blank"><button type="submit" class="btn btn-default" style="padding: 6px 12px; font-size:14px;">View List Archers</button></form>
			</div>	
		</div>
	</div>
        <table class="table table-condensed table-bordered table-striped table-hover">
			<thead>
            <tr>
                <th>No</th>
                <th>Archer Name</th>
                <th>Gender</th>
                <th>Category</th>
                <th colspan="2">Team</th>
            </tr>
			<tbody>
            <?php
                $cnt = 1;
                foreach( $row_RecordsetPlayers as $rowPlayer )
                {  ?>
            <tr style="background-color:<?php //echo ($cnt%2==1 ? "#A1CCE4" : "#E9E5FD"); ?>">
                <td><?php echo $cnt;   ?></td>
                <td><a href="ListNAddPlayer.php?action=Edit&playerId=<?php echo $rowPlayer['player_id']; ?>" ><?php echo $rowPlayer['player_name']  ?></a></td>
                <td><?php echo $rowPlayer['player_gender']  ?></td>
                <td><?php echo $rowPlayer['player_bow_cat']  ?></td>
                <td><?php echo $rowPlayer['team']  ?></td>
                <td style="text-align:center;">
					<a href="ListNAddPlayer.php?action=Delete&playerId=<?php echo $rowPlayer['player_id']; ?>">
						<span class="pull-right showopacity glyphicon glyphicon-trash" title="Remove Player: <?php echo $rowPlayer['player_name']; ?>" ></span>
					</a>
				</td>
            </tr>    
                    <?php
                    $cnt++;
                }
            ?>
		</tbody>
        </table>
        <?php
            }
            $db = null;
        ?>
    </body>
</html>
