<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

//$main=new Template("dtml/ADMIN/admin.html");
$body=new Template("dtml/ADMIN/pages/examples/aggiungi-regia.html");
if (isset($mysqli)) {

    /*$result = $mysqli->query("select id as idImgAttore, nome, cognome, anno_nascita, eta, nazionalità as nazionalita, paese_nascita, biografia, foto from regia where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    while ($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave", $data['testo']);
    }*/
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
