<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/movie_grid.html");

if (isset($mysqli)) {

    $result = $mysqli->query("(SELECT id as idImgProd, titolo, votazione, categoria FROM articolo ORDER BY data_uscita desc)");

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
}
$main->setContent("body", $body->get());
$main->close();
?>