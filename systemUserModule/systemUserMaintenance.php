<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
include '../Connections/wifiAtt.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
          if(isset($_POST['btnSubmit']))
          {
              
              $stmt = $db->prepare("INSERT into staf (staff_id,staff_name,staff_password ) VALUES (:staff_id,:staff_name,:staff_password) ");
              $ggr = encrypt($_POST['txtBoxPwd']);
              $ggr2 = decrypt($ggr);
              $stmt->execute(array(':staff_id' => $_POST['txtBoxUserId'], ':staff_name' => $_POST['txtBoxName'], ':staff_password' => encrypt($_POST['txtBoxPwd'])));
              echo $stmt->rowCount().' were affected' ;
              
          }
        ?>
        <form name="frmSysUSer" method="post">
        <table>
            <tr>
                <td>User ID: </td>
                <td><input type="text" id="txtBoxUserId" name="txtBoxUserId"></td>
            </tr>
            <tr>
                <td>Name: </td>
                <td><input type="text" id="txtBoxName" name="txtBoxName"></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" id="txtBoxPwd" name="txtBoxPwd"></td>
            </tr>
            <tr>
                <td>Re-enter Password: </td>
                <td><input type="password" id="txtReBoxPwd" name="txtReBoxPwd"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" id="btnSubmit" name="btnSubmit"></td>
            </tr>
        </table>
        </form>
    </body>
</html>
