<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$result = $mysqli->query("select password from utente where id = {$_SESSION['idUtente']};");
while ($data = $result->fetch_assoc()){
    if(md5($_POST['oldPassword']) == $data['password']){
        if($_POST['newPassword'] == $_POST['confirmNewPassword']){
            
            $result = $mysqli->query("update utente set password=md5('{$_POST['newPassword']}') where id={$_SESSION['idUtente']};");

            header('Location: userprofile.php#success');
        } else {
            header('Location: userprofile.php#np');    
        }
    } else {
        header('Location: userprofile.php#op');
    }
}
?>