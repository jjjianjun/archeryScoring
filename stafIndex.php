<?php require_once('Connections/wifiAtt.php'); ?> 
<?php
session_start();
if(isset($_SESSION['userID'])){ 
/*
* Getting MAC Address using PHP
* Md. Nazmul Basher
*/
//echo $_SERVER['REMOTE_ADDR'];

		mysql_select_db($database_wifiAtt, $wifiAtt);
		$qStaf = "SELECT * FROM staf where stafId = '$_SESSION[userID]'";
		$Staf = mysql_query($qStaf, $wifiAtt) or die(mysql_error());
		$row_qStaf = mysql_fetch_assoc($Staf);
		
		$tarikhHariIni=date("Y-n-j",time()+ 3600*8);
		$masaHariIni=date("Y-n-j H:i:s ",time()+ 3600*8);
		
		$sql_Attndnt="select * from attendancerekod where stafId='$_SESSION[userID]' ";
		$Attndnt=mysql_query($sql_Attndnt, $wifiAtt) or die(mysql_error());
		$rowAttndnt=mysql_fetch_assoc($Attndnt);
?>

 <div align="center">
 Welcome <?php echo $row_qStaf['stafName'];  ?> !

Today you ha
</div>

<?php } ?>