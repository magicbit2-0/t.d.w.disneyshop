<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/profileUtente.html");
if (isset($mysqli)) {

    $result = $mysqli->query("select a.id as idAvatar, concat(nome,' ',cognome) as nome, paese, regione, indirizzo, email 
                                    from utente u join avatar a on u.avatar_id=a.id where u.id= {$_GET['id']}");
    while ($data1 = $result->fetch_assoc()){
        $body->setContent("idAvatar", $data1['idAvatar']);
        $body->setContent("nome", $data1['nome']);
        $body->setContent("paese", $data1['paese']);
        $body->setContent("regione", $data1['regione']);
        $body->setContent("indirizzo", $data1['indirizzo']);
        $body->setContent("email", $data1['email']);
    }
    /*VEDERE I SINGOLO ORDINI DI UN SINGOLO UTENTE*/
    $result = $mysqli->query("select a.id as idArticolo, a.titolo 
                                    from articolo a 
                                    join articolo_ordinato ao on a.id=ao.articolo_id
                                    join ordine o on o.id=ao.ordine_id
                                    join utente u on u.id=o.utente_id");
    while ($data2 = $result->fetch_assoc()){
        $body->setContent("idArticolo", $data2['idArticolo']);
        $body->setContent("titolo_prodotto", $data2['titolo']);
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
