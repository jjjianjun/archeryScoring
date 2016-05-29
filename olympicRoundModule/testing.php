<?php
//include '../Connections/wifiAtt.php';
include '../olympicRoundModule/bracketFunction.php';
//include '../generalFn/genericFn.php';

/* 	$testing_array = array();
	$testing_array = getArcherScoreOR('1A', '1', '1/64');
	
	//echo $testing_array[1].$testing_array[2].$testing_array[3];
	//echo $testing_array; 
	// print_r
	
	$affectedRowCount = saveArcherScoreOR('1AA', '1', '1/99', 88, 13);
	echo $affectedRowCount; */
	
/* 	$winner = getIndvRoundWinner('9C', '1A', '1/64', '1');
	echo $winner; */
	$teamMemberList = getORTeamMembers("TKAC B"); print_r($teamMemberList);
	
/* 	$teamCountArray = fnCountTeamAmount('2');
	print_r($teamCountArray); */
	
	$winner = getTeamRoundWinner("TKAC B", "ARCHERY GEAR SATU A", "1/16", "1", "6"); 
	print_r($winner);
?>