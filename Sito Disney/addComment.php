<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
if (isset($mysqli)){
    
    $mysqli->query("insert into commento (nome, email, testo, data, utente_id, notizia_id) values 
    ({$_POST['nome']},{$_POST['cognome']},{$_POST['commento']},date(now()),{$_SESSION['idUtente']},{$_POST['notizia']});");
    
    header('Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/blogdetail.php?id='.$_POST['notizia']);
}
?>