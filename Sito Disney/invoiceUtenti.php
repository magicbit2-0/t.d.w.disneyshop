<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/invoice_utenti.html");

if (isset($mysqli)) {
    /*nome e cognome utente*/
    $result = $mysqli->query("(SELECT a.titolo as titolo, a.data_uscita as data_uscita, a.categoria as categoria, a.prezzo as prezzo 
                                    FROM articolo a 
                                    join articolo_ordinato ao on a.id=ao.articolo_id
                                    join ordine o on ao.ordine_id=o.id
                                    join utente u on o.utente_id=u.id) union
                                    (SELECT concat(u.nome,' ', u.cognome) as nome, u.data_nascita, u.username, u.email 
                                    FROM utente u
                                    join ordine o on u.id=o.utente_id
                                    join articolo_ordinato ao on o.id=ao.ordine_id
                                    join articolo ar on ao.articolo_id=ar.id);");
    while($data = $result->fetch_assoc()) {
        $body->setContent("nome_utente", $data['nome']);
        /*INSERIRE LA WHERE CON ID UTENTE */
        $result0 = $mysqli->query("SELECT ao.ordine_id FROM articolo_ordinato ao
                                         join ordine o on o.id=ao.ordine_id
                                         join utente u on u.id=o.utente_id
                                         join articolo ar on ao.articolo_id=ar.id;");
        $number_orders = mysqli_num_fields($result0);
        $body->setContent("number_orders", $number_orders);
        $body->setContent("titolo", $data['titolo']);
        $body->setContent("data_uscita", $data['data_uscita']);
        $body->setContent("categoria_prod", $data['categoria']);
        $body->setContent("prezzo", $data['prezzo']);
    }
}

$main->setContent("body_admin", $body->get());
$main->close();
?>