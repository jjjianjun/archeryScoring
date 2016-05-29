<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Assign Archer Number</title>
		<link rel="shortcut icon" type="image/png" href="../images/favicon.png">	
		
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
		
		<!-- Scroll Bar -->
		<link rel="stylesheet" href="../css/scrollBar.css" />
    </head>
    <body>
	<div class="container" style="width:1000px;">
        <table class="table table-bordered table-condensed table-striped table-hover">
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
$alphCnt = 'A';
foreach($rekodSetsBowCat as $row)
{
	//$alphCnt = 'A';
	$queryAllPlayer = "select player_id from players where player_bow_cat = '".$row['bow_category']."'";
	$allPlayer = mysqli_query($wifiAtt, $queryAllPlayer);
	//$row_RecordsetPlayers = mysqli_fetch_all($allPlayer,MYSQLI_ASSOC);
	$cntPlayer = mysqli_num_rows($allPlayer);
	$recommendedLane= ceil(($cntPlayer/3));

	$querySortedPlayer = "select * from players where player_bow_cat = '".$row['bow_category']."' ORDER BY player_bow_cat desc,player_gender desc, team asc";
	$allPlayer = mysqli_query($wifiAtt, $querySortedPlayer);
	$row_RecordsetPlayers = mysqli_fetch_all($allPlayer, MYSQLI_ASSOC);
	
	$currCounter = $mainCounter+1;
	$limitLane = 1;
	$currMax = 0;
	/* foreach($row_RecordsetPlayers as $rowPlayers)
	{
		$archerNo = $currCounter.$alphCnt;
                
                ?>
            <tr style="background-color:<?php //echo ($cnt%2==1 ? "#A1CCE4" : "#E9E5FD"); ?>">
                <td align="center"><input type="text" id="<?php echo $archerNo; ?>" class="form-control" style="width:60px;" name="<?php echo $archerNo; ?>" value="<?php echo $archerNo; ?>"></td>
                <td><?php echo $rowPlayers['player_name'];  ?></td>
                <td><?php echo $rowPlayers['player_gender'];  ?></td>
                <td><?php echo $rowPlayers['player_bow_cat'];  ?></td>
                <td><?php echo $rowPlayers['team'];  ?></td>
            </tr>    
            
            <?php
//		echo $archerNo;
//                echo "<br>";
		if($limitLane == $recommendedLane)
		{
			$currMax = $currCounter; 
			$currCounter = $mainCounter+1;
			$alphCnt++;
			$limitLane = 1;
                   
		}
		else
		{
			$currCounter++;
			$limitLane++;
                   
		}
		if(isset($_POST['btnSave']))
		{
		  fnAssignArcherNo($rowPlayers['player_id'], $_POST[$archerNo]);
		  header("Location:viewListArchersInfo.php");
		}
		$cnt++;
	}
	$mainCounter = $currMax; */
	$laneNum = 20;
	foreach($row_RecordsetPlayers as $rowPlayers) 
	{
		$archerNo = $currCounter.$alphCnt;
                
        ?>
			<tr>
				<td align="center"><input type="text" id="<?php echo $archerNo; ?>" class="form-control" style="width:60px;" name="<?php echo $archerNo; ?>" value="<?php echo $archerNo; ?>" maxLength="3"></td>
				<td><?php echo $rowPlayers['player_name'];  ?></td>
				<td><?php echo $rowPlayers['player_gender'];  ?></td>
				<td><?php echo $rowPlayers['player_bow_cat'];  ?></td>
				<td><?php echo $rowPlayers['team'];  ?></td>
			</tr>    
            
        <?php
		if($currCounter == $laneNum)
		{
			//$currMax = $currCounter; 
			//$currCounter = $mainCounter+1;
			$currCounter = 1;
			$alphCnt++;
			//$limitLane = 1;
		}
		else
		{
			$currCounter++;
			$limitLane++;
		}
		if(isset($_POST['btnSave']))
		{
		  fnAssignArcherNo($rowPlayers['player_id'], $_POST[$archerNo]);
		  header("Location:viewListArchersInfo.php");
		}
		$cnt++;
	}
	$alphCnt++;		
}

?>
		</tbody>
            <tr>
                <td colspan="5" align="center">
					<input type="submit" class="btn btn-default" id="btnSave" name="btnSave" value="Save">
				</td>
            </tr>
            </form>
        </table>
		</div>
    </body>
</html>
