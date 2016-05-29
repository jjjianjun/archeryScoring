<?php

include '../Connections/wifiAtt.php';
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'))
{
    if(isset($_POST['action']) && $_POST['action']=='checkArcherNo')
    {
        $AjaxSelectPlayer = $db->prepare("SELECT player_id from players where player_id = :player_id ");
        $AjaxSelectPlayer->execute(array(':player_id' => $_POST['archerNo']));
        $cntRow = $AjaxSelectPlayer -> rowCount();
        echo $cntRow;
    }
    else if(isset($_POST['action']) && $_POST['action']=='getArcherInfo')
    {
        $AjaxSelectPlayer = $db->prepare("SELECT player_name,player_gender,team,player_bow_cat from players where player_no = :player_no ");
        $AjaxSelectPlayer->execute(array(':player_no' => $_POST['archerNo']));
        $RecordSetPlayer = $AjaxSelectPlayer->fetch();
        $archerName = $RecordSetPlayer['player_name'];
        $archerGender = $RecordSetPlayer['player_gender'];
        $archerTeam = $RecordSetPlayer['team'];
        $archerCat = $RecordSetPlayer['player_bow_cat'];
        echo json_encode(array("archerName" => $archerName, "archerGender" => $archerGender, "archerTeam" => $archerTeam, "archerCat" => $archerCat));
    }
    else if(isset($_POST['action']) && $_POST['action']=='getArcherInfo')
    {
        $ajaxQry = $db->prepare("select COUNT(player_id) as cntPlayer from players where player_bow_cat = :player_bow_cat ");
        $ajaxQry->execute(array(':player_bow_cat'=>$_POST['slctCat']));
        $ajaxRecodSet = $ajaxQry->fetch();
        $playerQty = $ajaxRecodSet['cntPlayer'];
        echo $playerQty;
    }
    else if(isset($_POST['action']) && $_POST['action']=='countArcherAmount')
    {
        $archerAmount = fnCountArcherAmount($_POST['range_Id']);
        echo json_encode(array("archerAmount" => $archerAmount));
    }
    else if(isset($_POST['action']) && $_POST['action']=='countTeamAmount')
    {
        $teamAmount = fnCountTeamAmount($_POST['range_Id']);
        echo json_encode(array("teamAmount" => $teamAmount));
    }
}
if (isset($_GET['term'])){
    $return_arr = array();

    $archerNoQry = $db->prepare("SELECT player_no from players where player_no LIKE :player_no ");
    $archerNoQry->execute(array(':player_no'=> '%'.$_GET['term'].'%'));

    while($row = $archerNoQry->fetch())
    {
        $return_arr[] = $row['player_no'];
    }
    echo json_encode($return_arr);
}

function getPlayerScore($archerNo)
{
    global $db;

    $archerNoQry = $db->prepare("select sum(score) as PlayerScore ,players.player_name as archerName from scoring,players where scoring.archer_no = players.player_no and archer_no = :archer_no ");
    $archerNoQry->execute(array(':archer_no'=> $archerNo));

    $recordSet = $archerNoQry->fetch();

    //$playerScore = $recordSet['PlayerScore'];

    return $recordSet;
}

function getTop3Players($teamCode)
{
    global $db;

   $stmtSelScore = $db->prepare("select category.range_Id, category.categories, archer_no,players.player_name,players.team,sum(score) as totMark from scoring,players
   									JOIN category ON category.categories = players.player_bow_cat
                                    where scoring.archer_no = players.player_no and players.team = :player_team
                                    GROUP BY scoring.archer_no
                                    ORDER BY totMark desc
                                    limit 3 ");
    $stmtSelScore->execute(array(':player_team'=>$teamCode));
    $recordSet = $stmtSelScore->fetchAll(PDO::FETCH_ASSOC);

    return $recordSet;
}

function fnGetArcherInfo($archerNo)
{
    global $db;

    $qrySelPlayer = "select player_name,player_gender,team,player_bow_cat from players WHERE player_no = :archer_no ";
    $fetchQry = $db->prepare($qrySelPlayer);
    $fetchQry->execute(array(':archer_no'=> $archerNo));
    $recordSet = $fetchQry->fetch();

    return $recordSet;
}

function fnGetCategoryInfo($catId)
{
    global $db;

    $qrySelCat= "select categories, `range` from category where range_Id = :range_id ";
    $fetchQry = $db->prepare($qrySelCat);
    $fetchQry->execute(array(':range_id'=> $catId));
    $recordSet = $fetchQry->fetch();

    return $recordSet;

}

function fnGetExistingBowCat()
{
    global $db;

    $stmtSelect = $db->prepare("SELECT distinct(player_bow_cat) as ListBowCat from players Order by ListBowCat");
    $stmtSelect->execute();
    $recordSetCategory = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

    return $recordSetCategory;
}

function fnGetAllCategory()
{
    global $db;

	$stmtSelect = $db->prepare("SELECT COUNT(DISTINCT scoring.archer_no) AS archerAmount, category.categories, category.range, category.range_Id, category.shoot_qty
							FROM category
							INNER JOIN scoring ON scoring.range = category.range_Id
							GROUP BY scoring.range");
	$stmtSelect->execute();
	$recordSetCategory = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

    return $recordSetCategory;
}

function fnCountArcherAmount($range_Id)
{
	global $db;

	$stmtCountArcher = $db ->prepare ("SELECT COUNT(DISTINCT archer_no) AS archerAmount FROM scoring WHERE `range` = :range_Id");
	$stmtCountArcher->execute(array(':range_Id' => $range_Id));
	$recordCountArcher = $stmtCountArcher->fetch();
	$rowCountArcherAmount = $stmtCountArcher->rowCount();

	return $recordCountArcher['archerAmount'];
}

function fnCountTeamAmount($range_Id)
{
	global $db;

	$stmtCountTeam = $db ->prepare ("SELECT COUNT(DISTINCT teamName) AS teamAmount FROM teamscores WHERE teamCategory = :range_Id");
	//$stmtCountTeam = $db ->prepare ("SELECT DISTINCT teamName AS teamAmount FROM teamscores WHERE teamCategory = :range_Id");
	$stmtCountTeam->execute(array(':range_Id' => $range_Id));
	$recordCountTeam = $stmtCountTeam->fetch();
	$rowCountTeamAmount = $stmtCountTeam->rowCount();

	return $recordCountTeam['teamAmount'];
}
?>
