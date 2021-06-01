<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/movie_list.html");

if (isset($mysqli)) {
    $result = $mysqli->query("select sfondo,background_color from personalizzasito order by id desc limit 1");
    $data = $result ->fetch_assoc();
    if(mysqli_num_rows($result) != 0){
        if($data['sfondo'] != null){
            $body->setContent("common-hero", '<div class="hero common-hero" style="background: url(' . $data['sfondo'] . '); background-position: center">');
        } else {
            $body->setContent("common-hero", '<div class="hero common-hero" style="background:' . $data['background_color'] . ';">');
        }
    } else {
        $body->setContent("common-hero",'<div class="hero common-hero">');
    }
    $results_per_page = 10;
    if (!isset($_GET['page'])) {
        $page = 1;
        $body -> setContent("actual_page", 1);
    } else {
        $page = $_GET['page'];
        $body -> setContent("actual_page", $_GET['page']);
    }
    $this_page_first_result = ($page - 1) * $results_per_page;

    if (!isset($_GET['categoria'])) {
        $result = $mysqli->query("SELECT id as idImg, trama, durata, titolo, data_uscita, votazione, categoria 
                                    FROM articolo ORDER BY votazione desc, data_uscita desc 
                                    LIMIT " . $this_page_first_result . ',' . $results_per_page);
                $body -> setContent("categoria_lista",'movielist.php');
                $body -> setContent("categoria_griglia",'moviegrid.php');

        $result0 = $mysqli->query("SELECT id FROM articolo");
        $number_of_results = mysqli_num_rows($result0); //conta il numero delle righe ottenute
        $body -> setContent("number_of_films", $number_of_results);
        $number_of_pages = ceil($number_of_results / $results_per_page);
        $body -> setContent("number_of_pages", $number_of_pages);
        for ($page = 1; $page <= $number_of_pages; $page++) {
            $body->setContent("tagpagina",'<a href="movielist.php?page=' . $page . '">' . $page . '</a> ');
        }
    } else {
            $result = $mysqli->query("SELECT id as idImg, trama, durata, titolo, data_uscita, votazione, categoria FROM articolo
                                        where categoria = {$_GET['categoria']} ORDER BY votazione desc, data_uscita desc
                                        LIMIT " . $this_page_first_result . ',' . $results_per_page);
                  $body -> setContent("categoria_lista",'movielist.php?categoria='. $_GET['categoria']);
                  $body -> setContent("categoria_griglia",'moviegrid.php?categoria='. $_GET['categoria']);

            $result0 = $mysqli->query("SELECT id FROM articolo WHERE CATEGORIA = {$_GET['categoria']}");
            $number_of_results = mysqli_num_rows($result0); //conta il numero delle righe ottenute
            $body -> setContent("number_of_films", $number_of_results);
            $number_of_pages = ceil($number_of_results / $results_per_page);
            $body -> setContent("number_of_pages", $number_of_pages);
            for ($page = 1; $page <= $number_of_pages; $page++) {
                $body->setContent("tagpagina",'<a href="movielist.php?categoria='.$_GET['categoria'].'&page=' . $page . '">' . $page . '</a> ');
            }
    }

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
        $body->setContent("trama_prod", substr($data['trama'], 0, 300) . " [...]");
        $body->setContent("durata_prod", $data['durata']);
        $body->setContent("categoria_prod", $data['categoria']);
        $body->setContent("idImg", $data['idImg']);
    }
}

$main->setContent("body", $body->get());
$main->close();
?>