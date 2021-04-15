<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/celebritysingle.html");
$body=new Template("dtml/celebrity_single.html");

$main->close();
?>