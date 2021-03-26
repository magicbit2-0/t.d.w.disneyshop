<?php

    require "include/dbms.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/index.html");

    $result = $mysqli -> query("SELECT * FROM articolo ORDER BY titolo ASC");

    while ($data = $result -> fetch_assoc()){
        $main->setContent("titolo_prodotto", $data['titolo']);
        $main->setContent("categoria_prodotto", $data['categoria']);
        $main->setContent("votazione_prodotto", $data['votazione']);
        $main->setContent("immagine_prodotto", $data['locandina']);
    };

    $main->close();
?>