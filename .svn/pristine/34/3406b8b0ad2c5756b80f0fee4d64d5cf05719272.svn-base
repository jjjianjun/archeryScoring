<?php require_once('Connections/wifiAtt.php'); ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div align="center">
<table border="1">
<tr><td>No staf</td>
	<td>Nama Staf</td>
    <td>MAC address</td>
    <td>Email Staf</td>
</tr>
<?php  
mysql_select_db($database_wifiAtt, $wifiAtt);
$query_allStaf = "SELECT * FROM staf ";
$allStaf = mysql_query($query_allStaf, $wifiAtt) or die(mysql_error());
$row_allStaf  = mysql_fetch_assoc($allStaf);
$totalRows_allStaf  = mysql_num_rows($allStaf);

do{
	?>
	<tr>
    	<td><?php echo $row_allStaf['stafId']; ?></td>
        <td><a href="updateStaf.php?stafId=<?php echo $row_allStaf['stafId'];  ?>" target="content"><?php echo $row_allStaf['stafName'];   ?></a></td>
        <td><?php echo $row_allStaf['stafMAC']; ?></td>
        <td><?php echo $row_allStaf['stafEmail'];  ?></td>
     </tr>
<?php }while($row_allStaf  = mysql_fetch_assoc($allStaf));
?>
</table>
<!--<a href="tryMacAddress2.php">Cek Kehadiran staf</a>-->
</div>
</body>
</html>