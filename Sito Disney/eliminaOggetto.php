<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";


if (isset($mysqli)){
    if(isset($_GET['id']) and isset($_GET['table'])){
        $id=$_GET['id'];
        $table=$_GET['table'];
        switch ($table){
            case 'regia':
                //$result = $mysqli->query("delete from {$table} where id = {$id} ");
                $_SESSION['delete'] = "el";
                break;
        }
        header("location: listaAttoriAdmin.php");
        //$result = $mysqli->query("delete from $table where id = $id");
    } else {
        echo "id o table non trovati";
        exit;
    }
}