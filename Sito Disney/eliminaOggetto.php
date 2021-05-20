<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";

if(isset($_GET['table'])){
    $table=$_GET['table'];
if ($table == 'parola_chiave_add'){
    $_SESSION['delete'] = "add";
    header("location: aggiungiParolaChiaveAdmin.php ");
    exit;
}
}

if (isset($mysqli)){
    if(isset($_GET['id']) and isset($_GET['table'])){
        $id=$_GET['id'];
        $table=$_GET['table'];
        switch ($table){
            case 'regia':
                //$result = $mysqli->query("delete from {$table} where id = {$id} ");
                $_SESSION['delete'] = "el";
                break;
            case 'personaggio':
                //$result = $mysqli->query("delete from {$table} where id = {$id} ");
                $_SESSION['delete'] = "el";
                break;
            case 'notizia':
                //$result = $mysqli->query("delete from {$table} where id = {$id} ");
                $_SESSION['delete'] = "el";
                break;
            case 'ordine':
                //$result = $mysqli->query("delete from {$table} where id = {$id} ");
                $_SESSION['delete'] = "el";
                break;
            case 'parola_chiave':
                //$result = $mysqli->query("delete from {$table} where id = {$id} ");
                $_SESSION['delete'] = "el";
                break;
        }
        if($table == 'regia'){
            header("location: listaAttoriAdmin.php");
        }elseif ($table == 'personaggio'){
            header("location: listaPersonaggiAdmin.php");
        } elseif ($table == 'notizia'){
            header("location: notizie.php");
        }elseif ($table == 'ordine'){
            header("location: invoiceUtenti.php");
        }elseif ($table == 'parola_chiave'){
            header("location: aggiungiParolaChiaveAdmin.php ");
        }
        //$result = $mysqli->query("delete from $table where id = $id");
    } else {
        echo "id o table non trovati";
        exit;
    }
}