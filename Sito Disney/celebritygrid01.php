<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/celebrity_grid01.html");

if (isset($mysqli)) {


}
$main->setContent("body", $body->get());
$main->close();
?>