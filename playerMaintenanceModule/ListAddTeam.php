<?php
include '../Connections/wifiAtt.php';

if(isset($_POST['btnSubmit']))
  {
    if($_POST['btnSubmit']=="Add Team" && $_POST['txtBoxTeamName'] != "")
    {
     $stmt = $db->prepare("INSERT into teams (teamCode) VALUES (:teamCode) ");
     $stmt->execute(array(':teamCode' => $_POST['txtBoxTeamName']));
    }
    else if($_POST['btnSubmit']=="Add Bow Category" && $_POST['txtBoxBowCat'] != "")
    {
     $stmt = $db->prepare("INSERT into bowCategories (bow_category) VALUES (:bow_category) ");
     $stmt->execute(array(':bow_category' => $_POST['txtBoxBowCat']));
    }
  }
  
  if(isset($_GET['action']))
  {
      if($_GET['action']=="deleteTeam")
      {
        $stmt = $db->prepare("delete from teams where pk =:pk ");
        $stmt->execute(array(':pk' => $_GET['pk']));
      }
      else if ($_GET['action']=="deleteBowCat")
      {
        $stmt = $db->prepare("delete from bowcategories where pk =:pk ");
        $stmt->execute(array(':pk' => $_GET['pk']));
      }
  }
  
  ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="../js/jquery-ui.js" ></script>
        <link rel="stylesheet" href="../css/jquery-ui.css" />
        <link rel="stylesheet" href="../css/style_1.css" />
		<link rel="stylesheet" href="../css/scrolLBar.css" />
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<style>
			.table-striped > tbody > tr:nth-child(even) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
				background-color: #e3f2fd;
			}
		</style>
		
    </head>
    <body>
        <form class="form-horizontal" method="POST" >
			<div class="form-group">
				<label for="txtBoxTeamName" class="col-sm-2 control-label">Team Name:</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="txtBoxTeamName" name="txtBoxTeamName" placeholder="">
				</div>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-default" id="btnSubmit" name="btnSubmit" style="padding: 6px 12px; font-size:14px;" value="Add Team">Add Team</button>
				</div>			
			</div>
			<div class="form-group">
				<label for="txtBoxBowCat" class="col-sm-2 control-label">Bow Category:</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="txtBoxBowCat" name="txtBoxBowCat" placeholder="">
				</div>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-default" id="btnSubmit" name="btnSubmit" style="padding: 6px 12px; font-size:14px;"  value="Add Bow Category">Add Bow Category</button>
				</div>			
			</div>		
        </form>
        <?php
            $stmtSelect = $db->prepare("SELECT * from teams ");
            
            $stmtSelect->execute();

            $row_RecordsetTeam = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
            $cntRow = $stmtSelect -> rowCount();
            if($cntRow >0)
            {
        ?>
        <br>
        <table class="table">
            <tr><td><b>Team List</b>
            <table class="table table-condensed table-bordered table-striped table-hover">
            <!--tr>
                <td></td>
                <td></td>             
            </tr-->
            <?php
                $cnt = 1;
                foreach( $row_RecordsetTeam as $row)
                {  ?>
            <tr style="background-color:<?php //echo ($cnt%2==1 ? "#A1CCE4" : "#E9E5FD"); ?> ">
                <td><?php echo $cnt; ?></td>
                <td><?php echo $row['TeamCode'];   ?></td>
                <td><a href="ListAddTeam.php?action=deleteTeam&pk=<?php echo $row['pk']  ?>">
					<span title="Remove Team: <?php echo $row['TeamCode']; ?>" style="" class="pull-right showopacity glyphicon glyphicon-trash"></span>
				</a></td>
            </tr>    
            <?php
                $cnt++;
                }
            ?>
           </table></td>
           <td><b>Bow Categories</b>
               <table class="table table-condensed table-bordered table-striped table-hover">
                   <!--tr>
                       <td></td>
                       <td></td> 
                   </tr-->
                   <?php  
                    $stmtSelect = $db->prepare("SELECT * from bowcategories ");         
                    $stmtSelect->execute();
                    $row_RecordsetBowCat = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
                    $cnt2 = 1;
                    foreach ($row_RecordsetBowCat as $row)
                    {  ?>
                     <tr style="background-color:<?php //echo ($cnt2%2==1 ? "#A1CCE4" : "#E9E5FD"); ?> ">
                        <td><?php echo $cnt2; ?></td>
                        <td><?php echo $row['bow_category'];   ?></td>
                        <td><a href="ListAddTeam.php?action=deleteBowCat&pk=<?php echo $row['pk']  ?>">
							<span title="Remove Bow Category: <?php echo $row['bow_category'];   ?>" style="" class="pull-right showopacity glyphicon glyphicon-trash"></span>
						</a></td>
                    </tr>   
                    <?php  
                    $cnt2++;
                    }
                   ?>
               </table>
           </td>
            </tr>
        </table>
        <?php
            }
        ?>
    </body>
</html>
