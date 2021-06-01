<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";
    require "bottonChange.php";

    $body = new Template("dtml/blog_grid.html");

    if (isset($mysqli)) {
        $result = $mysqli->query("select sfondo,background_color from personalizzasito order by id desc limit 1");
        $data = $result ->fetch_assoc();
        if(mysqli_num_rows($result) != 0){
            if($data['sfondo'] != null){
                $body->setContent("common-hero", '<div class="hero common-hero" style="background: url(' . $data['sfondo'] . '); background-position: center">');
            } else {
                $body->setContent("common-hero", '<div class="hero common-hero" style="background:' . $data['background_color'] . ';">');
            }
        } else {
            $body->setContent("common-hero",'<div class="hero common-hero">');
        }
        $result = $mysqli->query("SELECT id, titolo, descrizione, data_pubblicazione from notizia order by data_pubblicazione desc;");

        while ($data = $result->fetch_assoc()) {
            $body->setContent("titolo_notizia", $data['titolo']);

            $maxCaratteri = 200;
            $caratteri = strlen($data['descrizione']);
            if ($caratteri > $maxCaratteri) {
                $body->setContent("testo_notizia", substr($data['descrizione'], 0, $maxCaratteri) . " [...]");
            } else {
                $body->setContent("testo_notizia", $data['descrizione']);
            }
            $body -> setContent("pagina_notizia", 'blogdetail.php?id=<[idImgNotizia]>');
            $body->setContent("data_notizia", $data['data_pubblicazione']);
            $body->setContent("idImgNotizia", $data['id']);
        }

        $result = $mysqli->query("SELECT id as idNotizia1, titolo FROM notizia WHERE categoria='Cartone Disney' limit 1");
        while ($data2 = $result->fetch_assoc()) {
            $body->setContent("notizia1", $data2['titolo']);
            $body->setContent("pagina_notizia1", 'blogdetail.php?id='.$data2['idNotizia1']);
        }

        $result = $mysqli->query("SELECT id as idNotizia2, titolo FROM notizia WHERE categoria='Film Disney' limit 1");
        while ($data3 = $result->fetch_assoc()) {
            $body->setContent("notizia2", $data3['titolo']);
            $body->setContent("pagina_notizia2", 'blogdetail.php?id='.$data3['idNotizia2']);
        }

        $result = $mysqli->query("SELECT id as idNotizia3, titolo FROM notizia order by data_pubblicazione desc limit 1");
        while ($data4 = $result->fetch_assoc()) {
            $body->setContent("notizia3", $data4['titolo']);
            $body->setContent("pagina_notizia3", 'blogdetail.php?id='.$data4['idNotizia3']);
        }
    }
$main->setContent("body", $body->get());
$main->close();
?>