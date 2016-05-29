<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_wifiAtt = "localhost";
$database_wifiAtt = "archery_scoring_2015";
$username_wifiAtt = "root";
$password_wifiAtt = "abc123";

define("ENCRYPTION_KEY", "!@#$%^&*");

//try {
    $db = new PDO("mysql:host=$hostname_wifiAtt;dbname=archery_scoring_2015", $username_wifiAtt, $password_wifiAtt);
//    $stmtSelect = $db->prepare("select max(player_id) as currentId from players ");        
//      $stmtSelect->execute();
//      $stmtSelect->fe

//catch(PDOException $e)
//    {
//    echo $e->getMessage();
//    }

function encrypt($dataString) {
    $key_value = "PASSWORD"; 
    $encrypted_string = mcrypt_ecb(MCRYPT_DES, $key_value, $dataString, MCRYPT_ENCRYPT);
    return $encrypted_string;
}

function decrypt($encrypted_string) {
    $key_value = "PASSWORD";
    $decrypted_string = mcrypt_ecb(MCRYPT_DES, $key_value, $encrypted_string, MCRYPT_DECRYPT);
    return $decrypted_string;
}

?>
