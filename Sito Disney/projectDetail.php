<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/project-detail.html");
if (isset($mysqli)) {


}
$main->setContent("body_admin", $body->get());
$main->close();
?>

