<?php

include '../Connections/wifiAtt.php';

	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
		if(isset($_POST['action']) && $_POST['action']=='getORArcherInfo') {
			$AjaxSelectPlayer = $db->prepare("SELECT player_name,player_gender,team,player_bow_cat from players where player_no = :player_no ");
			$AjaxSelectPlayer->execute(array(':player_no' => $_POST['archerNo']));
			$RecordSetPlayer = $AjaxSelectPlayer->fetch();
			$archerName = $RecordSetPlayer['player_name'];
			$archerGender = $RecordSetPlayer['player_gender'];
			$archerTeam = $RecordSetPlayer['team'];
			$archerCat = $RecordSetPlayer['player_bow_cat'];
			$archerScoreOR = array("1","2","3","4","5","6","7","8","9","10","11","12"); 
			$archerScoreOR = getArcherScoreOR($_POST['archerNo'], $_POST['range_Id'], $_POST['selectedRoundNum'], $_POST['arrowNo']);
			echo json_encode(array("archerName" => $archerName, "archerGender" => $archerGender, "archerTeam" => $archerTeam, "archerCat" => $archerCat, "archerScoreOR" => $archerScoreOR));		
			//echo json_encode(array("archerName" => $archerName, "archerGender" => $archerGender, "archerTeam" => $archerTeam, "archerCat" => $archerCat));						
		}
		else if(isset($_POST['action']) && $_POST['action']=='saveArcherScoreOR') {
			$archer_no = $_POST['archerNo'];
			$selectedRoundNum = $_POST['selectedRoundNum'];
			$range_Id = $_POST['range_Id']; 
			$jsonStringScoreORArray = $_POST['jsonStringScoreORArray']; 
			$scoreORArray = json_decode(stripslashes($jsonStringScoreORArray));
			$Nth_arrow = 1;
			$affectedRowCount = 0;
			foreach($scoreORArray as $score) {
				$affectedRowCount += saveArcherScoreOR($archer_no, $range_Id, $selectedRoundNum, $score, $Nth_arrow);
				$Nth_arrow++;
			}
			echo json_encode(array("affectedRowCount" => $affectedRowCount));
		}
		else if(isset($_POST['action']) && $_POST['action']=='getIndvRoundWinner') {
			$playerA = $_POST['playerA'];
			$playerB = $_POST['playerB'];
			$round_no = $_POST['round_no'];
			$range_Id = $_POST['range_Id']; 
			$arrowNo = $_POST['arrowNo'];
			
			//$winner = getIndvRoundWinner($playerA, $playerB, $round_no, $range_Id);
			$resultArray = getIndvRoundWinner($playerA, $playerB, $round_no, $range_Id, $arrowNo);
			
			//echo json_encode(array("winner_archer_no" => $winner['archer_no'], "winner_totalScore" => $winner['totalScore']));
			//echo json_encode(array("winner_archer_no" => $resultArray[2]['archer_no'], "winner_totalScore" => $resultArray[2]['totalScore'], 
			//"playerATotalScore" => $resultArray[0]['totalScore'], "playerBTotalScore" => $resultArray[1]['totalScore'], "winner_info" => $resultArray[2]));
			echo json_encode(array("winner" => $resultArray[2], "playerA" => $resultArray[0], "playerB" => $resultArray[1]));			
		}	
		else if(isset($_POST['action']) && $_POST['action']=='getORTeamInfo') {
			$teamMembersList = array();
			$teamMembersList = getORTeamMembers($_POST['teamName']);
			$teamScoreOR = array("","","","","","","","","","","",""); 
			$teamScoreOR = getTeamScoreOR($_POST['teamName'], $_POST['range_Id'], $_POST['selectedRoundNum'], $_POST['arrowNo']);
			//echo json_encode(array("teamScoreOR" => $teamScoreOR));		
			echo json_encode(array("teamScoreOR" => $teamScoreOR, "teamMembers" => $teamMembersList));		
		}		
		else if(isset($_POST['action']) && $_POST['action']=='saveTeamScoreOR') {
			$teamName = $_POST['teamName'];
			$selectedRoundNum = $_POST['selectedRoundNum'];
			$range_Id = $_POST['range_Id']; 
			$jsonStringScoreORArray = $_POST['jsonStringScoreORArray']; 
			$scoreORArray = json_decode(stripslashes($jsonStringScoreORArray));
			$Nth_arrow = 1;
			$affectedRowCount = 0;
			foreach($scoreORArray as $score) {
				$affectedRowCount += saveTeamScoreOR($teamName, $range_Id, $selectedRoundNum, $score, $Nth_arrow);
				$Nth_arrow++;
			}
			echo json_encode(array("affectedRowCount" => $affectedRowCount));
		}
		else if(isset($_POST['action']) && $_POST['action']=='getTeamRoundWinner') {
			$teamA = $_POST['teamA'];
			$teamB = $_POST['teamB'];
			$round_no = $_POST['round_no'];
			$range_Id = $_POST['range_Id']; 
			$arrowNo = $_POST['arrowNo'];
			
			$resultArray = getTeamRoundWinner($teamA, $teamB, $round_no, $range_Id, $arrowNo);
			
			//echo json_encode(array("winner_archer_no" => $winner['archer_no'], "winner_totalScore" => $winner['totalScore']));
			echo json_encode(array("winner_archer_no" => $resultArray[2]['teamName'], "winner_totalScore" => $resultArray[2]['totalScore'], 
			"teamATotalScore" => $resultArray[0]['totalScore'], "teamBTotalScore" => $resultArray[1]['totalScore']));
		}			
		else {
			echo json_encode(array("archerName" => "jj", "archerGender" => "male", "archerTeam" => "No team", "archerCat" => "No cat"));	
		}
	}
	
	if (isset($_GET['term'])){
		
	}
	
	function getArcherScoreOR($archer_no, $range_Id, $selectedRoundNum, $arrowNo) {
	$hostname_wifiAtt = "localhost";
	$database_wifiAtt = "archery_scoring_2015";
	$username_wifiAtt = "root";
	$password_wifiAtt = "abc123";

    $db = new PDO("mysql:host=$hostname_wifiAtt;dbname=archery_scoring_2015", $username_wifiAtt, $password_wifiAtt);		
		$qryGetScoreOR = "SELECT score FROM individualscoresor
						WHERE archer_no = :archer_no AND range_Id = :range_Id AND round_no = :round_no AND Nth_arrow <= :Nth_arrow
						ORDER BY Nth_arrow ASC
						LIMIT :arrowNo";
		//$qryGetScoreOR = "SELECT * FROM individualscoresor WHERE archer_no = :archer_no AND round_no = :round_no AND range_Id = :range_Id";				
		$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false ); // by turning emulation mode off (as MySQL can sort all placeholders properly) to solve error in LIMIT
		$stmtGetScoreOR = $db->prepare($qryGetScoreOR);
		$stmtGetScoreOR->execute(array(':archer_no' => $archer_no, ':range_Id' => $range_Id, ':round_no' => $selectedRoundNum, ':Nth_arrow' => $arrowNo, ':arrowNo' => $arrowNo));
		//$stmtGetScoreOR->execute(array(':archer_no' => '1A', ':range_Id' => '1', ':round_no' => '1/64'));
		//$stmtGetScoreOR->execute(array(':archer_no' => '1A', ':round_no' => '1/64', ':range_Id' => '1'));
		$recordGetScoreOR = $stmtGetScoreOR->fetchAll(PDO::FETCH_ASSOC);
		$cntRowGetScoreOR = $stmtGetScoreOR -> rowCount();
		$archerScoreOR = array("","","","","","","","","","","","");
		$index = 0;
		foreach($recordGetScoreOR as $rowGetScoreOR) {
			$archerScoreOR[$index] = $rowGetScoreOR['score'];
			$index++;
		}
/* 		while($rowGetScoreOR = $stmtGetScoreOR->fetch()) {
			$archerScoreOR[$index] = $rowGetScoreOR['score'];
			$index++;
		} */
		return $archerScoreOR;
		//return $cntRowGetScoreOR;
	}	
	
	function saveArcherScoreOR($archer_no, $range_Id, $selectedRoundNum, $score, $Nth_arrow) {
	$hostname_wifiAtt = "localhost";
	$database_wifiAtt = "archery_scoring_2015";
	$username_wifiAtt = "root";
	$password_wifiAtt = "abc123";

    $db = new PDO("mysql:host=$hostname_wifiAtt;dbname=archery_scoring_2015", $username_wifiAtt, $password_wifiAtt);	
		
 		$qryDeleteScoreOR = "DELETE FROM individualscoresor
						WHERE archer_no = :archer_no AND range_Id = :range_Id AND round_no = :round_no AND Nth_arrow = :Nth_arrow"; 
		//$qryDeleteScoreOR = "DELETE FROM individualscoresor
		//				WHERE archer_no = :archer_no AND range_Id = :range_Id AND round_no = :round_no";						
		$stmtDeleteScoreOR = $db->prepare($qryDeleteScoreOR);
		//$stmtDeleteScoreOR->execute(array(':archer_no' => $archer_no, ':range_Id' => $range_Id, ':round_no' => $selectedRoundNum));
		$stmtDeleteScoreOR->execute(array(':archer_no' => $archer_no, ':range_Id' => $range_Id, ':round_no' => $selectedRoundNum, ':Nth_arrow' => $Nth_arrow));
		$deletedRowCount = $stmtDeleteScoreOR->rowCount();
		
		//$cntX = fnCntFreq($score,"X");
		$cntX = 0;
		$cnt10 = fnCntFreq($score, "10");
		$cnt9 = fnCntFreq($score, "9");
		$cntM = fnCntFreq($score, "M");
		
		$qryInsertScoreOR = "INSERT INTO individualscoresor 
						VALUES(:archer_no, :range_Id, :round_no, :Nth_arrow, :score, :cntX, :cnt10, :cnt9, :cntM)";
		$stmtInsertScoreOR = $db->prepare($qryInsertScoreOR);
		$stmtInsertScoreOR->execute(array(':archer_no'=>$archer_no, ':range_Id'=>$range_Id, ':round_no'=>$selectedRoundNum, 
		':Nth_arrow'=>$Nth_arrow, ':score'=>checkMark($score), ':cntX'=>$cntX, ':cnt10'=>$cnt10, ':cnt9'=>$cnt9, ':cntM'=>$cntM));
		$addedRowCount = $stmtInsertScoreOR->rowCount();
		return ($addedRowCount+$deletedRowCount);
	}
	
	function getIndvRoundWinner($playerA, $playerB, $round_no, $range_Id, $arrowNo) {	
		global $db;
		
		// select playerA
		$qrySelectPlayerA = "SELECT SUM(individualscoresor.score) AS totalScore, SUM(cntX) as totalX, SUM(cnt10) as total10, SUM(cnt9) as total9, SUM(cntM) as totalM,
					individualscoresor.archer_no, players.player_name FROM individualscoresor
					JOIN players ON individualscoresor.archer_no = players.player_no
					WHERE individualscoresor.range_Id = :range_Id AND individualscoresor.round_no = :round_no AND individualscoresor.archer_no = :playerA AND individualscoresor.Nth_arrow <= :arrowNo
					GROUP BY individualscoresor.archer_no
					LIMIT :winnerNo";
		$stmtSelectPlayerA = $db->prepare($qrySelectPlayerA);
		$stmtSelectPlayerA->bindParam(':playerA', $playerA, PDO::PARAM_STR);
		$stmtSelectPlayerA->bindParam(':round_no', $round_no, PDO::PARAM_STR);
		$stmtSelectPlayerA->bindParam(':range_Id', $range_Id, PDO::PARAM_STR);
		$winnerNo = 1;
		$stmtSelectPlayerA->bindValue(':arrowNo', (int)$arrowNo, PDO::PARAM_INT);
		$stmtSelectPlayerA->bindValue(':winnerNo', (int)$winnerNo, PDO::PARAM_INT);
		$stmtSelectPlayerA->execute();
		
		$arraySelectRoundWinner = array();	
		for($index=0; $index<3; $index++) {
			$arraySelectRoundWinner[$index]['archer_no'] = "No winner";
			$arraySelectRoundWinner[$index]['player_name'] = "";
			$arraySelectRoundWinner[$index]['totalScore'] = 0;
			$arraySelectRoundWinner[$index]['totalX'] = "0";	
			$arraySelectRoundWinner[$index]['total10'] = "0";
			$arraySelectRoundWinner[$index]['total9'] = "0";
			$arraySelectRoundWinner[$index]['totalM'] = "0";			
		}
		
		// select playerB
		$qrySelectPlayerB = "SELECT SUM(individualscoresor.score) AS totalScore, SUM(cntX) as totalX, SUM(cnt10) as total10, SUM(cnt9) as total9, SUM(cntM) as totalM,
					individualscoresor.archer_no, players.player_name FROM individualscoresor
					JOIN players ON individualscoresor.archer_no = players.player_no
					WHERE individualscoresor.range_Id = :range_Id AND individualscoresor.round_no = :round_no AND individualscoresor.archer_no = :playerB AND individualscoresor.Nth_arrow <= :arrowNo
					GROUP BY individualscoresor.archer_no
					LIMIT :winnerNo";
		$stmtSelectPlayerB = $db->prepare($qrySelectPlayerB);
		$stmtSelectPlayerB->bindParam(':playerB', $playerB, PDO::PARAM_STR);
		$stmtSelectPlayerB->bindParam(':round_no', $round_no, PDO::PARAM_STR);
		$stmtSelectPlayerB->bindParam(':range_Id', $range_Id, PDO::PARAM_STR);
		$winnerNo = 1;
		$stmtSelectPlayerB->bindValue(':arrowNo', (int)$arrowNo, PDO::PARAM_INT);
		$stmtSelectPlayerB->bindValue(':winnerNo', (int)$winnerNo, PDO::PARAM_INT);
		$stmtSelectPlayerB->execute();
		
		$cntRowSelectPlayerA = $stmtSelectPlayerA -> rowCount(); 
		if($cntRowSelectPlayerA > 0) {
			$recordSelectPlayerA = $stmtSelectPlayerA->fetch();
			$arraySelectRoundWinner[0]['archer_no'] = $recordSelectPlayerA['archer_no'];
			$arraySelectRoundWinner[0]['player_name'] = $recordSelectPlayerA['player_name'];
			$arraySelectRoundWinner[0]['totalScore'] = $recordSelectPlayerA['totalScore'];
			$arraySelectRoundWinner[0]['totalX'] = $recordSelectPlayerA['totalX'];	
			$arraySelectRoundWinner[0]['total10'] = $recordSelectPlayerA['total10'];
			$arraySelectRoundWinner[0]['total9'] = $recordSelectPlayerA['total9'];
			$arraySelectRoundWinner[0]['totalM'] = $recordSelectPlayerA['totalM'];
		}
		
		$cntRowSelectPlayerB = $stmtSelectPlayerB -> rowCount(); 		
		if($cntRowSelectPlayerB > 0) {
			$recordSelectPlayerB = $stmtSelectPlayerB->fetch();
			$arraySelectRoundWinner[1]['archer_no'] = $recordSelectPlayerB['archer_no'];
			$arraySelectRoundWinner[1]['player_name'] = $recordSelectPlayerB['player_name'];
			$arraySelectRoundWinner[1]['totalScore'] = $recordSelectPlayerB['totalScore'];
			$arraySelectRoundWinner[1]['totalX'] = $recordSelectPlayerB['totalX'];	
			$arraySelectRoundWinner[1]['total10'] = $recordSelectPlayerB['total10'];
			$arraySelectRoundWinner[1]['total9'] = $recordSelectPlayerB['total9'];
			$arraySelectRoundWinner[1]['totalM'] = $recordSelectPlayerB['totalM'];			
		}
		
		// Decide winner value
		if($arraySelectRoundWinner[0]['totalScore'] > 0 && $arraySelectRoundWinner[1]['totalScore'] > 0) {
			if($arraySelectRoundWinner[0]['totalScore'] > $arraySelectRoundWinner[1]['totalScore']) {
				$arraySelectRoundWinner[2]['archer_no'] = $arraySelectRoundWinner[0]['archer_no'];
				$arraySelectRoundWinner[2]['player_name'] = $arraySelectRoundWinner[0]['player_name'];
				$arraySelectRoundWinner[2]['totalScore'] = $arraySelectRoundWinner[0]['totalScore'];
			}
			else if($arraySelectRoundWinner[1]['totalScore'] > $arraySelectRoundWinner[0]['totalScore']) {
				$arraySelectRoundWinner[2]['archer_no'] = $arraySelectRoundWinner[1]['archer_no'];
				$arraySelectRoundWinner[2]['player_name'] = $arraySelectRoundWinner[1]['player_name'];
				$arraySelectRoundWinner[2]['totalScore'] = $arraySelectRoundWinner[1]['totalScore'];			
			}
			else if( $arraySelectRoundWinner[1]['totalScore'] == $arraySelectRoundWinner[0]['totalScore']) {
				$winnerIndex = fnCompareFreq($arraySelectRoundWinner[0], $arraySelectRoundWinner[1]);
				if($winnerIndex == 0) {
					$arraySelectRoundWinner[2]['archer_no'] = $arraySelectRoundWinner[0]['archer_no'];
					$arraySelectRoundWinner[2]['player_name'] = $arraySelectRoundWinner[0]['player_name'];
					$arraySelectRoundWinner[2]['totalScore'] = $arraySelectRoundWinner[0]['totalScore'];	
				}
				else if($winnerIndex == 1) {
					$arraySelectRoundWinner[2]['archer_no'] = $arraySelectRoundWinner[1]['archer_no'];
					$arraySelectRoundWinner[2]['player_name'] = $arraySelectRoundWinner[1]['player_name'];
					$arraySelectRoundWinner[2]['totalScore'] = $arraySelectRoundWinner[1]['totalScore'];	
				}					
			}		
		}
		else if($arraySelectRoundWinner[0]['totalScore'] == 0 && $arraySelectRoundWinner[1]['totalScore'] > 0) {
			$arraySelectRoundWinner[2]['archer_no'] = $arraySelectRoundWinner[1]['archer_no'];
			$arraySelectRoundWinner[2]['player_name'] = $arraySelectRoundWinner[1]['player_name'];
			$arraySelectRoundWinner[2]['totalScore'] = $arraySelectRoundWinner[1]['totalScore'];			
		}
		else if($arraySelectRoundWinner[0]['totalScore'] > 0 && $arraySelectRoundWinner[1]['totalScore'] == 0) {
			$arraySelectRoundWinner[2]['archer_no'] = $arraySelectRoundWinner[0]['archer_no'];
			$arraySelectRoundWinner[2]['player_name'] = $arraySelectRoundWinner[0]['player_name'];
			$arraySelectRoundWinner[2]['totalScore'] = $arraySelectRoundWinner[0]['totalScore'];			
		}		
		return $arraySelectRoundWinner;
	}
	
	function checkMark($strMark)
	{
		$mark = 0;
		if($strMark == null ||  $strMark == '' || $strMark == 'M' || $strMark == 'm')
			$mark = 0;
		else if(strtoupper($strMark) == 'X')
			$mark = 10;        
		else
			$mark = $strMark;
		
		return $mark;
	}
	
	function fnCntFreq($strMark,$toBeCompared)
	{
		$cntX = 0;
		if(strtoupper($strMark) == $toBeCompared)
			$cntX = 1;
		
		return $cntX;
	}
	
	function fnCompareFreq($playerA, $playerB) {
		$winnerIndex;
		if($playerA['totalX'] > $playerB['totalX']) {
			$winnerIndex = 0;
		}
		else if($playerB['totalX'] > $playerA['totalX']) {
			$winnerIndex = 1;
		}
		else if($playerA['totalX'] == $playerB['totalX']) {
			if($playerA['total10'] > $playerB['total10']) {
				$winnerIndex = 0;
			}
			else if($playerB['total10'] > $playerA['total10']) {
				$winnerIndex = 1;
			}
			else if($playerA['total10'] == $playerB['total10']) {
				if($playerA['total9'] > $playerB['total9']) {
					$winnerIndex = 0;
				}
				else if($playerB['total9'] > $playerA['total9']) {
					$winnerIndex = 1;
				}
				else if($playerA['total9'] == $playerB['total9']) {
					if($playerA['totalM'] < $playerB['totalM']) {
						$winnerIndex = 0;
					}
					else if($playerB['totalM'] < $playerA['totalM']) {
						$winnerIndex = 1;
					}
					else if($playerA['totalM'] == $playerB['totalM']) {
						$winnerIndex = 0;
					}
				}
			}
		}
		
		return $winnerIndex;
	}

	function getIndvRoundWinner_ORI($playerA, $playerB, $round_no, $range_Id) {
		global $db;
		$qrySelectRoundWinner = "SELECT SUM(individualscoresor.score) AS totalScore, SUM(cntX) as totalX, SUM(cnt10) as total10, SUM(cnt9) as total9, SUM(cntM) as totalM,
					individualscoresor.archer_no, players.player_name FROM individualscoresor
					JOIN players ON individualscoresor.archer_no = players.player_no
					WHERE individualscoresor.range_Id = :range_Id AND individualscoresor.round_no = :round_no AND (individualscoresor.archer_no = :playerA OR individualscoresor.archer_no = :playerB)
					GROUP BY individualscoresor.archer_no
					LIMIT :winnerNo";
		$stmtSelectRoundWinner = $db->prepare($qrySelectRoundWinner);
		$stmtSelectRoundWinner->bindParam(':playerA', $playerA, PDO::PARAM_STR);
		$stmtSelectRoundWinner->bindParam(':playerB', $playerB, PDO::PARAM_STR);
		$stmtSelectRoundWinner->bindParam(':round_no', $round_no, PDO::PARAM_STR);
		$stmtSelectRoundWinner->bindParam(':range_Id', $range_Id, PDO::PARAM_STR);
		$winnerNo = 1;
		$stmtSelectRoundWinner->bindValue(':winnerNo', (int)$winnerNo, PDO::PARAM_INT);
		$stmtSelectRoundWinner->execute();
		
		//$recordSelectRoundWinner = $stmtSelectRoundWinner->fetchAll(PDO::FETCH_ASSOC);
		$recordSelectRoundWinner = $stmtSelectRoundWinner->fetch();
		$cntRow = $stmtSelectRoundWinner -> rowCount(); 	
		
		if($cntRow == 0) {
			$recordSelectRoundWinner = array();
			$recordSelectRoundWinner['archer_no'] = "No winner";
			$recordSelectRoundWinner['player_name'] = "";
			$recordSelectRoundWinner['totalScore'] = "0";		
		}
		//return $recordSelectRoundWinner['archer_no'];
		return $recordSelectRoundWinner;
	}	

	function getTeamScoreOR($teamName, $range_Id, $selectedRoundNum, $arrowNo) {
	$hostname_wifiAtt = "localhost";
	$database_wifiAtt = "archery_scoring_2015";
	$username_wifiAtt = "root";
	$password_wifiAtt = "abc123";

    $db = new PDO("mysql:host=$hostname_wifiAtt;dbname=archery_scoring_2015", $username_wifiAtt, $password_wifiAtt);		
		$qryGetScoreOR = "SELECT score FROM teamscoresor
						WHERE teamName = :teamName AND range_Id = :range_Id AND round_no = :round_no AND Nth_arrow <= :Nth_arrow
						ORDER BY Nth_arrow ASC
						LIMIT :arrowNo";
		//$qryGetScoreOR = "SELECT * FROM teamscoresor WHERE teamName = :teamName AND round_no = :round_no AND range_Id = :range_Id";	
		$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false ); // by turning emulation mode off (as MySQL can sort all placeholders properly) to solve error in LIMIT
		$stmtGetScoreOR = $db->prepare($qryGetScoreOR);
		$stmtGetScoreOR->execute(array(':teamName' => $teamName, ':range_Id' => $range_Id, ':round_no' => $selectedRoundNum, ':Nth_arrow' => $arrowNo, ':arrowNo' => $arrowNo));
		//$stmtGetScoreOR->bindValue(':arrowNo', (int)$arrowNo, PDO::PARAM_INT); // or by binding and setting proper type (PDO::PARAM_INT) explicitly to solve error in LIMIT
		$recordGetScoreOR = $stmtGetScoreOR->fetchAll(PDO::FETCH_ASSOC);
		$cntRowGetScoreOR = $stmtGetScoreOR -> rowCount();
		$teamScoreOR = array("","","","","","","","","","","","");
		$index = 0;
		foreach($recordGetScoreOR as $rowGetScoreOR) {
			$teamScoreOR[$index] = $rowGetScoreOR['score'];
			$index++;
		}
/* 		while($rowGetScoreOR = $stmtGetScoreOR->fetch()) {
			$teamScoreOR[$index] = $rowGetScoreOR['score'];
			$index++;
		} */
		return $teamScoreOR;
		//return $cntRowGetScoreOR;
	}	
	
	function saveTeamScoreOR($teamName, $range_Id, $selectedRoundNum, $score, $Nth_arrow) {
		global $db;
		
 		$qryDeleteScoreOR = "DELETE FROM teamscoresor
						WHERE teamName = :teamName AND range_Id = :range_Id AND round_no = :round_no AND Nth_arrow = :Nth_arrow"; 
		//$qryDeleteScoreOR = "DELETE FROM individualscoresor
		//				WHERE teamName = :teamName AND range_Id = :range_Id AND round_no = :round_no";						
		$stmtDeleteScoreOR = $db->prepare($qryDeleteScoreOR);
		//$stmtDeleteScoreOR->execute(array(':teamName' => $teamName, ':range_Id' => $range_Id, ':round_no' => $selectedRoundNum));
		$stmtDeleteScoreOR->execute(array(':teamName' => $teamName, ':range_Id' => $range_Id, ':round_no' => $selectedRoundNum, ':Nth_arrow' => $Nth_arrow));
		$deletedRowCount = $stmtDeleteScoreOR->rowCount();
		
		$cntX = fnCntFreq($score,"X");
		$cntX = 0;
		$cnt10 = fnCntFreq($score, "10");
		$cnt9 = fnCntFreq($score, "9");
		$cntM = fnCntFreq($score, "M");
		
		$qryInsertScoreOR = "INSERT INTO teamscoresor 
						VALUES(:teamName, :range_Id, :round_no, :Nth_arrow, :score, :cntX, :cnt10, :cnt9, :cntM)";
		$stmtInsertScoreOR = $db->prepare($qryInsertScoreOR);
		$stmtInsertScoreOR->execute(array(':teamName'=>$teamName, ':range_Id'=>$range_Id, ':round_no'=>$selectedRoundNum, 
		':Nth_arrow'=>$Nth_arrow, ':score'=>checkMark($score), ':cntX'=>$cntX, ':cnt10'=>$cnt10, ':cnt9'=>$cnt9, ':cntM'=>$cntM));
		$addedRowCount = $stmtInsertScoreOR->rowCount();
		return ($addedRowCount+$deletedRowCount);
	}	
	
	function getTeamRoundWinner($teamA, $teamB, $round_no, $range_Id,$arrowNo) {	
	$hostname_wifiAtt = "localhost";
	$database_wifiAtt = "archery_scoring_2015";
	$username_wifiAtt = "root";
	$password_wifiAtt = "abc123";

    $db = new PDO("mysql:host=$hostname_wifiAtt;dbname=archery_scoring_2015", $username_wifiAtt, $password_wifiAtt);	
		// select teamA
		$qrySelectTeamA = "SELECT SUM(teamscoresor.score) AS totalScore, SUM(cntX) as totalX, SUM(cnt10) as total10, SUM(cnt9) as total9, SUM(cntM) as totalM,
					teamscoresor.teamName FROM teamscoresor
					WHERE teamscoresor.range_Id = :range_Id AND teamscoresor.round_no = :round_no AND teamscoresor.teamName = :teamA AND teamscoresor.Nth_arrow <= :arrowNo
					GROUP BY teamscoresor.teamName
					LIMIT :winnerNo";
		$stmtSelectTeamA = $db->prepare($qrySelectTeamA);
		$stmtSelectTeamA->bindParam(':teamA', $teamA, PDO::PARAM_STR);
		$stmtSelectTeamA->bindParam(':round_no', $round_no, PDO::PARAM_STR);
		$stmtSelectTeamA->bindParam(':range_Id', $range_Id, PDO::PARAM_STR);
		//$stmtSelectTeamA->bindParam(':arrowNo', $arrowNo, PDO::PARAM_STR);
		$winnerNo = 1;
		$stmtSelectTeamA->bindValue(':winnerNo', (int)$winnerNo, PDO::PARAM_INT);
		$stmtSelectTeamA->bindValue(':arrowNo', (int)$arrowNo, PDO::PARAM_INT);
		$stmtSelectTeamA->execute();
		
		$arraySelectTeamRoundWinner = array();	
		for($index=0; $index<3; $index++) {
			$arraySelectTeamRoundWinner[$index]['teamName'] = "No winner";
			$arraySelectTeamRoundWinner[$index]['totalScore'] = "0";
			$arraySelectTeamRoundWinner[$index]['totalX'] = "0";	
			$arraySelectTeamRoundWinner[$index]['total10'] = "0";
			$arraySelectTeamRoundWinner[$index]['total9'] = "0";
			$arraySelectTeamRoundWinner[$index]['totalM'] = "0";			
		}
		
		// select teamB
		$qrySelectTeamB = "SELECT SUM(teamscoresor.score) AS totalScore, SUM(cntX) as totalX, SUM(cnt10) as total10, SUM(cnt9) as total9, SUM(cntM) as totalM,
					teamscoresor.teamName FROM teamscoresor
					WHERE teamscoresor.range_Id = :range_Id AND teamscoresor.round_no = :round_no AND teamscoresor.teamName = :teamB AND teamscoresor.Nth_arrow <= :arrowNo
					GROUP BY teamscoresor.teamName
					LIMIT :winnerNo";
		$stmtSelectTeamB = $db->prepare($qrySelectTeamB);
		$stmtSelectTeamB->bindParam(':teamB', $teamB, PDO::PARAM_STR);
		$stmtSelectTeamB->bindParam(':round_no', $round_no, PDO::PARAM_STR);
		$stmtSelectTeamB->bindParam(':range_Id', $range_Id, PDO::PARAM_STR);
		//$stmtSelectTeamB->bindParam(':arrowNo', $arrowNo, PDO::PARAM_STR);
		$winnerNo = 1;
		$stmtSelectTeamB->bindValue(':winnerNo', (int)$winnerNo, PDO::PARAM_INT);
		$stmtSelectTeamB->bindValue(':arrowNo', (int)$arrowNo, PDO::PARAM_INT);
		$stmtSelectTeamB->execute();
		
		$cntRowSelectTeamA = $stmtSelectTeamA -> rowCount(); 
		if($cntRowSelectTeamA > 0) {
			$recordSelectTeamA = $stmtSelectTeamA->fetch();
			$arraySelectTeamRoundWinner[0]['teamName'] = $recordSelectTeamA['teamName'];
			$arraySelectTeamRoundWinner[0]['totalScore'] = $recordSelectTeamA['totalScore'];
			$arraySelectTeamRoundWinner[0]['totalX'] = $recordSelectTeamA['totalX'];	
			$arraySelectTeamRoundWinner[0]['total10'] = $recordSelectTeamA['total10'];
			$arraySelectTeamRoundWinner[0]['total9'] = $recordSelectTeamA['total9'];
			$arraySelectTeamRoundWinner[0]['totalM'] = $recordSelectTeamA['totalM'];
		}
		
		$cntRowSelectTeamB = $stmtSelectTeamB -> rowCount(); 		
		if($cntRowSelectTeamB > 0) {
			$recordSelectTeamB = $stmtSelectTeamB->fetch();
			$arraySelectTeamRoundWinner[1]['teamName'] = $recordSelectTeamB['teamName'];
			$arraySelectTeamRoundWinner[1]['totalScore'] = $recordSelectTeamB['totalScore'];
			$arraySelectTeamRoundWinner[1]['totalX'] = $recordSelectTeamB['totalX'];	
			$arraySelectTeamRoundWinner[1]['total10'] = $recordSelectTeamB['total10'];
			$arraySelectTeamRoundWinner[1]['total9'] = $recordSelectTeamB['total9'];
			$arraySelectTeamRoundWinner[1]['totalM'] = $recordSelectTeamB['totalM'];			
		}
		
		// Decide winner value
		if($arraySelectTeamRoundWinner[0]['totalScore'] > 0 && $arraySelectTeamRoundWinner[1]['totalScore'] > 0) {
			if($arraySelectTeamRoundWinner[0]['totalScore'] > $arraySelectTeamRoundWinner[1]['totalScore']) {
				$arraySelectTeamRoundWinner[2]['teamName'] = $arraySelectTeamRoundWinner[0]['teamName'];
				$arraySelectTeamRoundWinner[2]['totalScore'] = $arraySelectTeamRoundWinner[0]['totalScore'];
			}
			else if($arraySelectTeamRoundWinner[1]['totalScore'] > $arraySelectTeamRoundWinner[0]['totalScore']) {
				$arraySelectTeamRoundWinner[2]['teamName'] = $arraySelectTeamRoundWinner[1]['teamName'];
				$arraySelectTeamRoundWinner[2]['totalScore'] = $arraySelectTeamRoundWinner[1]['totalScore'];			
			}
			else if( $arraySelectTeamRoundWinner[1]['totalScore'] == $arraySelectTeamRoundWinner[0]['totalScore']) {
				$winnerIndex = fnCompareFreq($arraySelectTeamRoundWinner[0], $arraySelectTeamRoundWinner[1]);
				if($winnerIndex == 0) {
					$arraySelectTeamRoundWinner[2]['teamName'] = $arraySelectTeamRoundWinner[0]['teamName'];
					$arraySelectTeamRoundWinner[2]['totalScore'] = $arraySelectTeamRoundWinner[0]['totalScore'];	
				}
				else if($winnerIndex == 1) {
					$arraySelectTeamRoundWinner[2]['teamName'] = $arraySelectTeamRoundWinner[1]['teamName'];
					$arraySelectTeamRoundWinner[2]['totalScore'] = $arraySelectTeamRoundWinner[1]['totalScore'];	
				}					
			}		
		}
		else if($arraySelectTeamRoundWinner[0]['totalScore'] == 0 && $arraySelectTeamRoundWinner[1]['totalScore'] > 0) {
			if($arraySelectTeamRoundWinner[1]['totalScore'] > 0) {
				$arraySelectTeamRoundWinner[2]['teamName'] = $arraySelectTeamRoundWinner[1]['teamName'];
				$arraySelectTeamRoundWinner[2]['totalScore'] = $arraySelectTeamRoundWinner[1]['totalScore'];			
			}
		}
		else if($arraySelectTeamRoundWinner[0]['totalScore'] > 0 && $arraySelectTeamRoundWinner[1]['totalScore'] == 0) {
			if($arraySelectTeamRoundWinner[0]['totalScore'] > 0) {			
				$arraySelectTeamRoundWinner[2]['teamName'] = $arraySelectTeamRoundWinner[0]['teamName'];
				$arraySelectTeamRoundWinner[2]['totalScore'] = $arraySelectTeamRoundWinner[0]['totalScore'];			
			}
		}		
		return $arraySelectTeamRoundWinner;
	}
	
	function getORTeamMembers($teamName) {
		global $db;

		$qrySelectTeamMember = "SELECT teamScores.memberArcherNo, players.player_name, players.player_gender, players.player_no 
							FROM teamscores 
							JOIN players 
							ON teamscores.memberArcherNo = players.player_no
							WHERE teamscores.teamName = :teamName
							LIMIT 3";
		$stmtSelectTeamMember = $db->prepare($qrySelectTeamMember);
		$stmtSelectTeamMember->execute(array(':teamName' => $teamName));
		$recordSelectTeamMember = $stmtSelectTeamMember->fetchAll(PDO::FETCH_ASSOC);
		$teamMembersArray = array(); $index = 0;
		foreach($recordSelectTeamMember as $rowSelectMember) {
			$teamMembersArray[$index] = array();
			$teamMembersArray[$index]['player_name'] = $rowSelectMember['player_name'];
			$teamMembersArray[$index]['player_gender'] = $rowSelectMember['player_gender'];
			$teamMembersArray[$index]['player_no'] = $rowSelectMember['player_no'];
			$index++;
		}
		return $teamMembersArray;
	}
	

?>