<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/index.html");
    $body = new Template("dtml/blog_grid.html");

    if (isset($mysqli)) {

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

        $result = $mysqli->query("(SELECT titolo from notizia where categoria = 'Film Disney') union
        (SELECT titolo from notizia where categoria = 'Cartone Disney') union
        (SELECT titolo from notizia where categoria = 'Film Disney');");

        while ($data = $result->fetch_assoc()) {
            $body->setContent("notizia1", $data['titolo']);
            $body->setContent("notizia2", $data['titolo']);
            $body->setContent("notizia3", $data['titolo']);
        }
    }
$main->setContent("body", $body->get());
$main->close();
?>