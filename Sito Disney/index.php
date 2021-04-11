<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/index.html");

    if (isset($mysqli)) {
        $result = $mysqli->query("(SELECT id ,titolo, categoria, votazione FROM articolo where categoria = 'Film Disney' order by data_uscita desc limit 1) union
        (SELECT id, titolo, categoria, votazione FROM articolo where categoria = 'Cartone Pixar' order by data_uscita desc limit 1) union
        (SELECT id, titolo, categoria, votazione FROM articolo where categoria = 'Cartone Disney' order by data_uscita desc limit 1) union
        (SELECT id, titolo, categoria, votazione FROM articolo where categoria = 'Cortometraggi Pixar' order by data_uscita desc limit 1) union
        (SELECT id, titolo, categoria, votazione FROM articolo where categoria = 'Film Disney' order by data_uscita desc limit 2) union
        (SELECT id, titolo, categoria, votazione FROM articolo where categoria = 'Cartone Pixar' order by data_uscita desc limit 2) union
        (SELECT id, titolo, categoria, votazione FROM articolo where categoria = 'Cartone Disney' order by data_uscita desc limit 2) union
        (SELECT id, titolo, categoria, votazione FROM articolo where categoria = 'Cortometraggi Pixar' order by data_uscita desc limit 2);");

    while ($data = $result->fetch_assoc()) {
        $main->setContent("titolo_prodotto", $data['titolo']);
        $main->setContent("categoria_prodotto", $data['categoria']);
        $main->setContent("votazione_prodotto", $data['votazione']);
        $main->setContent("idImg", $data['id']);
            if ($data['categoria'] == 'Cartone Disney')
                $main->setContent("color", 'orange');
            else if ($data['categoria'] == 'Cartone Pixar')
                $main->setContent("color", 'blue');
            else if ($data['categoria'] == 'Cortometraggi Pixar')
                $main->setContent("color", 'yell');
            else if ($data['categoria'] == 'Film Disney')
                $main->setContent("color", 'green');
    }

    $result2 = $mysqli->query("select id, concat(nome,\" \",cognome) as nomeT from regia limit 4"); //query per attori

    while ($data1 = $result2->fetch_assoc()) {
        $main->setContent("nome_attore", $data1['nomeT']);
        $main->setContent("idImgAttore", $data1['id']);
    }

    $result3a = $mysqli->query("select id, titolo, votazione from articolo where categoria <> 'Cortometraggi Pixar' order by prezzo asc limit 8");
        while ($data3a = $result3a->fetch_assoc()) {
            $main->setContent("nome_prod", $data3a['titolo']);
            $main->setContent("voto_prod", $data3a['votazione']);
            $main->setContent("idImg3a", $data3a['id']);
        }
       /* $result3b = $mysqli->query("select id, concat(nome,\" \",cognome) as nomeT from regia limit 4"); //query per attori

        while ($data3b = $result3b->fetch_assoc()) {
            $main->setContent("nome_attore", $data3b['nomeT']);
            $main->setContent("idImgAttore", $data3b['id']);
        }*/
        $result3c = $mysqli->query("select id, titolo, votazione from articolo order by votazione desc limit 8");

        while ($data3c = $result3c->fetch_assoc()) {
            $main->setContent("nome_prod3", $data3c['titolo']);
            $main->setContent("voto_prod3", $data3c['votazione']);
            $main->setContent("idImg3c", $data3c['id']);
        }
    $result5 = $mysqli->query("SELECT id, titolo,descrizione, data_pubblicazione from notizia where (data_pubblicazione > now() - interval 6 month) order by data_pubblicazione desc limit 1;"); //query per notizie

    while ($data5 = $result5->fetch_assoc()) {
        $main->setContent("titolo_notizia", $data5['titolo']);

        $maxCaratteri = 200;
        $caratteri = strlen($data5['descrizione']);
        if ($caratteri > $maxCaratteri) {
            $main->setContent("descrizione_notizia", substr($data5['descrizione'], 0, $maxCaratteri) . " [...]");
        } else {
            $main->setContent("descrizione_notizia", $data5['descrizione']);
        }

        $main->setContent("data_notizia", $data5['data_pubblicazione']);
        $main->setContent("idImgNotizia", $data5['id']);
        }

        $result6 = $mysqli->query("select titolo, data_pubblicazione from notizia where (data_pubblicazione > now() - interval 2 YEAR 
        and data_pubblicazione < now() - interval 6 MONTH) order by data_pubblicazione desc limit 2;"); //query per notizie

        while ($data6 = $result6->fetch_assoc()) {
            $main->setContent("titolo_notizia2", $data6['titolo']);
            $main->setContent("data_notizia2", $data6['data_pubblicazione']);
        }

        $result7 = $mysqli->query("select titolo, data_pubblicazione from notizia  where id not in 
        (select id from notizia where (data_pubblicazione > now() - interval 2 YEAR ) order by data_pubblicazione desc) order by data_pubblicazione limit 2;");//query per notizie

        while ($data7 = $result7->fetch_assoc()) {
            $main->setContent("titolo_notizia3", $data7['titolo']);
            $main->setContent("data_notizia3", $data7['data_pubblicazione']);
        }
    }

    $main->close();
?>