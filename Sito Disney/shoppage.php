<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/shop_page.html");

if(isset($mysqli)){

    

}


$main->setContent("body", $body->get());
$main->close();
?>