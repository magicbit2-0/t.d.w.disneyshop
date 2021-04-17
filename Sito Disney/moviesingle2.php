<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/movie_single2.html");

if (isset($mysqli)) {
    $result = $mysqli->query("select id as idImg, titolo, data_uscita, durata, trama, votazione, prezzo, categoria from articolo where id = {$_GET['id']}");
    $data = $result->fetch_assoc();

    foreach ($data as $key => $value){
        $body->setContent($key,$value);
    }
    //non c'è direttore
    $result = $mysqli->query("select r.id as idRegista, concat(r.nome,' ', r.cognome) as nome_regista from backstage_articolo b join articolo a on b.articolo_id = a.id join regia r on b.regia_id = r.id
                                    join parola_chiave_regia p on p.regia_id = r.id join parola_chiave k on k.id=p.parola_chiave_id where k.testo = 'regia' and a.id = {$_GET['id']}");
    while($data = $result->fetch_assoc()){
        $body->setContent("idRegista", $data['idRegista']);
        $body->setContent("nome_regista", $data['nome_regista']);
    }
    $result1 = $mysqli->query("select r.id as id_attore, concat(r.nome,' ', r.cognome) as nome_attore from backstage_articolo b join articolo a on b.articolo_id = a.id join regia r on b.regia_id = r.id 
                                    join parola_chiave_regia p on p.regia_id = r.id join parola_chiave k on k.id=p.parola_chiave_id where k.testo = 'attore' and a.id = {$_GET['id']}");

    while ($data1 = $result1->fetch_assoc()){
        $body->setContent("id_attore", $data1['id_attore']);
        $body->setContent("nome_attore", $data1['nome_attore']);
        $body->setContent("id_attore1", $data1['id_attore']);
        $body->setContent("nome_attore1", $data1['nome_attore']);
        $body->setContent("nome_attore2", $data1['nome_attore']);
    }

    $result1 = $mysqli->query("SELECT p.id as p_id, p.nome as p_nome FROM personaggio_articolo pa join personaggio p on p.id = pa.personaggio_id join articolo a on a.id = pa.articolo_id where a.id = {$_GET['id']}");

    while ($data1 = $result1->fetch_assoc()){
        $body->setContent("id_personaggio", $data1['p_id']);
        $body->setContent("id_personaggio1", $data1['p_id']);
        $body->setContent("nome_personaggio1", $data1['p_nome']);
        $body->setContent("nome_personaggio", $data1['p_nome']);
    }

    $result1 = $mysqli->query("select p.nome as p_nome from personaggio p 
                                    join personaggio_articolo pa on pa.personaggio_id = p.id 
                                    join articolo a on a.id = pa.articolo_id where a.id = {$_GET['id']}");

    while ($data1 = $result1->fetch_assoc()){
        $body->setContent("nome_protagonista1", $data1['p_nome']);
        $body->setContent("nome_protagonista", $data1['p_nome']);
    }

    $result = $mysqli->query("(select a1.id , a2.id as id_correlato, a2.titolo as titolo_correlato, a2.categoria as categoria_correlato, a2.votazione as votazione_correlato, 
                                    a2.durata as durata_correlato, a2.trama as trama_correlato, a2.data_uscita as data_uscita_correlato 
                                    from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_id join articolo a2 on a2.id = tab.articolo_correlato_id 
                                    where a1.id = {$_GET['id']} ) union
                                    (select a1.id , a2.id as id_correlato, a2.titolo as titolo_correlato, a2.categoria as categoria_correlato, a2.votazione as votazione_correlato, 
                                    a2.durata as durata_correlato, a2.trama as trama_correlato, a2.data_uscita as data_uscita_correlato 
                                    from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_correlato_id join articolo a2 on a2.id = tab.articolo_id 
                                    where a1.id = {$_GET['id']} )");


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
    if ($conteggio == 0){
        $body->setContent("no_correlati", "Non sono stati trovati altri film correlati a ".'<[titolo]>');
    }
    else {$body->setContent("no_correlati","");}

    $result1 = $mysqli->query("SELECT r.titolo as titolo_recensione, r.data as data_recensione, r.testo as testo_recensione,
                                     concat(u.nome,' ', u.cognome) as nome_utente, r.voto as votazione_recensione 
                                     FROM disneydb.recensione r 
                                     join articolo a on r.articolo_id = a.id join utente u on r.utente_id = u.id 
                                     where a.id = {$_GET['id']}");

    while ($data1 = $result1->fetch_assoc()) {
        $body->setContent("titolo_recensione", $data1['titolo_recensione']);
        $body->setContent("data_recensione", $data1['data_recensione']);
        $body->setContent("testo_recensione", $data1['testo_recensione']);
        $body->setContent("nome_utente", $data1['nome_utente']);
        $body->setContent("votazione_recensione", $data1['votazione_recensione']);
    }

    }

$main->setContent("body", $body->get());
$main->close();
?>