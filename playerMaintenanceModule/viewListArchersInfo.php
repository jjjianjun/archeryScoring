<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>View List of Archer Info</title>
		<link rel="shortcut icon" type="image/png" href="../images/favicon.png">	
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<style>
			.table-striped > tbody > tr:nth-child(even) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
				background-color: #e3f2fd;
			}
		</style>
		
		<!-- Scroll Bar -->
		<link rel="stylesheet" href="../css/scrollBar.css" />		
    </head>
    <body>
	<div class="container" style="width:1000px;">
         <table class="table table-bordered table-striped table-hover">
            <form class="form-horizontal" method="POST">
            <thead>
            <tr>
                <th>Archer No</th>
                <th>Archer Name</th>
                <th>Gender</th>
                <th>Category</th>
                <th>Team</th>
            </tr>
            </thead>
			<tbody>
         <?php
include '../Connections/dbConnMysqli.php';

$qryBowCat = "Select bow_category from bowcategories";
$allBowCat = mysqli_query($wifiAtt,$qryBowCat);
$rekodSetsBowCat = mysqli_fetch_all($allBowCat,MYSQLI_ASSOC);

$mainCounter = 0;
$cnt=1;
foreach($rekodSetsBowCat as $row)
{


	$querySortedPlayer = "select * from players where player_bow_cat = '".$row['bow_category']."' ORDER BY player_bow_cat desc,player_gender desc, team asc";
	$allPlayer = mysqli_query($wifiAtt, $querySortedPlayer);
	$row_RecordsetPlayers = mysqli_fetch_all($allPlayer,MYSQLI_ASSOC);

	foreach($row_RecordsetPlayers as $rowPlayers)
	{		           
                ?>
            <tr style="background-color:<?php //echo ($cnt%2==1 ? "#A1CCE4" : "#E9E5FD"); ?>">
                <td><?php echo $rowPlayers['player_no']; ?>  </td>
                <td><?php echo $rowPlayers['player_name'];  ?></td>
                <td><?php echo $rowPlayers['player_gender'];  ?></td>
                <td><?php echo $rowPlayers['player_bow_cat'];  ?></td>
                <td><?php echo $rowPlayers['team'];  ?></td>
            </tr>    
       <?php
        $cnt++;
	}  ?>
            
<?php	
}
?>
		<tbody>
		</table>
	</div>
    </body>
</html>
