<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";

    $_SESSION['articoli'][]=$_GET['id'];

    header('Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/shoppage.php')
?>