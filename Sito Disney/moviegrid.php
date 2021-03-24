<?php
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/moviegrid.html");

$film = $mysqli->query("select  from articolo");

$main->close();
?>