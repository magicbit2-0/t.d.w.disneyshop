<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";
    require "bottonChange.php";

    $body=new Template("dtml/blog_detail.html");

    if (isset($mysqli)) {

        $result = $mysqli->query("SELECT id, titolo, data_pubblicazione, descrizione, fonte FROM notizia WHERE id={$_GET['id']}");

        while ($data = $result->fetch_assoc()){
            $body->setContent("titolo_notizia", $data['titolo']);
            $body->setContent("data_notizia", $data['data_pubblicazione']);
            $body->setContent("descrizione_notizia", $data['descrizione']);
            $body->setContent("fonte_notizia", $data['fonte']);
            $body->setContent("idImgNotizia", $data['id']);
        }

        $result = $mysqli->query("SELECT u.id, u.nome, u.cognome, c.data, c.testo FROM utente u join commento c on u.id = c.utente_id join notizia n on c.notizia_id = n.id WHERE n.id={$_GET['id']}");

        while ($data1 = $result->fetch_assoc()) {
            $body->setContent("pagina_utente", 'userprofile.php?id=<[idUtente]>');
            $body->setContent("nome_utente", $data1['nome']);
            $body->setContent("data_commento", $data1['data']);
            $body->setContent("testo_commento", $data1['testo']);
        }

        $result = $mysqli->query("SELECT id as idNotizia1, titolo FROM notizia WHERE categoria='Cartone Disney' limit 1");
        while ($data2 = $result->fetch_assoc()) {
            $body->setContent("notizia1", $data2['titolo']);
            $body->setContent("pagina_notizia1", 'blogdetail.php?id=<[idNotizia1]>');
        }

        $result = $mysqli->query("SELECT id as idNotizia2, titolo FROM notizia WHERE categoria='Film Disney' limit 1");
        while ($data3 = $result->fetch_assoc()) {
            $body->setContent("notizia2", $data3['titolo']);
            $body->setContent("pagina_notizia2", 'blogdetail.php?id=<[idNotizia2]>');
        }

        $result = $mysqli->query("SELECT id as idNotizia3, titolo FROM notizia order by data_pubblicazione desc limit 1");
        while ($data4 = $result->fetch_assoc()) {
            $body->setContent("notizia3", $data4['titolo']);
            $body->setContent("pagina_notizia3", 'blogdetail.php?id=<[idNotizia3]>');
        }
    }


    $main->setContent("body", $body->get());
    $main->close();
?>