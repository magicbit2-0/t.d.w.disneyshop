<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";

if(isset($_GET['table'])){
    $table=$_GET['table'];
if ($table == 'parola_chiave_add'){
    $_SESSION['delete'] = "add";
    header("location: aggiungiParolaChiaveAdmin.php");
    exit;
}
if ($table == 'categoria_add'){
    $_SESSION['delete'] = "add";
    header("location: aggiungiCategoriaAdmin.php");
    exit;
}
    if ($table == 'brand_add'){
        $_SESSION['delete'] = "add";
        header("location: aggiungiBrand.php");
        exit;
    }
}

if (isset($mysqli)){
    if(isset($_GET['id']) and isset($_GET['table'])){
        $id=$_GET['id'];
        $table=$_GET['table'];
        if($table == 'categoria'){
            $result = $mysqli->query("update articolo set categoria = 0 where categoria = '$id'");
        }
        if($table == 'brand'){
            $result = $mysqli->query("update articolo set id_brand = 0 where id_brand = '$id'");
        }
        $result = $mysqli->query("delete from {$table} where id = {$id} ");
        $_SESSION['delete'] = "el";
        switch ($table){
            case 'articolo':
                header("location: projects.php");
                break;
            case 'regia':
                header("location: listaAttoriAdmin.php");
                break;
            case 'personaggio':
                header("location: listaPersonaggiAdmin.php");
                break;
            case 'notizia':
                header("location: notizie.php");
                break;
            case 'ordine':
                header("location: invoiceUtenti.php");
                break;
            case 'parola_chiave':
                header("location: aggiungiParolaChiaveAdmin.php ");
                break;
            case 'categoria':
                header("location: aggiungiCategoriaAdmin.php");
                break;
            case 'brand':
                header("location: brands.php");
                break;
        }
    } else {
        echo "id o table non trovati";
        exit;
    }
}