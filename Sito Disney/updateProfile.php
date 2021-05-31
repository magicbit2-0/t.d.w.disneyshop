<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth.inc.php";

//query aggiornamento dati profilo utente 
$mysqli->query("update utente u set username = '{$_POST['username']}', nome = '{$_POST['nome']}', cognome = '{$_POST['cognome']}',
data_nascita= '{$_POST['dataNascita']}', email= '{$_POST['email']}', paese = '{$_POST['paese']}', regione = '{$_POST['regione']}', 
indirizzo = '{$_POST['indirizzo']}' where u.id = {$_SESSION['idUtente']};");

header('Location: userprofile.php');
?>