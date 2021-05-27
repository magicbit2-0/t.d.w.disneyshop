<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
if (isset($mysqli)){
    $mysqli->query("insert into articolo_preferito (articolo_id, utente_id) values ({$_POST['idFilm']},{$_SESSION['idUtente']})");
    header('Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/userfavoritegrid.php');
}
?>