<?php
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();
    require "include/dbms.inc.php";
    require "include/template2.inc.php";
    require "bottonChange.php";

/*$main = new Template("dtml/index.html");
    if(isset($_REQUEST['accesso'])){
    if($_REQUEST['accesso'] == 'LoginError'){
        $body2 = new Template("dtml/login.html"); //ritenta accesso
        $body2->setContent("message", "errorLogin");
        $main->setContent("body2", $body2->get());
    }
    else if($_REQUEST['accesso'] == 'LoginOk'){
        $main = new Template("dtml/index2.html"); //accesso effettuato
    }
}*/

$body = new Template("dtml/homepage.html");
if(isset($_REQUEST['signedup']))
    $body -> setContent("allerta","<body onload=\"window.alert(' Registrazione effettuata! ') \" > ");
if ($_REQUEST['accesso'] == 'AccessDenied') {
    $body->setContent("allerta", "<body onload=\"window.alert(' Accesso Negato! ') \" > ");
}
    if (isset($mysqli)) {

        $result = $mysqli->query("(SELECT a.id as idImg,titolo, c.categoria_articolo as categoria,b.nome as brand, votazione FROM articolo a join categoria c on c.id=a.categoria join brand b on b.id=a.id_brand where c.categoria_articolo='Film' and votazione <> 0.0 and b.nome='Disney' order by data_uscita desc limit 1) union
                                        (SELECT a.id as idImg,titolo, c.categoria_articolo as categoria,b.nome as brand, votazione FROM articolo a join categoria c on c.id=a.categoria join brand b on b.id=a.id_brand where c.categoria_articolo='Cartone' and votazione <> 0.0 and b.nome='Pixar' order by data_uscita desc limit 1) union
                                        (SELECT a.id as idImg,titolo, c.categoria_articolo as categoria,b.nome as brand, votazione FROM articolo a join categoria c on c.id=a.categoria join brand b on b.id=a.id_brand where c.categoria_articolo='Cartone' and votazione <> 0.0 and b.nome='Disney' order by data_uscita desc limit 1) union
                                        (SELECT a.id as idImg,titolo, c.categoria_articolo as categoria,b.nome as brand, votazione FROM articolo a join categoria c on c.id=a.categoria join brand b on b.id=a.id_brand where c.categoria_articolo='Cortometraggio' and votazione <> 0.0 and b.nome='Pixar' order by data_uscita desc limit 1) union
                                        (SELECT a.id as idImg,titolo, c.categoria_articolo as categoria,b.nome as brand, votazione FROM articolo a join categoria c on c.id=a.categoria join brand b on b.id=a.id_brand where c.categoria_articolo='Film' and votazione <> 0.0 and b.nome='Disney' order by data_uscita desc limit 2) union
                                        (SELECT a.id as idImg,titolo, c.categoria_articolo as categoria,b.nome as brand, votazione FROM articolo a join categoria c on c.id=a.categoria join brand b on b.id=a.id_brand where c.categoria_articolo='Cartone' and votazione <> 0.0 and b.nome='Pixar' order by data_uscita desc limit 2) union
                                        (SELECT a.id as idImg,titolo, c.categoria_articolo as categoria,b.nome as brand, votazione FROM articolo a join categoria c on c.id=a.categoria join brand b on b.id=a.id_brand where c.categoria_articolo='Cartone' and votazione <> 0.0 and b.nome='Disney' order by data_uscita desc limit 2) union
                                        (SELECT a.id as idImg,titolo, c.categoria_articolo as categoria,b.nome as brand, votazione FROM articolo a join categoria c on c.id=a.categoria join brand b on b.id=a.id_brand where c.categoria_articolo='Cortometraggio' and votazione <> 0.0 and b.nome='Pixar' order by data_uscita desc limit 2);");

    while ($data = $result->fetch_assoc()) {
        if ($data['categoria'] == "Film Disney"){
        $body -> setContent("pagina_articolo_categoria", 'moviesingle.php?id=<[idImg]>');
        }
       else if ($data['categoria'] <> "Film Disney"){
        $body -> setContent("pagina_articolo_categoria", 'moviesingle2.php?id=<[idImg]>');
        }
        $body->setContent("titolo_prodotto", $data['titolo']);
        $body->setContent("categoria_prodotto", $data['categoria'].' '.$data['brand']);
        $body->setContent("votazione_prodotto", $data['votazione']);
        $body->setContent("idImg", $data['idImg']);

            if ($data['categoria'].' '.$data['brand'] == 'Cartone Disney')
                $body->setContent("color", 'orange');
            else if ($data['categoria'].' '.$data['brand'] == 'Cartone Pixar')
                $body->setContent("color", 'blue');
            else if ($data['categoria'].' '.$data['brand'] == 'Cortometraggio Pixar')
                $body->setContent("color", 'yell');
            else if ($data['categoria'].' '.$data['brand'] == 'Film Disney')
                $body->setContent("color", 'green');
    }

    $result2 = $mysqli->query("select id, concat(nome,\" \",cognome) as nomeT from regia limit 4"); //query per attori

    while ($data1 = $result2->fetch_assoc()) {
        $body->setContent("nome_attore", $data1['nomeT']);
        $body->setContent("idImgAttore", $data1['id']);
    }

    $result3a = $mysqli->query("select articolo.id, titolo, votazione, categoria_articolo as categoria from articolo join categoria on articolo.categoria=categoria.id where categoria_articolo <> 'Cortometraggio' order by prezzo asc limit 8");
        while ($data3a = $result3a->fetch_assoc()) {
            if ($data3a['categoria'] == "Film Disney"){
                $body -> setContent("pagina_articolo_categoria1", 'moviesingle.php?id=<[idImg3a]>');
            }
            else if ($data3a['categoria'] <> "Film Disney"){
                $body -> setContent("pagina_articolo_categoria1", 'moviesingle2.php?id=<[idImg3a]>');
            }
            $body->setContent("nome_prod", $data3a['titolo']);
            $body->setContent("voto_prod", $data3a['votazione']);
            $body->setContent("idImg3a", $data3a['id']);
        }
        $result3b = $mysqli->query("select articolo.id, titolo, categoria_articolo as categoria from articolo join categoria on articolo.categoria=categoria.id where data_uscita > now()");

        while ($data3b = $result3b->fetch_assoc()) {
            if ($data3b['categoria'] == "Film Disney"){
                $body -> setContent("pagina_articolo_categoria2", 'moviesingle.php?id=<[idImg3b]>');
            }
            else if ($data3b['categoria'] <> "Film Disney"){
                $body -> setContent("pagina_articolo_categoria2", 'moviesingle2.php?id=<[idImg3b]>');
            }
            $body->setContent("nome_prod2", $data3b['titolo']);
            $body->setContent("voto_prod2", $data3b['categoria']);
            $body->setContent("idImg3b", $data3b['id']);
        }
        $result3c = $mysqli->query("select articolo.id, titolo, votazione from articolo join categoria on articolo.categoria=categoria.id order by votazione desc limit 8");

        while ($data3c = $result3c->fetch_assoc()) {
            if ($data3c['categoria'] == "Film Disney"){
                $body -> setContent("pagina_articolo_categoria3", 'moviesingle.php?id=<[idImg3c]>');
            }
            else if ($data3c['categoria'] <> "Film Disney"){
                $body -> setContent("pagina_articolo_categoria3", 'moviesingle2.php?id=<[idImg3c]>');
            }
            $body->setContent("nome_prod3", $data3c['titolo']);
            $body->setContent("voto_prod3", $data3c['votazione']);
            $body->setContent("idImg3c", $data3c['id']);
        }

        $result4a = $mysqli->query("select id, nome from personaggio order by rand() limit 4;");

        while ($data4a = $result4a->fetch_assoc()) {
            $body->setContent("nome_personaggioRand", $data4a['nome']);
            $body->setContent("idImgPersonaggioRand", $data4a['id']);
        }

        $result4b = $mysqli->query("select personaggio.id, personaggio.nome from personaggio join parola_chiave_personaggio
                                            on (personaggio.id = parola_chiave_personaggio.personaggio_id) join parola_chiave
                                            on (parola_chiave.id = parola_chiave_personaggio.parola_chiave_id)
                                            where parola_chiave.testo='eroe' limit 3;");

        while ($data4b = $result4b->fetch_assoc()) {
            $body->setContent("nome_personaggioEroe", $data4b['nome']);
            $body->setContent("idImgPersonaggioEroe", $data4b['id']);
        }
        $result4c = $mysqli->query("select personaggio.id, personaggio.nome from personaggio join parola_chiave_personaggio
                                            on (personaggio.id = parola_chiave_personaggio.personaggio_id) join parola_chiave
                                            on (parola_chiave.id = parola_chiave_personaggio.parola_chiave_id)
                                            where parola_chiave.testo='principessa' order by rand() limit 3;");

        while ($data4c = $result4c->fetch_assoc()) {
            $body->setContent("nome_personaggioPrinc", $data4c['nome']);
            $body->setContent("idImgPersonaggioPrinc", $data4c['id']);
        }


    $result5 = $mysqli->query("SELECT id, titolo, descrizione, data_pubblicazione from notizia where (data_pubblicazione > now() - interval 6 month) order by data_pubblicazione desc limit 1;"); //query per notizie

    while ($data5 = $result5->fetch_assoc()) {
        $body->setContent("titolo_notizia", $data5['titolo']);

        $maxCaratteri = 200;
        $caratteri = strlen($data5['descrizione']);
        if ($caratteri > $maxCaratteri) {
            $body->setContent("idImgNotizia", $data5['id']);
            $body->setContent("descrizione_notizia", substr($data5['descrizione'], 0, $maxCaratteri) . " [...]");
        } else {
            $body->setContent("descrizione_notizia", $data5['descrizione']);
        }

        $body->setContent("data_notizia", $data5['data_pubblicazione']);

        }

        $result = $mysqli->query("select a.id, a.titolo, year(a.data_uscita) as anno, a.trailer from trailer_home t join articolo a where t.id_articolo = a.id;");
        while ($data = $result->fetch_assoc()) {
            $body->setContent("trailer",'<div>
                                                    <iframe class="item-video" src="" data-src="https://www.youtube.com/embed/'.$data['trailer'].'"></iframe>
                                                    </div>');
            $body->setContent("trailer_info",'<div class="item">
                                                        <div class="trailer-img">
                                                            <img src="img.php?id='.$data['id'].'"  alt="trailer photo" width="4096" height="2737">
                                                        </div>
                                                        <div class="trailer-infor">
                                                            <h4 class="desc">'.$data['titolo'] .' ('.$data['anno'].')'.'</h4>
                                                        </div>
                                                    </div>');
        }

        $result6 = $mysqli->query("select id, titolo, data_pubblicazione from notizia where (data_pubblicazione > now() - interval 2 YEAR 
        and data_pubblicazione < now() - interval 6 MONTH) order by data_pubblicazione desc limit 2;"); //query per notizie

        while ($data6 = $result6->fetch_assoc()) {
            $body->setContent("idImgNotizia2", $data6['id']);
            $body->setContent("titolo_notizia2", $data6['titolo']);
            $body->setContent("data_notizia2", $data6['data_pubblicazione']);

        }

        $result7 = $mysqli->query("select id, titolo, data_pubblicazione from notizia  where id not in 
        (select id from notizia where (data_pubblicazione > now() - interval 2 YEAR ) order by data_pubblicazione desc) order by data_pubblicazione limit 2;");//query per notizie

        while ($data7 = $result7->fetch_assoc()) {
            $body->setContent("idImgNotizia3", $data7['id']);
            $body->setContent("titolo_notizia3", $data7['titolo']);
            $body->setContent("data_notizia3", $data7['data_pubblicazione']);

        }
        
    }
    $main->setContent("body", $body->get());
    $main->close();
?>