<?php require_once('Connections/wifiAtt.php'); 
session_start();
if(isset($_SESSION['userID'])){ 
?> <META HTTP-EQUIV=Refresh CONTENT="7">
<?php
		mysql_select_db($database_wifiAtt, $wifiAtt);
		$qStaf = "SELECT * FROM staf where stafId = '$_SESSION[userID]'";
		$Staf = mysql_query($qStaf, $wifiAtt) or die(mysql_error());
		$row_qStaf = mysql_fetch_assoc($Staf);
/*
* Getting MAC Address using PHP
* Md. Nazmul Basher
*/
//echo $_SERVER['REMOTE_ADDR'];
if($row_qStaf['level'] ==1){
ob_start(); // Turn on output buffering
//$ipman="192.168.1.1";
system('arp -a'); //Execute external program to display output
$try=ob_get_contents();
$lines=explode(" ", $try);
$lines2=explode(" ", $lines);
ob_clean();
//echo $lines;
mysql_select_db($database_wifiAtt, $wifiAtt);
$query_Recordset1 = "SELECT * FROM staf ";
$Recordset1 = mysql_query($query_Recordset1, $wifiAtt) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
  
	do{  //loop to get data from DB
	//echo "try";
		for($i=0;$i<=count($lines);$i++){ //loop to seek from data from imlode(the mac address)
		//echo $lines[$i];
			if( $row_Recordset1['stafMAC'] ==$lines[$i]){
				//echo "try";
				$tarikhHariIni=date("Y-n-j",time()+ 3600*8);
				$masaHariIni=date("Y-n-j H:i:s ",time()+ 3600*8);
				$attID= $row_Recordset1['stafId']."-".$tarikhHariIni;
				mysql_select_db($database_wifiAtt, $wifiAtt);
				$queryAttendRekod = "SELECT * FROM attendancerekod where attID = '$attID'";
				$AttendRekod = mysql_query($queryAttendRekod, $wifiAtt) or die(mysql_error());
				$row_queryAttendRekod = mysql_fetch_assoc($AttendRekod);
				if($row_queryAttendRekod['attID']=="")
				 { 
				 echo $masaHariIni;
				   $insertData="Insert into attendancerekod (attID,punchIn,stafId) values ('$attID','$masaHariIni','$row_Recordset1[stafId]')";
				   $Result1 = mysql_query($insertData, $wifiAtt) or die(mysql_error());
				 }
				 else if($row_queryAttendRekod['attID'] !="")
				 {
					 $diffInUnix=abs(strtotime(date("Y-n-d H:i:s",time()+ 3600*8)) - strtotime(substr($row_queryAttendRekod['punchIn'],1,19)));
					 //echo $diffInUnix;
					 $diffInHours=floor(($diffInUnix/60/60));
					 if($diffInHours > 4 && $row_queryAttendRekod['punchOut'] ==''){
						// echo $diffInHours;
						 //echo date("Y-n-d H:i:s");
						 $updateData="update attendancerekod set punchOut='$masaHariIni' where attID='$attID'";
						 $Result1 = mysql_query($updateData, $wifiAtt) or die(mysql_error());
					 }
				 }
		//echo $lines[$i];
		echo "<br>";
		echo $row_Recordset1['stafName']." has punched on ".$row_queryAttendRekod['punchIn'];
			 }
		}
	}while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
}
?>
<html>  
<head>
<title>WirelessAttendance</title>
<body><br> <br> <br> <br>  
<?php
		
		$tarikhHariIni=date("Y-n-j",time()+ 3600*8);
		$masaHariIni=date("Y-n-j H:i:s ",time()+ 3600*8);
		
		$sql_TodayAttndnt="select * from attendancerekod where stafId='$_SESSION[userID]' and substr(punchIn,1,10)='$tarikhHariIni' ";
		$Attndnt=mysql_query($sql_TodayAttndnt, $wifiAtt) or die(mysql_error());
		$rowAttndnt=mysql_fetch_assoc($Attndnt);
?>

 <div align="center">
 Welcome <?php echo $row_qStaf['stafName'];  ?> ! <br>
<?php if($rowAttndnt['punchIn']!=''){ ?>
Today you have punch in on <?php echo substr($rowAttndnt['punchIn'],10,19); ?>
<?php } else if($rowAttndnt['punchIn']=='' ){?>
Today you did not punch in yet using the system <?php  } ?>
</div>


</body>
<?php } ?>