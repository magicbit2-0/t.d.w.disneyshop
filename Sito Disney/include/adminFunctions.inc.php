<?php
require "dbms.inc.php";
session_start();
$main=new Template("dtml/ADMIN/pages/examples/admin_body.html");
if (($_SESSION['idUtente']) != null) {
    $result = $mysqli->query("select concat(nome,' ',cognome) as nomeAdmin from utente where id = {$_SESSION['idUtente']}");
    $data = $result->fetch_assoc();
    $main->setContent("nomeAdmin", '<a class=\"d-block\">' . $data ['nomeAdmin'] . '</a>');
}
?>
