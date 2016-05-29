<?php

$hostname_wifiAtt = "localhost";
$database_wifiAtt = "archery_scoring_2015";
$username_wifiAtt = "root";
$password_wifiAtt = "abc123";

$wifiAtt = mysqli_connect($hostname_wifiAtt, $username_wifiAtt, $password_wifiAtt,$database_wifiAtt) ;
$globMysqliObj;

function fnInvokeMySqli()
{
    global $hostname_wifiAtt,$username_wifiAtt,$password_wifiAtt,$database_wifiAtt;
    return $mysqli = new mysqli($hostname_wifiAtt,$username_wifiAtt,$password_wifiAtt,$database_wifiAtt);
}

function fnAssignArcherNo($playerId, $playerNo)
{
    $sqlUpdatePlayerInfo = "Update players set player_no = ? where player_id = ?";
    global $globMysqliObj;
    if($globMysqliObj == null)
    $globMysqliObj = fnInvokeMySqli();
    
    $stmt = $globMysqliObj->prepare($sqlUpdatePlayerInfo);
    $stmt->bind_param("ss",$playerNo,$playerId);
    $stmt->execute();
    $stmt->close();
}
?>
