<?php
    require "include/template2.inc.php";
    require "include/dbms.inc.php";

    $main = new Template("dtml/index.html");

    $result = $mysqli -> query("SELECT titolo, categoria, votazione, locandina FROM articolo;");
    while ($data = $result -> fetch_assoc()){
        $main->setContent("titolo_prodotto", $data['titolo']);
        $main->setContent("categoria_prodotto",$data['categoria']);
        $main->setContent("votazione_prodotto",$data['votazione']);
        //$main->setContent("immagine_prodotto",$data['locandina'] );

    }

    $main->close();
