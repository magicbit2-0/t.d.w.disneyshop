<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/celebrity_single2.html");

if(isset($mysqli)){

    $result = $mysqli->query("select id as id_personaggio, nome, descrizione, data_nascita from personaggio where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    foreach($data as $key => $value){
        $body->setContent($key,$value);
    }

    $result = $mysqli-> query("SELECT p.testo as parola_chiave from parola_chiave_personaggio pc join parola_chiave p on pc.parola_chiave_id = p.id join personaggio d on d.id = pc.personaggio_id where d.id = {$_GET['id']}");
    while ($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave", $data['parola_chiave']);
    }

    $result = $mysqli->query("select a.id, a.titolo, a.data_uscita from personaggio_articolo pa join articolo a on a.id = pa.articolo_id join personaggio p on p.id = pa.personaggio_id where p.id = {$_GET['id']}");
    while ($data = $result->fetch_assoc()){
        $body->setContent("idcartone", $data['id']);
        $body->setContent("titolo_film", $data['titolo']);
        $body->setContent("titolo_cartone", $data['titolo']);
        $body->setContent("data_cartone", $data['data_uscita']);

    }
}

$main->setContent("body", $body->get());
$main->close();
?>