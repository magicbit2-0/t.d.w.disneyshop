<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/pixar.html");

if (isset($mysqli)) {

    $result = $mysqli->query("select id, nome, descrizione from brand where nome = 'Pixar'");
    $data = $result->fetch_assoc();
    foreach($data as $key => $value){
        $body->setContent($key,$value);
    }
}

$main->setContent("body", $body->get());
$main->close();
?>