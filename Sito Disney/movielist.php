<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/movie_list.html");

if (isset($mysqli)) {

    $result = $mysqli->query("(SELECT id as idImg, titolo, data_uscita, trama, votazione, durata, categoria FROM articolo ORDER BY data_uscita desc)");

    while ($data = $result->fetch_assoc()) {

        if ($data['categoria'] == "Film Disney"){
            $body -> setContent("pagina_articolo_categoria", 'moviesingle.php?id=<[idImg]>');
        }
        else if ($data['categoria'] <> "Film Disney"){
            $body -> setContent("pagina_articolo_categoria", 'moviesingle2.php?id=<[idImg]>');
        }

        $body->setContent("nome_prod", $data['titolo']);
        $body->setContent("data_prod", $data['data_uscita']);
        $body->setContent("votazione_prod", $data['votazione']);
        $maxCaratteri = 300;
        $caratteri = strlen($data['trama']);
        if ($caratteri > $maxCaratteri) {
            $body->setContent("trama_prod", substr($data['trama'], 0, $maxCaratteri) . " [...]");
        } else {
            $body->setContent("trama_prod", $data['trama']);
        }
        $body->setContent("durata_prod", $data['durata']);
        $body->setContent("categoria_prod", $data['categoria']);
        $body->setContent("idImg", $data['idImg']);
    }
}

$main->setContent("body", $body->get());
$main->close();
?>