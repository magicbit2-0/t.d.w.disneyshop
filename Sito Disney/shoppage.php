<?php
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index2.html");
$body=new Template("dtml/shop_page.html");

$main->setContent("body", $body->get());
$main->close();
?>