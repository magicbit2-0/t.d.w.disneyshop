<?php
session_start();
require "include/dbms.inc.php";
echo "qui " .$_GET['id'];

    for ($i=0;$i<count($_SESSION['articoli']);$i++){
        if ($i == $_GET['index']){
            unset($_SESSION['articoli'][$i]);
            sort($_SESSION['articoli']);
        }
    }

    header('Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/shoppage.php');
?>