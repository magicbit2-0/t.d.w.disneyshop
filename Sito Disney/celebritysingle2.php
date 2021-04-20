<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/celebrity_single2.html");

if(isset($mysqli)){

    $result = $mysqli->query("select id as id_personaggio, nome, descrizione, data_nascita, foto from personaggio where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    foreach($data as $key => $value){
        $body->setContent($key,$value);
    }
    
    /*$result = $mysqli->query("");
    while ($data = $result->fetch_assoc()){
        $body->setContent("", $data['']);
    }*/
}

$main->setContent("body", $body->get());
$main->close();
?>