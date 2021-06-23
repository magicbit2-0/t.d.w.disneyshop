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

    if (!isset($_GET['categoria']) and !isset($_GET['brand'])) {
        $result = $mysqli->query("SELECT a.id as idImgProd,trama, titolo,durata, votazione, concat(c.categoria_articolo,' ',b.nome) as categoria 
                                    FROM articolo a join categoria c on c.id=a.categoria join brand b on b.id=a.id_brand
                                    ORDER BY votazione desc, data_uscita desc LIMIT " . $this_page_first_result . ',' . $results_per_page);

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
    } else if(isset($_GET['categoria']) and !isset($_GET['brand'])){
        $result = $mysqli->query("SELECT a.id as idImgProd,trama, titolo,durata, votazione, concat(c.categoria_articolo,' ',b.nome) as categoria FROM articolo a join categoria c on c.id=a.categoria
                                        join brand b on b.id=a.id_brand
                                        where c.categoria_articolo = {$_GET['categoria']} ORDER BY votazione desc, data_uscita desc
                                        LIMIT " . $this_page_first_result . ',' . $results_per_page);

        $body -> setContent("categoria_lista",'movielist.php?categoria='. $_GET['categoria']);
        $body -> setContent("categoria_griglia",'moviegrid.php?categoria='. $_GET['categoria']);

        $result0 = $mysqli->query("SELECT a.id FROM articolo a join categoria c on c.id = a.categoria join brand b on b.id=a.id_brand WHERE c.categoria_articolo = {$_GET['categoria']}");
        $number_of_results = mysqli_num_rows($result0); //conta il numero delle righe ottenute
        $body -> setContent("number_of_films", $number_of_results);
        $number_of_pages = ceil($number_of_results / $results_per_page);
        $body -> setContent("number_of_pages", $number_of_pages);
        for ($page = 1; $page <= $number_of_pages; $page++) {
                $body->setContent("tagpagina",'<a href="movielist.php?categoria='.$_GET['categoria'].'&page=' . $page . '">' . $page . '</a> ');
            }
    } else if(!isset($_GET['categoria']) and isset($_GET['brand'])) {
        $result = $mysqli->query("SELECT a.id as idImgProd,trama, titolo,durata, votazione, concat(c.categoria_articolo,' ',b.nome) as categoria FROM articolo a join categoria c on c.id=a.categoria
                                        join brand b on b.id=a.id_brand
                                        where b.nome = {$_GET['brand']} ORDER BY votazione desc, data_uscita desc
                                        LIMIT " . $this_page_first_result . ',' . $results_per_page);

                $body->setContent("categoria_lista", 'movielist.php?brand=' . $_GET['brand']);
                $body->setContent("categoria_griglia", 'moviegrid.php?brand=' . $_GET['brand']);
        $result0 = $mysqli->query("SELECT a.id FROM articolo a join categoria c on c.id = a.categoria join brand b on b.id=a.id_brand WHERE b.nome = {$_GET['brand']}");
        $number_of_results = mysqli_num_rows($result0); //conta il numero delle righe ottenute
        $body->setContent("number_of_films", $number_of_results);
        $number_of_pages = ceil($number_of_results / $results_per_page);
        $body->setContent("number_of_pages", $number_of_pages);
        for ($page = 1; $page <= $number_of_pages; $page++) {
            $body->setContent("tagpagina",'<a href="movielist.php?brand='.$_GET['brand'].'&page=' . $page . '">' . $page . '</a> ');
        }
    } else if(isset($_GET['categoria']) and isset($_GET['brand'])){
        $result = $mysqli->query("SELECT a.id as idImgProd,trama, titolo,durata, votazione, concat(c.categoria_articolo,' ',b.nome) as categoria FROM articolo a join categoria c on c.id=a.categoria
                                        join brand b on b.id=a.id_brand
                                        where b.nome = {$_GET['brand']} and c.categoria_articolo = {$_GET['categoria']} ORDER BY votazione desc, data_uscita desc
                                        LIMIT " . $this_page_first_result . ',' . $results_per_page);

                $body -> setContent("categoria_lista",'movielist.php?categoria='.$_GET['categoria'].'&brand='. $_GET['brand']);
                $body -> setContent("categoria_griglia",'moviegrid.php?categoria='.$_GET['categoria'].'&brand='. $_GET['brand']);
        $result0 = $mysqli->query("SELECT a.id FROM articolo a join categoria c on c.id = a.categoria join brand b on b.id=a.id_brand WHERE b.nome = {$_GET['brand']} and c.categoria_articolo = {$_GET['categoria']}");
        $number_of_results = mysqli_num_rows($result0); //conta il numero delle righe ottenute
        $body -> setContent("number_of_films", $number_of_results);
        $number_of_pages = ceil($number_of_results / $results_per_page);
        $body -> setContent("number_of_pages", $number_of_pages);
        for ($page = 1; $page <= $number_of_pages; $page++) {
            $body->setContent("tagpagina",'<a href="movielist.php?categoria='.$_GET['categoria'].'&brand='.$_GET['brand'].'&page=' . $page . '">' . $page . '</a> ');
        }
    }
    while ($data = $result->fetch_assoc()) {
        $body -> setContent("pagina_articolo_categoria", 'moviesingle2.php?id=<[idImg]>');
        $body->setContent("nome_prod", $data['titolo']);
        $body->setContent("data_prod", $data['data_uscita']);
        $body->setContent("votazione_prod", $data['votazione']);
        $body->setContent("trama_prod", substr($data['trama'], 0, 300) . " [...]");
        $body->setContent("durata_prod", $data['durata']);
        $body->setContent("categoria_prod", $data['categoria']);
        $body->setContent("idImg", $data['idImgProd']);
    }
    $result = $mysqli->query("SELECT distinct c.id, c.categoria_articolo as categoria from articolo a join categoria c on a.categoria=c.id");
    while($data = $result->fetch_assoc()){
        $body->setContent("categorieCerca", '<option value="'. $data['categoria'] .'">'. $data['categoria'] .'</option>');
    }
    $result = $mysqli->query("SELECT distinct b.id as bid, b.nome as brand from articolo a join brand b on a.id_brand=b.id");
    while($data = $result->fetch_assoc()){
        $body->setContent("brandsCerca", '<option value="' . $data['brand'] . '">' . $data['brand'] . '</option>');
    }
}

$main->setContent("body", $body->get());
$main->close();
?>