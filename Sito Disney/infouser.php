<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth.inc.php";
require "bottonChange.php";


$body=new Template("dtml/info_user.html");

if(isset($mysqli)){
    $result = $mysqli->query("select * from utente u join indirizzo_spedizione i on (u.id = i.utente_id) join metodo_pagamento m on (u.id = m.utente_id) where u.id = {$_SESSION['idUtente']} limit 1");
    $rowcount = mysqli_num_rows($result);

    if( $rowcount > 0){    
        $data = $result->fetch_assoc();
        foreach ($data as $key => $value){ 
            $body->setContent($key,$value);
        }
    }
}


$main->setContent("body", $body->get());
$main->close();
?>