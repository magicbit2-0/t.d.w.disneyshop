<?php
    require "include/dbms.inc.php";
    require "include/template2.inc.php";

    $main=new Template("dtml/index.html");

    $main->setContent("titolo", "Titolo film");

    $result = $mysqli -> query("SELECT * FROM articolo ORDER BY titolo ASC");

    while ($data = $result -> fetch_assoc()){
        $main->setContent("titolo_film", $data['titolo']);
        $main->setContent("categoria_film", $data['categoria']);
    };

    //exit;

    $main->close();
?>