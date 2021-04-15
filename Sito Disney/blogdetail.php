<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";

    $main=new Template("dtml/index.html");
    $body=new Template("dtml/blog_detail.html");

    if (isset($mysqli)) {

        $result = $mysqli->query("SELECT id, titolo, data_pubblicazione, descrizione FROM notizia WHERE id={$_GET['id']}");

        while ($data = $result->fetch_assoc()){
            $body->setContent("titolo_notizia", $data['titolo']);
            $body->setContent("data_notizia", $data['data_pubblicazione']);
            $body->setContent("descrizione_notizia", $data['descrizione']);
            $body->setContent("idImgNotizia", $data['id']);
        }

        $result = $mysqli->query("SELECT u.id, u.nome, u.cognome, c.data, c.testo FROM utente u join commento c on u.id = c.utente_id join notizia n on c.notizia_id = n.id");

        while ($data1 = $result->fetch_assoc()) {
            $body -> setContent("pagina_utente", 'userprofile.php?id=<[idUtente]>');
            $body->setContent("nome_utente", $data1['nome']);
            $body->setContent("data_commento", $data1['data']);
            $body->setContent("testo_commento", $data1['testo']);
        }

        $result = $mysqli->query("SELECT titolo FROM notizia order by data_uscita desc limit 3");
        while ($data1 = $result->fetch_assoc()) {
            $body -> setContent("pagina_notizia1", 'blogdetail.php?id=<[idNotizia]>');
            $body->setContent("pagina_notizia2", 'blogdetail.php?id=<[idNotizia]>');
            $body->setContent("pagina_notizia3", 'blogdetail.php?id=<[idNotizia]>');
            $body->setContent("testo_commento", 'blogdetail.php?id=<[idNotizia]>');
        }


    }


    $main->setContent("body", $body->get());
    $main->close();
?>