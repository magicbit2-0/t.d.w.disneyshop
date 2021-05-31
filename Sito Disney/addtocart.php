<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth.inc.php";

    $_SESSION['articoli'][]=$_GET['id'];

    header('Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/shoppage.php');
?>