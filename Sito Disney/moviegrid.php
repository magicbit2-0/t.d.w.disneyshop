<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/movie_grid.html");

if (isset($mysqli)) {
    /*echo $_GET['ordinamento'].' ciao '.$_POST['categorie'];*/
    $results_per_page = 12;
    if (!isset($_GET['page'])) {
        $page = 1;
        $body -> setContent("actual_page", 1);
    } else {
        $page = $_GET['page'];
        $body -> setContent("actual_page", $_GET['page']);
    }
    $this_page_first_result = ($page - 1) * $results_per_page;

    if (!isset($_GET['categoria'])) {
        $result = $mysqli->query("SELECT id as idImgProd, titolo, votazione, categoria 
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
                    $body->setContent("tagpagina",'<a href="moviegrid.php?page=' . $page . '">' . $page . '</a> ');
                }
    } else {
        $result = $mysqli->query("SELECT id as idImgProd, titolo, votazione, categoria FROM articolo
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
                    $body->setContent("tagpagina",'<a href="moviegrid.php?categoria='.$_GET['categoria'].'&page=' . $page . '">' . $page . '</a> ');
                }
    }
    while ($data = $result->fetch_assoc()) {
        if ($data['categoria'] == "Film Disney"){
            $body -> setContent("pagina_articolo_categoria", 'moviesingle.php?id=<[idImgProd]>');
        }
        else if ($data['categoria'] <> "Film Disney"){
            $body -> setContent("pagina_articolo_categoria", 'moviesingle2.php?id=<[idImgProd]>');
        }
        $body->setContent("titolo_prodotto", $data['titolo']);
        $body->setContent("votazione_prodotto", $data['votazione']);
        $body->setContent("idImgProd", $data['idImgProd']);
    }
    $body -> setContent("actual_page", $_GET['page']);
}
$main->setContent("body", $body->get());
$main->close();
?>