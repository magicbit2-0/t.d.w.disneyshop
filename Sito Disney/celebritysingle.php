<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/celebrity_single.html");

if (isset($mysqli)) {

    $result = $mysqli->query("select id as idImgAttore, nome, cognome, anno_nascita, eta, nazionalità, paese_nascita, biografia, foto from regia where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    foreach($data as $key => $value){
        $body->setContent($key,$value);
    }

    $result1 = $mysqli->query("select concat(nome,' ',cognome) as nomeCognome from regia where id = {$_GET['id']}");
    while ($data1 = $result1->fetch_assoc()){
        $body->setContent("nomeCognomeAttore",$data1['nomeCognome']);
    }

    $result2 = $mysqli->query("select nome, cognome, anno_nascita, eta, nazionalità from regia where id = {$_GET['id']};");
    while ($data2 = $result2->fetch_assoc()){
        $body->setContent("nome",$data2['nome']);
        $body->setContent("cognome",$data2['cognome']);
        $body->setContent("annoNascita",$data2['anno_nascita']);
        $body->setContent("eta",$data2['eta']);
        $body->setContent("nazionalita",$data2['nazionalità']);

    }
}

$main->setContent("body", $body->get());
$main->close();
?>