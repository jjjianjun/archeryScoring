<?php require_once('Connections/wifiAtt.php'); 
mysql_select_db($database_wifiAtt, $wifiAtt);
$delete="Delete From cutiam where OffDate='$_REQUEST[date]'";
$runDelete = mysql_query($delete, $wifiAtt) or die(mysql_error());
header("Location: TambahCuti.php");

?>