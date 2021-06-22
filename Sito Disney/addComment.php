<?php

error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

if (isset($mysqli)){
    
    $nome= addslashes($_POST['nome']);
    $email= addslashes($_POST['email']);
    $commento= addslashes($_POST['commento']);
    
    $mysqli->query("insert into commento (nome, email, testo, data, notizia_id) values 
    ('$nome','$email','$commento',date(now()),'{$_POST['notizia']}')");
    
    header('Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/blogdetail.php?id='.$_POST['notizia']);
}
?>