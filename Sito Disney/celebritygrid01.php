<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/celebrity_grid01.html");
$conteggio_celebrità = 0;

if (isset($mysqli)) {

    $result = $mysqli->query("(SELECT id as idImgPersonaggio, nome FROM personaggio) union (SELECT id as idImgRegia, concat(nome,' ', cognome) as nome_regia FROM regia)");

    while ($data = $result->fetch_assoc()){
        /*if ($data[''] == ""){
            $body -> setContent("pagina_celebrità", 'celebritysingle2.php?id=<[idImgPersonaggio]>');
        }
        else if ($data[''] <> ""){
            $body -> setContent("pagina_celebrità", 'celebritysingle.php?id=<[idImgRegia]>');
        }*/
        $conteggio++;
        $body->setContent("nome_personaggio", $data['nome']);
        $body->setContent("nome_attore", $data['nome_regia']);
        $body->setContent("idImgPersonaggio", $data['id']);
    }
    $body->setContent("conteggio", "".$conteggio);

}
$main->setContent("body", $body->get());
$main->close();
?>