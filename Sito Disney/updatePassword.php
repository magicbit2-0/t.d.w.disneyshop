<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$result = $mysqli->query("select password from utente where id = {$_SESSION['idUtente']};");
$data -> fetch_assoc($result);

if($_POST['oldPassword'] == md5($data['password'])){
    if($_POST['newPassword'] == $_POST['confirmNewPassword']){
        //qui dentro esegui query aggiornamento password
        
    }
}
header('Location: userprofile.php');
?>