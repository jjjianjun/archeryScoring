<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        
        <title></title>
        <script type="text/javascript" src="js/jquery-1.10.2.js" ></script>
<!--        <script type="text/javascript" src="js/jquery-ui.js" />-->
        <script type="text/javascript"  >
            function checkdb(){ 
                alert("ggrrr");
            }
        $(document).ready(function() {
            //alert("Dah ");
           $('#txtBoxArcherNo').click(function(){
               alert("Dah invoke ka");
//              $.ajax({ 
//                  url:'ListNAddPlayer.php',
//                  data:{action:'checkArcherNo',archerNo:$('#txtBoxArcherNo').val()},
//                  type:'post',
//                  success: function(data){
//                      if(data > 0)
//                      {
//                          alert("Archer No already exist!");
//                          $('#btnSubmit').addClass('disable');
//                      }
//                      else
//                      {
//                          $('#btnSubmit').removeClass('disable');
//                      }
//                  }
//              }); 
           });   
        });
        </script>
    </head>
    <body>
        
        <div id="notification" name="notification"><input type="text" id="txtBoxArcherNo" name="txtBoxArcherNo" onclick="checkdb()"></div>
        <?php
        include 'Connections/wifiAtt.php';
        $stmt = $db->prepare("INSERT into players (player_id,player_name,player_gender,team ) VALUES (:player_id,:player_name,:player_gender,:team) ");
              
              $stmt->execute(array(':player_id' => "2A", ':player_name' => "ggrr", ':player_gender' => "khunsa",':team' =>"ntah" ));
              
        define("ENCRYPTION_KEY2", "!@#$%^&*");
        $string = "This is the original data string!";

         $encrypted = encrypt2($string, ENCRYPTION_KEY2);

         $decrypted = decrypt2($encrypted, ENCRYPTION_KEY2);

        /**
         * Returns an encrypted & utf8-encoded
         */
        function encrypt2($pure_string, $encryption_key) {
            $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
            return $encrypted_string;
        }

        /**
         * Returns decrypted original string
         */
        function decrypt2($encrypted_string, $encryption_key) {
            $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
            return $decrypted_string;
}
        ?>
    </body>
</html>
