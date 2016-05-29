<!--<META HTTP-EQUIV=Refresh CONTENT="3">-->
<?php require_once('Connections/wifiAtt.php'); ?> 
<?php
		function change2day($date2)
		{
		  $dt = strtotime($date2);	
		  return date("l", $dt);
			
		}
		
		function change2dmy($date) //input format: yyyy-m-d
		{
		$dtmp = explode('-',$date);
		$dadate = mktime(0,0,0,$dtmp[1],$dtmp[2],$dtmp[0]);
		return date('d-m-Y',$dadate);
		}

$ipclient=$_SERVER['REMOTE_ADDR'];
//echo $ipclient;
ob_start(); // Turn on output buffering
//$ipman="192.168.1.1";
//system('arp -a $ipclient'); //Execute external program to display output
//$try=ob_get_contents();
$try=`arp -a $ipclient`;
$lines=explode(" ", $try);
$lines2=explode(" ", $lines);
ob_clean();
//echo $lines;
mysql_select_db($database_wifiAtt, $wifiAtt);
$query_Recordset1 = "SELECT * FROM staf ";
$Recordset1 = mysql_query($query_Recordset1, $wifiAtt) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
  $jumpa="tak";
	do{  //loop to get data from DB
	//echo "try";
		for($i=0;$i<=count($lines);$i++){ //loop to seek from data from imlode(the mac address)
		//echo $lines[$i];
		//
			if( $row_Recordset1['stafMAC'] ==$lines[$i]){
				$jumpa="Ya";
				
				$tarikhHariIni=date("Y-n-j",time()+ 3600*8);
				$masaHariIni=date("Y-n-j H:i:s ",time()+ 3600*8);
				$attID= $row_Recordset1['stafId']."-".$tarikhHariIni;
				mysql_select_db($database_wifiAtt, $wifiAtt);
				$queryAttendRekod = "SELECT * FROM attendancerekod where attID = '$attID'";
				$AttendRekod = mysql_query($queryAttendRekod, $wifiAtt) or die(mysql_error());
				$row_queryAttendRekod = mysql_fetch_assoc($AttendRekod);
				//echo $row_queryAttendRekod['attID']."<br>";
				if($row_queryAttendRekod['attID']=="")
				 { 
				 //echo $masaHariIni;
				   $insertData="Insert into attendancerekod (attID,punchIn,stafId) values ('$attID','$masaHariIni','$row_Recordset1[stafId]')";
				   $Result1 = mysql_query($insertData, $wifiAtt) or die(mysql_error());
				   echo "Welcome to work! <br> Today is ".change2day($tarikhHariIni)." ".change2dmy($tarikhHariIni);
				   echo "<br>";
				   echo $row_Recordset1['stafName']." you has punched in on <br> ".substr($masaHariIni,10,19); ?>
                   <br> Click <a href="processLogin.php?Submit=submit&username=<?php echo $row_Recordset1['stafId']; ?>&password=<?php echo $row_Recordset1['password']; ?>"> HERE </a> to login via your mobile phone
                   <?php
				 }
				 else if($row_queryAttendRekod['attID'] !="")
				 {
					 
					 $diffInUnix=abs(strtotime(date("Y-n-d H:i:s",time()+ 3600*8)) - strtotime(substr($row_queryAttendRekod['punchIn'],1,19)));
					 //echo $diffInUnix;
					 $diffInHours=floor(($diffInUnix/60/60));
					 if($diffInHours > 4 || $_REQUEST['yes']=="ya" )
					 {
						
						// echo $diffInHours;
						 //echo date("Y-n-d H:i:s");
						 $updateData="update attendancerekod set punchOut='$masaHariIni' where attID='$attID'";
						 $Result1 = mysql_query($updateData, $wifiAtt) or die(mysql_error());
						 echo "Goodbye have safe trip to home!";
						 echo "<br>";
						 echo $row_Recordset1['stafName']." you has punched out on ".substr($masaHariIni,10,19)." ".change2day($tarikhHariIni)." ".change2dmy($tarikhHariIni);           
						 ?>
                         <br> Click <a href="processLogin.php?Submit=submit&username=<?php echo $row_Recordset1['stafId']; ?>&password=<?php echo $row_Recordset1['password']; ?>"> HERE </a> to login via your mobile phone
                         <?php
					 }
					 else {
						 echo $row_Recordset1['stafName']." you already<br> punched in today on  ".substr($row_queryAttendRekod['punchIn'],10,19)."<br>";
						 echo "Do you want to punch out early? "; ?><a href="index.php?yes=ya">Yes</a><br>Click <a href="processLogin.php?Submit=submit&username=<?php echo $row_Recordset1['stafId']; ?>&password=<?php echo $row_Recordset1['password']; ?>"> HERE </a> to login via your mobile phone
                         <?php
						  }
				 }
		$masuk= $masaHariIni;
		if($masuk=='') {
		$masuk=$row_queryAttendRekod['punchIn']; }
		
			 }
		}
	}while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) ; ?>
   <br> Please close the web browser if you do not want <br>to continue to use the system
<?php	if($jumpa=="tak"){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login.php">';}
?>
<html>  
<head>
<title>WirelessAttendance</title>
<body>
<br />

<!--'<a href="TambahStaf.php" target="content">Add Staff</a><br />
'<a href="SenaraiStaf.php" target="content">Update Record</a><br />
'<a href="TambahCuti.php" target="content">Assign Off Day</a><br />
'<a href="laporanBulanan.php" target="content">Report</a><br />-->


</body>