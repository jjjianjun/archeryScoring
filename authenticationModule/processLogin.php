<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
if(isset($_REQUEST['Submit'])){	
	if($_REQUEST['username'] == "" || $_REQUEST['password'] == ""){
		$code_error = 1;
		header("Location: ../index.php?error=" . $code_error);
	}
	else {
		//userLogin($_REQUEST['username'], $_REQUEST['password']);
		//userLoginWithoutEncryption($_REQUEST['username'], $_REQUEST['password']);
		hashPasswordVerification($_REQUEST['username'], $_REQUEST['password']);
	}			
} 

ini_set('display_errors', 1); 
error_reporting(E_ALL);

function userLogin($username, $password){
	include '../Connections/wifiAtt.php';  

	$stmt = $db->prepare("SELECT * from staff where staff_id=:staff_id and staff_password=:staff_password");
	$encryptedStr = encrypt($password);
	$stmt->execute(array(':staff_id' => $username, ':staff_password' => encrypt($password)));

	$row_RecordsetAdmin = $stmt->fetchAll(PDO::FETCH_ASSOC);

	//$plainPwd = decrypt($row_RecordsetAdmin['staff_password']);
	//$result = strcmp($row_RecordsetAdmin['staff_password'], $encryptedStr);
	foreach ($row_RecordsetAdmin as $row){ 
		if($row['staff_id'] == $username && $row['staff_password'] == $encryptedStr ){
			//session_start();
			$userIdFromDb = $row['staff_id'];
			$_SESSION['user'] = "Superuser";
			$_SESSION['userID'] = $row['staff_id'];
			header("Location: ../index2.php");
				
		}
		else { 
			$code_error = 1;
			header("Location: ../index.php?error=" . $code_error);
		}
	}
}


function userLoginWithoutEncryption($username, $password){

	include '../Connections/wifiAtt.php';  

	$stmt = $db->prepare("SELECT * from staff where staff_id=:staff_id and staff_password=:staff_password");

	$stmt->execute(array(':staff_id' => $username, ':staff_password' => $password));
	
	$row_RecordsetAdmin = $stmt->fetch();
	
    $row_count = $stmt->rowCount(); echo $row_count;
				print_r($row_RecordsetAdmin);

	if($row_count == 1) {
		$_SESSION['userID'] = $row_RecordsetAdmin['staff_id'];
		$_SESSION['staff_name'] = $row_RecordsetAdmin['staff_name'];
		header("Location: ../home.php");
	}
	else {
		$code_error = 1;
		header("Location: ../index.php?error=" . $code_error);		
	}
}

function hashPasswordVerification($username, $password){

	include '../Connections/wifiAtt.php';  
	include 'password.php';

	$stmt = $db->prepare("SELECT * from staff where staff_id=:staff_id");

	$stmt->execute(array(':staff_id' => $username));
	
	$recordsetAdmin = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
    $row_count = $stmt->rowCount(); echo $row_count;
	$verifyToken = false;
	
	foreach($recordsetAdmin as $row_RecordsetAdmin) {
		if(password_verify($password, $row_RecordsetAdmin['staff_password'])) {
			$verifyToken = true;
			$_SESSION['userID'] = $row_RecordsetAdmin['staff_id'];
			$_SESSION['staff_name'] = $row_RecordsetAdmin['staff_name'];
			header("Location: ../home.php");
		}
	}

	if($row_count == 0 || $verifyToken == false) {
		$code_error = 1;
		header("Location: ../index.php?error=" . $code_error);		
	}
}
?>
