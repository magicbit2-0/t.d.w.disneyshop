<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/celebrity_single.html");

if (isset($mysqli)) {

    $result = $mysqli->query("select id as idImgAttore, nome, cognome, anno_nascita, eta, nazionalità as nazionalita, paese_nascita, biografia, foto from regia where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    foreach($data as $key => $value){
        $body->setContent($key,$value);
    }


    $result1 = $mysqli->query("select distinct a.id as idfilm, a.titolo as titolofilm, a.data_uscita as datafilm, a.categoria, ps.nome as nome_protagonista from regia r join backstage_articolo b on (r.id = b.regia_id) join articolo a on (b.articolo_id = a.id) join personaggio_articolo pa on pa.articolo_id = a.id join personaggio ps on ps.id = pa.personaggio_id where r.id = {$_GET['id']} group by a.id");
    while ($data1 = $result1->fetch_assoc()){
        $body->setContent("idfilm", $data1['idfilm']);
        $body->setContent("idfilm1", $data1['idfilm']);
        $body->setContent("titolofilm", $data1['titolofilm']);
        $body->setContent("titolofilm1", $data1['titolofilm']);
        $body->setContent("titolo_film2", $data1['titolofilm']);
        $body->setContent("datafilm", $data1['datafilm']);
        $body->setContent("datafilm1", $data1['datafilm']);
        $body->setContent("nome_protagonista", $data1['nome_protagonista']);
        $body->setContent("nome_protagonista1", $data1['nome_protagonista']);
        $body->setContent("categoria_film", $data1['categoria']);
    }

    $result = $mysqli->query("select p.testo as testo from parola_chiave_regia pc join regia r on r.id = pc.regia_id join parola_chiave p on p.id = pc.parola_chiave_id where r.id = {$_GET['id']}");
    while ($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave", $data['testo']);
    }

    $result = $mysqli->query("select p.testo as testo FROM regia as r join parola_chiave_regia as pr on (r.id = pr.regia_id) join parola_chiave as p on (pr.parola_chiave_id = p.id) where r.id = {$_GET['id']}");
    while ($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave_attore", $data['testo']);
    }


}

$main->setContent("body", $body->get());
$main->close();
?>