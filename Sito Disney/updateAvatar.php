<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth.inc.php";


if(isset($_SERVER['HTTP_REFERER'])){
    $mysqli->query("update utente set avatar_id={$_POST['radioAvatar']} where id={$_SESSION['idUtente']};");

    //fare controllo su pagina di provenienza
    header('Location: '.$_SERVER['HTTP_REFERER']);
} else {
    header("Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/index.php");
}
?>