<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth.inc.php";

if (isset($mysqli)){
    
    $titolo=addslashes($_POST['titolo']);
    $testo=addslashes($_POST['testo']);

    $mysqli->query("insert into recensione (voto, titolo, testo, data, utente_id, articolo_id) 
                          values ('{$_POST['voto']}', '$titolo', '$testo', 
                          date(now()), '{$_SESSION['idUtente']}', '{$_POST['articolo_id']}')");

    $media_votazione = $mysqli->query("select avg(voto) from recensione where articolo_id = '{$_POST['articolo_id']}'");

    $data= $media_votazione->fetch_assoc();

    $mysqli->query("update articolo set votazione = {$data['avg(voto)']} where id='{$_POST['articolo_id']}'");

    $articolo = $mysqli->query("select c.categoria_articolo from categoria c join articolo a on c.id = a.categoria join brand b on b.id = a.id_brand where a.id = '{$_POST['articolo_id']}'");

    $data= $articolo->fetch_assoc();

    header('Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/moviesingle2.php?id='.$_POST['articolo_id']);
}
?>