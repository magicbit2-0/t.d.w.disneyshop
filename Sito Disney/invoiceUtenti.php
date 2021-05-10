<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/invoice_utenti.html");

if (isset($mysqli)) {
    $result = $mysqli->query("SELECT concat(u.nome,' ',u.cognome) as nome, o.id as idOrdine, a.titolo as titolo, a.data_uscita as data_uscita, a.categoria as categoria, a.prezzo as prezzo 
                                    FROM articolo a 
                                    join articolo_ordinato ao on a.id=ao.articolo_id
                                    join ordine o on ao.ordine_id=o.id
                                    join utente u on o.utente_id=u.id;");
    while($data = $result->fetch_assoc()) {
        $body->setContent("nome_utente", $data['nome']);
        $body->setContent("number_orders", $data['idOrdine']);
        $body->setContent("titolo", $data['titolo']);
        $body->setContent("data_uscita", $data['data_uscita']);
        $body->setContent("categoria_prod", $data['categoria']);
        $body->setContent("prezzo", $data['prezzo']);
    }
}

$main->setContent("body_admin", $body->get());
$main->close();
?>