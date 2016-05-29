<?php
//include '../Connections/wifiAtt.php';
include '../generalFn/genericFn.php';
    fnClearTeamScore();

    $stmtSelect = $db->prepare("select distinct(team) as TeamName from players ");
    $stmtSelect->execute();
    $recordSetListTeam= $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

    foreach ($recordSetListTeam as $row) //only top 3 players from each team will be inserted into teamScore
    {
//        $stmtSelScore = $db->prepare("select archer_no,players.player_name,players.team,players.player_bow_cat,sum(score) as totMark from scoring,players
//                                    where scoring.archer_no = players.player_no and players.team = :player_team
//                                    GROUP BY scoring.archer_no
//                                    ORDER BY totMark desc
//                                    limit 3 ");
//        $stmtSelScore->execute(array(':player_team'=>$row['TeamName']));
        //$stmtSelScore->fetchAll(PDO::FETCH_ASSOC);
        $recordSetPlayerScore= getTop3Players($row['TeamName']);

        foreach ($recordSetPlayerScore as $rowPlayerScore)
        {
            $stmtinsertTeamScore = $db->prepare("insert into teamscores (memberArcherNo,memberScore,teamName,teamCategory) values (:memberArcherNo,:memberScore,:teamName,:range_Id)");
            $stmtinsertTeamScore->execute(array(':memberArcherNo'=>$rowPlayerScore['archer_no'],':memberScore'=>$rowPlayerScore['totMark'],':teamName'=>$rowPlayerScore['team'],':range_Id'=>$rowPlayerScore['range_Id']));
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>View Team Report</title>
		<link rel="shortcut icon" type="image/png" href="../images/favicon.png">		
	
        <link rel="stylesheet" href="../css/jquery-ui.css" />
        <link rel="stylesheet" href="../css/style_1.css" />

		<!--Bootstrap-->
		<link rel="stylesheet" href="../css/bootstrap.min.css">

        <script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="../js/jquery-ui.js" ></script>
    </head>
    <body>
        <div class="container">
        <form method="POST" target="_blank" action="teamScoreProcess.php">

            <?php
            $stmtSelect = $db->prepare("select bow_category from bowcategories ");
            $stmtSelect->execute();
            $recordSet= $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

            foreach ($recordSet as $row)
            {
                ?>

        <table class="table table-bordered table-condensed table-striped table-hover" border="0">				
            <tr style="background-color:#6EC1F8">
                <td style="width: 3%"><span class="glyphicon glyphicon-stats"></span></td>
                <td colspan='2'>Category : <?php echo $row['bow_category'] ?></td>
            </tr>
            <?php
            	// Get total marks for a team
               $qryScore = "select sum(memberScore) as TotalTeamScore, players.team as grpTeam from teamscores,players where teamscores.memberArcherNo = players.player_no and players.player_bow_cat = :player_bow_cat
                            GROUP BY players.team
                            ORDER BY TotalTeamScore desc";
               $stmtSelectTeam = $db->prepare($qryScore);
               $stmtSelectTeam->execute(array(':player_bow_cat'=>$row['bow_category']));
               $recordTeamScore= $stmtSelectTeam->fetchAll(PDO::FETCH_ASSOC);
			   $rowCount = $stmtSelectTeam -> rowCount();
               $cntRank = 1;
			   if($rowCount == 0) {
				   echo "<tr><td colspan='3'>No result.</td></tr>";
			   }
               foreach ($recordTeamScore as $rowTeamScore)
               {
                   ?>
            <tr style="background-color:<?php echo ($cntRank%2==1 ? "#FFFFFF" : "#e3f2fd") ?>">
                <td><b><?php echo $cntRank ?></b></td>
                <td><b><?php echo $rowTeamScore['grpTeam'] ?></b></td>
                <td><b><?php echo $rowTeamScore['TotalTeamScore'] ?></b></td>
            </tr>
              <?php
              	// Get total mark for individual whose mark ranks top 3 in own team
                $RecordSetPlayer = getTop3Players($rowTeamScore['grpTeam']);
                foreach ($RecordSetPlayer as $rowPlayers)
                {
              ?>
            <tr style="background-color:<?php echo ($cntRank%2==1 ? "#FFFFFF" : "#e3f2fd") ?>">
                <td>&nbsp;</td>
                <td>&nbsp;&nbsp;&nbsp;<?php echo $rowPlayers['archer_no']."--"; ?><?php echo $rowPlayers['player_name']; ?></td>
                <td><?php echo $rowPlayers['totMark']; ?></td>
            </tr>
            <?php
                }

               $cntRank++;
               }
            ?>
		</table>
		<br/>
            <!--tr>
                <td></td>
            </tr-->
            <?php
            }
            ?>

		</div>
        </form>
    </body>
</html>
<?php
 function fnClearTeamScore()
 {
     global $db;
     $stmtSelScore = $db->prepare("delete from teamscores");
     $stmtSelScore->execute();
 }

?>