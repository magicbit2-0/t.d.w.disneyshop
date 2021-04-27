<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index2.html");
$body=new Template("dtml/user_profile.html");

$main->setContent("body", $body->get());
$main->close();
?>