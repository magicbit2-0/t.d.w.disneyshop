<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
if (isset($mysqli)){
    $mysqli->query("delete from articolo_preferito where articolo_id = '{$_POST['idFilm']}' and utente_id='{$_SESSION['idUtente']}';");
    header('Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/userfavoritegrid.php');
}
?>