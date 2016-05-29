<?php

include('config.php');

$myConnection = mysql_connect($hostname, $name, $password) or die (mysql_error());

$db_selected = mysql_select_db($database, $myConnection) or die (mysql_error());
?>