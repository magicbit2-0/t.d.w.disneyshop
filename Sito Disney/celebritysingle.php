<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/celebrity_single.html");

if (isset($mysqli)) {

    $result = $mysqli->query("select id as idImgAttore, nome, cognome, anno_nascita, eta, nazionalità, paese_nascita, biografia, foto");
    $data = $result->fetch_assoc();
    foreach($data as $key => $value){
        $body->setContent($key,$value);
    }


}

$main->setContent("body", $body->get());
$main->close();
?>