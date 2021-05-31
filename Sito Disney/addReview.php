<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth.inc.php";

if (isset($mysqli)){
    
    $mysqli->query("insert into recensione (voto, titolo, testo, data, utente_id, articolo_id) 
                          values ('{$_POST['voto']}', '{$_POST['titolo']}', '{$_POST['testo']}', 
                          date(now()), '{$_SESSION['idUtente']}', '{$_POST['articolo_id']}')");

    $media_votazione = $mysqli->query("select avg(voto) from recensione where articolo_id = '{$_POST['articolo_id']}'");

    $data= $media_votazione->fetch_assoc();

    $mysqli->query("update articolo set votazione = {$data['avg(voto)']} where id='{$_POST['articolo_id']}'");

    $articolo = $mysqli->query("select categoria from articolo where id = '{$_POST['articolo_id']}'");

    $data= $articolo->fetch_assoc();

    if($data['categoria'] == "Film Disney") {
        header('Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/moviesingle.php?id='.$_POST['articolo_id']);

    }else{
        header('Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/moviesingle2.php?id='.$_POST['articolo_id']);
    }
}
?>