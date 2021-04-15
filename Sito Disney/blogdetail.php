<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";

    $main=new Template("dtml/index.html");
    $body=new Template("dtml/blog_detail.html");

    if (isset($mysqli)) {
        $result = $mysqli->query("(SELECT id, titolo, data_pubblicazione, descrizione FROM notizia");

        while ($data = $result->fetch_assoc()){
            $body->setContent("titolo_notizia", $data['titolo']);
            $body->setContent("data_notizia", $data['data_pubblicazione']);
            $body->setContent("descrizione_notizia", $data['descrizione']);
            $body->setContent("idImgNotizia", $data['id']);
        }
    }

    $main->setContent("body", $body->get());
    $main->close();
?>