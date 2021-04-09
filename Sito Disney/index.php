<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/index.html");

    if (isset($mysqli)) {
        $result = $mysqli->query("select titolo, categoria, votazione, locandina from (SELECT titolo,categoria,votazione,locandina FROM disneydb.articolo order by data_uscita desc limit 8) as q1 group by categoria;");

    while ($data = $result->fetch_assoc()) {
        $main->setContent("titolo_prodotto", $data['titolo']);
        $main->setContent("categoria_prodotto", $data['categoria']);
        $main->setContent("votazione_prodotto", $data['votazione']);

        $main->setContent("locandina_prodotto", $data['locandina']);


    }
//SELECT titolo, categoria, votazione FROM articolo where categoria = "Film Disney" order by data_uscita desc limit 2 ;
//SELECT titolo, categoria, votazione FROM articolo where categoria = "Cartone Pixar" order by data_uscita desc limit 2 ;
//SELECT titolo, categoria, votazione FROM articolo where categoria = "Cortometraggi Pixar" order by data_uscita desc limit 2 ;
    }

    $main->close();
?>