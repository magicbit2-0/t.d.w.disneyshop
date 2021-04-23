<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/search_page.html");

if (isset($mysqli)) {

    $result = $mysqli->query("SELECT id as idCercato, titolo , votazione, categoria 
                                    FROM articolo where titolo like {$_POST['parolaCercata']}
                                    ORDER BY votazione desc, data_uscita desc "); //'%Leone%'
    while ($data = $result->fetch_assoc()) {
            if ($data['categoria'] == "Film Disney"){
                $body -> setContent("pagina_articolo_categoria", 'moviesingle.php?id='.$data['idCercato']);
            }
            else if ($data['categoria'] <> "Film Disney"){
                $body -> setContent("pagina_articolo_categoria", 'moviesingle2.php?id='.$data['idCercato']);
            }
            $body->setContent("idCercato", $data['idCercato']); //moviesingle.php?id=<[idImgProd]>
            $body->setContent("titolo", $data['titolo']);
            $body->setContent("votazione", $data['votazione']);
            $body->setContent("categoria", $data['categoria']);
            $body->setContent("immagineCercata", 'img.php?id='.$data['idCercato']);

    }

    $result = $mysqli->query("SELECT id as idCercato, nome , descrizione 
                                    FROM personaggio where nome like '%simba%'");
    while ($data = $result->fetch_assoc()) {
    $body->setContent("idCercato", $data['idCercato']);
    $body->setContent("titolo", $data['nome']);
    $body->setContent("categoria", substr($data['descrizione'],0,25)." [...]");
    $body->setContent("immagineCercata", 'imgPersonaggio.php?id='.$data['idCercato']);
    }
}
$main->setContent("body", $body->get());
$main->close();
