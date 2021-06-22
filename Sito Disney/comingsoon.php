<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/coming_soon.html");

if (isset($mysqli)) {

    $result = $mysqli->query("SELECT a.id as idImg, a.titolo, a.trama FROM articolo a join categoria c on c.id = a.categoria join brand b on b.id = a.id_brand WHERE data_uscita > now() order by data_uscita LIMIT 1");

    while ($data = $result->fetch_assoc()) {
        if($data['categoria'] == 'Film'){
            $body->setContent("pagina_articolo", "moviesingle2.php?id=".$data['idImg']);
        } else {
            $body->setContent("pagina_articolo", "moviesingle2.php?id=".$data['idImg']);
        }
        $body->setContent("idImg", $data['idImg']);
        $body->setContent("titolo", $data['titolo']);
        $body->setContent("trama", $data['trama']);
    }
}
$main->setContent("body", $body->get());
$main->close();
?>