<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/acquisto_simulato.html");

print_r($_POST);

print_r($_SESSION);

if(isset($mysqli)){

    //controllo salvataggio indirizzo in futuro
    if(array_key_exists("salvaIndirizzo",$_POST)){ //isset($_POST['salvaIndirizzo'])
        $result = $mysqli->query("SELECT * FROM disneydb.indirizzo_spedizione where utente_id = {$_SESSION['idUtente']};");
        $righe = mysqli_num_rows($result);

        if($righe == 0){
            //ne inserisco uno nuovo nel db
            $mysqli->query("insert into indirizzo_spedizione (id, nome, cognome, indirizzo1, indirizzo2, paese, regione, citta, cap, telefono, utente_id ) values (null,'{$_POST['name']}','{$_POST['surname']}','{$_POST['indirizzo1']}','{$_POST['indirizzo2']}','{$_POST['paese']}','{$_POST['stato']}','{$_POST['città']}','{$_POST['cap']}','{$_POST['numero']}','{$_SESSION['idUtente']}');");
            
        } else {
            //aggiorno quello che ho già nel db
            $mysqli->query("update indirizzo_spedizione set nome='{$_POST['name']}', cognome='{$_POST['surname']}', indirizzo1='{$_POST['indirizzo1']}', indirizzo2='{$_POST['indirizzo2']}', paese='{$_POST['paese']}', regione='{$_POST['stato']}', citta='{$_POST['città']}', cap='{$_POST['cap']}', telefono='{$_POST['numero']}' where utente_id = '{$_SESSION['idUtente']}';");

        }
    }

    //controllo salvataggio metodo di pagamento in futuro
    if(isset($_POST['salvaMetodoPagamento'])){
        $result = $mysqli->query("SELECT * FROM disneydb.metodo_pagamento where utente_id = {$_SESSION['idUtente']};");
        $righe = mysqli_num_rows($result);

        if($righe == 0){
            //ne inserisco uno nuovo nel db
            $mysqli->query("insert into metodo_pagamento (numero_carta,cvv,data_scadenza,nome_sulla_carta,utente_id) values('{$_POST['cardnumber']}','{$_POST['cvv']}','{$_POST['scadenza']}','{$_POST['nome_carta']}','{$_SESSION['idUtente']}');");
        } else {
            //aggiorno quello che ho già nel db
            $mysqli->query("update metodo_pagamento set numero_carta='{$_POST['cardnumber']}', cvv='{$_POST['cvv']}', data_scadenza='{$_POST['scadenza']}', nome_sulla_carta='{$_POST['nome_carta']}' where utente_id='{$_SESSION['idUtente']}';");
        }
    }

    //$mysqli->query("");
}

$main->setContent("body", $body->get());
$main->close();
?>