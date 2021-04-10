<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/index.html");

    if (isset($mysqli)) {
        $result = $mysqli->query("(SELECT titolo, categoria, votazione, locandina FROM articolo where categoria = 'Film Disney' order by data_uscita desc limit 1) union
        (SELECT titolo, categoria, votazione, locandina FROM articolo where categoria = 'Cartone Pixar' order by data_uscita desc limit 1) union
        (SELECT titolo, categoria, votazione, locandina FROM articolo where categoria = 'Cartone Disney' order by data_uscita desc limit 1) union
        (SELECT titolo, categoria, votazione, locandina FROM articolo where categoria = 'Cortometraggi Pixar' order by data_uscita desc limit 1) union
        (SELECT titolo, categoria, votazione, locandina FROM articolo where categoria = 'Film Disney' order by data_uscita desc limit 2) union
        (SELECT titolo, categoria, votazione, locandina FROM articolo where categoria = 'Cartone Pixar' order by data_uscita desc limit 2) union
        (SELECT titolo, categoria, votazione, locandina FROM articolo where categoria = 'Cartone Disney' order by data_uscita desc limit 2) union
        (SELECT titolo, categoria, votazione, locandina FROM articolo where categoria = 'Cortometraggi Pixar' order by data_uscita desc limit 2);");

    while ($data = $result->fetch_assoc()) {
        $main->setContent("titolo_prodotto", $data['titolo']);
        $main->setContent("categoria_prodotto", $data['categoria']);
        $main->setContent("votazione_prodotto", $data['votazione']);
       // header("Content-Type: image/jpeg");
        //$main->setContent("locandina_prodotto", $data['locandina']);

    }
    }

    $main->close();
?>