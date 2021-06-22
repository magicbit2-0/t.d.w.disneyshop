<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/celebrity_single.html");

$numero_filmografia=0;

if (isset($mysqli)) {

    $result = $mysqli->query("select id as idImgAttore, nome, cognome, anno_nascita, eta, nazionalità as nazionalita, paese_nascita, biografia, foto from regia where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    foreach($data as $key => $value){
        $body->setContent($key,$value);
    }


    $result = $mysqli->query("select distinct a.id as idfilm, a.titolo as titolofilm, a.data_uscita as datafilm, c.categoria_articolo from regia r 
                                        join backstage_articolo b on r.id = b.regia_id 
                                        join articolo a on b.articolo_id = a.id 
                                        join categoria c on a.categoria=c.id
                                        where r.id = {$_GET['id']} limit 3");
    
    if(mysqli_num_rows($result) > 0) {
        while ($data1 = $result->fetch_assoc()) {
            $body->setContent("film_correlato", '<div class="cast-it">
                                                            <div class="cast-left cebleb-film">
                                                                <img src=\'img.php?id='.$data1['idfilm'].'\' alt="immagine film non trovata" width="200px">
                                                                <div>
                                                                    <a href=\'moviesingle2.php?id='.$data1['idfilm'].'\'>'.$data1['titolofilm'].'</a>
                                                                    <p style="width: auto;">'.$data1['datafilm'].'</p>
                                                                </div>
                                                            </div>
                                                        </div>');

            $body->setContent("idfilm", $data1['idfilm']);
            $body->setContent("idfilm1", $data1['idfilm']);
            $body->setContent("titolofilm", $data1['titolofilm']);
            $body->setContent("titolofilm1", $data1['titolofilm']);
            $body->setContent("titolo_film2", $data1['titolofilm']);
            $body->setContent("datafilm", $data1['datafilm']);
            $body->setContent("datafilm1", $data1['datafilm']);
            $body->setContent("categoria_film", $data1['categoria']);
        }
    } else {
        $body->setContent("film_correlato", "<div><h2 style='color:#d36b6b'> Non sono ancora stati trovati film correlati a questo vip </h2></div>");
        $body->setContent("film_correlati2", "<div><h2 style='color:#d36b6b'> Non sono ancora stati trovati film correlati a questo vip </h2></div>");
    }

    $result1 = $mysqli->query("select distinct a.id as idfilm, a.titolo as titolofilm, a.data_uscita as datafilm, c.categoria_articolo from regia r 
                                        join backstage_articolo b on r.id = b.regia_id 
                                        join articolo a on b.articolo_id = a.id 
                                        join categoria c on c.id=a.categoria
                                        where r.id = {$_GET['id']}");
    while ($data1 = $result1->fetch_assoc()){
        $body->setContent("film_correlati2", '<div class="cast-it">
												<div class="cast-left cebleb-film">
													<img src=\'img.php?id='.$data1['idfilm'].'\' alt="immagine film non trovata" style="width:150px;">
													<div>
														<a href=\'moviesingle2.php?'.$data1['idfilm'].'\'>'.$data1['titolofilm'].'</a>
														<p class="time" style="width: auto;">'.$data1['categoria'].'</p>
													</div>
												</div>
												<p>'.$data1['datafilm'].'</p>
											</div>');
    }

    $result = $mysqli->query("select p.testo as testo from parola_chiave_regia pc join regia r on r.id = pc.regia_id join parola_chiave p on p.id = pc.parola_chiave_id where r.id = {$_GET['id']}");
    while ($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave", $data['testo']);
    }

    $result = $mysqli->query("select p.testo as testo FROM regia as r join parola_chiave_regia as pr on (r.id = pr.regia_id) join parola_chiave as p on (pr.parola_chiave_id = p.id) where r.id = {$_GET['id']}");
    while ($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave_attore", $data['testo']);
    }

    $body->setContent("numero",mysqli_num_rows($result1));
}

$main->setContent("body", $body->get());
$main->close();
?>