<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/profileUtente.html");
if (isset($mysqli)) {

    $result0 = $mysqli->query("select a.id from articolo_preferito a join utente u on a.utente_id=u.id where u.id={$_GET['id']}");
    $number_of_results = mysqli_num_rows($result0);
    $body -> setContent("n_preferiti", $number_of_results);

    $result1 = $mysqli->query("select a.id from articolo_ordinato a join ordine o on a.ordine_id=o.id 
                                     join utente u on u.id=o.utente_id where u.id={$_GET['id']}");
    $number_of_results = mysqli_num_rows($result1);
    $body -> setContent("n_ordini", $number_of_results);

    $result2 = $mysqli->query("select r.id from recensione r join utente u on r.utente_id=u.id where u.id={$_GET['id']}");
    $number_of_results = mysqli_num_rows($result2);
    $body -> setContent("n_votazioni", $number_of_results);

    $result = $mysqli->query("select a.id as idAvatar, u.id as idUtente, concat(nome,' ',cognome) as nome, paese, regione, indirizzo, email 
                                    from utente u join avatar a on u.avatar_id=a.id where u.id= {$_GET['id']}");
    while ($data1 = $result->fetch_assoc()){
        $body->setContent("idAvatar", $data1['idAvatar']);
        $body->setContent("nome", $data1['nome']);
        $body->setContent("paese", $data1['paese']);
        $body->setContent("regione", $data1['regione']);
        $body->setContent("indirizzo", $data1['indirizzo']);
        $body->setContent("email", $data1['email']);
    }

    $result = $mysqli->query("select a.id as idArticolo, a.titolo, a.data_uscita, a.prezzo
                                    from articolo a 
                                    join articolo_ordinato ao on a.id=ao.articolo_id
                                    join ordine o on o.id=ao.ordine_id
                                    join utente u on u.id=o.utente_id where u.id= {$_GET['id']}");
    while ($data2 = $result->fetch_assoc()){
        $body->setContent("idArticolo", $data2['idArticolo']);
        $body->setContent("titolo_prodotto", $data2['titolo']);
        $body->setContent("data_uscita", $data2['data_uscita']);
        $body->setContent("prezzo", $data2['prezzo']);
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
