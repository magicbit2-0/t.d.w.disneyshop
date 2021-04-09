<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";


    $main = new Template("dtml/index.html");

    if (isset($mysqli)) {
        $result = $mysqli->query("SELECT titolo, categoria, votazione FROM articolo ");

    while ($data = $result->fetch_assoc()) {
        $main->setContent("titolo_prodotto", $data['titolo']);
        $main->setContent("categoria_prodotto", $data['categoria']);
        $main->setContent("votazione_prodotto", $data['votazione']);
        //$main->setContent("immagine_prodotto",$data['locandina'] );
    }
    }
    $main->close();
?>