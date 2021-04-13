<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/movie_single.html");
$conteggio = 0;

if (isset($mysqli)) {
    $result = $mysqli->query("select id as idImg, titolo, data_uscita, durata, trama, votazione, prezzo, categoria from articolo where id = {$_GET['id']}");
    $data = $result->fetch_assoc();

    foreach ($data as $key => $value){
        $body->setContent($key,$value);
    }

    $result = $mysqli->query("(select a1.id , a2.id as id_correlato, a2.titolo as titolo_correlato, a2.categoria as categoria_correlato, a2.votazione as votazione_correlato, a2.durata as durata_correlato, a2.trama as trama_correlato, a2.data_uscita as data_uscita_correlato from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_id join articolo a2 on a2.id = tab.articolo_correlato_id where a1.id = {$_GET['id']} ) union
                                    (select a1.id , a2.id as id_correlato, a2.titolo as titolo_correlato, a2.categoria as categoria_correlato, a2.votazione as votazione_correlato, a2.durata as durata_correlato, a2.trama as trama_correlato, a2.data_uscita as data_uscita_correlato from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_correlato_id join articolo a2 on a2.id = tab.articolo_id where a1.id = {$_GET['id']} )");


   while ($data = $result->fetch_assoc()){
       $conteggio++;
        $body->setContent("id_correlato", $data['id_correlato']);
        $body->setContent("titolo_correlato", $data['titolo_correlato']);
        $body->setContent("categoria_correlato", $data['categoria_correlato']);
        $body->setContent("votazione_correlato", $data['votazione_correlato']);
        $body->setContent("durata_correlato", $data['durata_correlato']);
        $body->setContent("data_uscita_correlato", $data['data_uscita_correlato']);
        $body->setContent("trama_correlato", substr($data['trama_correlato'], 0, 300) . " [...]");
    }
        $body->setContent("conteggio", $conteggio);

    /* while ($data = $result->fetch_assoc()) {
        $body->setContent("nome_attore", $data['nomeT']);
        $body->setContent("idImgAttore", $data['id']);
    }*/
}

$main->setContent("body", $body->get());
$main->close();
?>