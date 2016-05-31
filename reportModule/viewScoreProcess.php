<?php
include '../generalFn/genericFn.php';
if(isset($_POST))
{
    $strQueryRpt = "select archer_no, sum(score) as totalMark, SUM(cntX) as totalX, SUM(cnt10) as total10, SUM(cnt9) as total9, SUM(cntM) as totalM from scoring where `range` = :range 
                    GROUP BY archer_no
                    ORDER BY totalMark desc, totalX DESC, total10 DESC, total9 DESC, totalM";
    $stmtSelect = $db->prepare($strQueryRpt);           
    $stmtSelect->execute(array(':range' => $_POST['slctCat']));
    $recordSetRpt = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
    
    $recordSetcatInfo = fnGetCategoryInfo($_POST['slctCat']);
    $strCategory = $recordSetcatInfo['categories'];
    $strRange = $recordSetcatInfo['range'];
    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Individual Score Report</title>
		<link rel="shortcut icon" type="image/png" href="../images/favicon.png">
		
        <link rel="stylesheet" href="../css/jquery-ui.css" />
        <link rel="stylesheet" href="../css/style_1.css" />		
		<!--Bootstrap-->
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<style>
			.table-striped > tbody > tr:nth-child(odd) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
				background-color: #e3f2fd;
			}
		</style>		
		
        <script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="../js/jquery-ui.js" ></script>
    </head>
    <body><div class="container">
        <table class="table table-bordered table-striped table-hover">
			<thead>
            <tr>
                <th colspan="9" style="font-weight:bold;"><?php echo $strCategory."-".$strRange;  ?></th>
            </tr>
            <tr style="background-color:#FFFFFF; font-weight:bold;">
                <th>Rank</th>
                <th>Archer No</th>
                <th>Archer Name</th>
                <th>Team</th>
                <th class="rptColumn">Total Score</th>
                <th class="rptColumn" style="display:none;">X</th>
                <th class="rptColumn">10</th>
                <th class="rptColumn">9</th>
                <th class="rptColumn">Miss</th>
            </tr>
			</thead>
			<tbody>
            <?php
            $rankCounter = 1;
            foreach ($recordSetRpt as $eachRow)
            {
                $recordSetArcher = fnGetArcherInfo($eachRow['archer_no']);
            ?>
            <tr style="background-color:<?php //echo ($rankCounter%2==1 ? "#A1CCE4" : "#E9E5FD"); ?>; cursor: pointer;">
                <td><?php echo $rankCounter;  ?></td>
                <td style="text-align: center"><?php echo $eachRow['archer_no'] ?></td>
                <td><?php echo $recordSetArcher['player_name'] ?></td>
                <td><?php echo $recordSetArcher['team'] ?></td>
                <td class="rptColumn"><?php echo $eachRow['totalMark'] ?></td>
                <td class="rptColumn" style="display:none;"><?php echo $eachRow['totalX'] ?></td>
                <td class="rptColumn"><?php echo $eachRow['total10'] ?></td>
                <td class="rptColumn"><?php echo $eachRow['total9'] ?></td>
                <td class="rptColumn"><?php echo $eachRow['totalM'] ?></td>
            </tr>
            <?php
            $rankCounter++;
            }
            ?>
        <?php
           $strHtml = "<table>
            <tr>
                <td>Rank</td>
                <td>Archer No</td>
                <td>Archer Name</td>
                <td>Team</td>
                <td>Total Score</td>
                <td>X</td>
                <td>10</td>
                <td>9</td>
                <td>Miss</td>
            </tr>
            <tr>
                
            </tr>
        </table> ";
        ?>
		</tbody>
        </table>
        </div>
    </body>
</html>
