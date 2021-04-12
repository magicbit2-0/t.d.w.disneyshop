<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/movie_single.html");

if (isset($mysqli)) {
    $result = $mysqli->query("select id as idImg, titolo, data_uscita, durata, trama, votazione, prezzo, categoria from articolo where id = {$_GET['id']}");
    $data = $result->fetch_assoc();

    foreach ($data as $key => $value){
        $body->setContent($key,$value);
    }

   /* while ($data = $result->fetch_assoc()) {
        $body->setContent("nome_attore", $data['nomeT']);
        $body->setContent("idImgAttore", $data['id']);
    }*/
}

$main->setContent("body", $body->get());
$main->close();
?>