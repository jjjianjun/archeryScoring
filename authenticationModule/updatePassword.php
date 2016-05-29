<?php
	include "password.php";
	include 'Connections/wifiAtt.php'; 
	
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	global $db;
	
	$hashStaff = password_hash("abc123", PASSWORD_BCRYPT);
	$queryUpdateAdmin = "UPDATE staff SET staff_password='$hashStaff' WHERE staff_id='admin'";
	
	$hashDeveloper = password_hash("hariz", PASSWORD_BCRYPT);
	$queryUpdateDeveloper = "UPDATE staff SET staff_password='$hashDeveloper' WHERE staff_id='developer'";
	
	$hashJj = password_hash("abc123", PASSWORD_BCRYPT);
	$queryUpdateJj = "UPDATE staff SET staff_password='$hashJj' WHERE staff_id='jjwong'";

	$stmtUpdatePassword = $db->prepare($queryUpdateJj);
	$stmtUpdatePassword->execute();
	$rowCount = $stmtUpdatePassword->rowCount();
	echo $rowCount;
?>