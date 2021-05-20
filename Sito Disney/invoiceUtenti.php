<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/invoice_utenti.html");

if (isset($mysqli)) {
    $result = $mysqli->query("SELECT concat(u.nome,' ',u.cognome) as nome, o.id as idOrdine, (o.totale_parziale+o.spese_spedizione) as prezzoTotale, i.indirizzo1 as indirizzo 
                                    FROM articolo a 
                                    join articolo_ordinato ao on a.id=ao.articolo_id
                                    join ordine o on ao.ordine_id=o.id
                                    join utente u on o.utente_id=u.id 
                                    join indirizzo_spedizione i on i.utente_id = u.id
                                    group by o.id;");
    while($data = $result->fetch_assoc()) {
        $body->setContent("nome_utente", $data['nome']);
        $body->setContent("number_orders", $data['idOrdine']);
        $body->setContent("prezzoTotale", $data['prezzoTotale']);
        $body->setContent("indirizzo", $data['indirizzo']);


    $result1 = $mysqli->query("select a.titolo, year(a.data_uscita) as data_uscita, a.prezzo 
                             from articolo a 
                             join articolo_ordinato ao on a.id=ao.articolo_id
                             join ordine o on ao.ordine_id=o.id where
                             o.id = {$data['idOrdine']}
                             ");

    while ($data1=$result1->fetch_assoc()){
        $body->setContent("titolo", $data1['titolo']);
        $body->setContent("data_uscita", $data1['data_uscita']);
        //$body->setContent("categoria_prod", $data['categoria']);
        $body->setContent("prezzo", $data1['prezzo']);
    }
    }
    //a.titolo as titolo, a.data_uscita as data_uscita, a.categoria as categoria, a.prezzo as prezzo
}

$main->setContent("body_admin", $body->get());
$main->close();
?>