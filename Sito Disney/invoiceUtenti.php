<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";


$body=new Template("dtml/ADMIN/pages/examples/invoice_utenti.html");
if(isset($_SESSION['delete'])){
    $body->setContent("alert", "deleted");
    unset($_SESSION['delete']);
}
if (isset($mysqli)) {
    $table = 'ordine';
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
        $body->setContent("prezzo", $data1['prezzo']);
    }

        $body->setContent("elimina", '
                                                <button class="btn btn-danger btn-sm" style="width: -webkit-fill-available;" onclick="document.getElementById(\'idO01'.$data['idOrdine'].'\').style.display=\'block\'">
                                                  <i class="fas fa-trash" style="margin: 5px;">
                                                  </i>Annulla ordine</button>
                                                <div id="idO01' . $data['idOrdine'] . '" class="modal1" style="width: 800px;height: 300px;margin-top: 130px;margin-left: 450px;overflow: hidden;border-radius: 20px;">
                                                  <span onclick="document.getElementById(\'idO01'.$data['idOrdine'].'\').style.display=\'none\'" class="close1" title="Close Modal">&times;</span>
                                                  <div class="modal-content1"
                                                       style="width: auto;height: 300px;margin-top: -50px;padding:75px;border-radius: 20px;">
                                                    <div class="container1">
                                                      <h1>Annulla Ordine</h1>
                                                      <p>Sei sicuro di voler annullare questo ordine?</p>
                                                      <div class="clearfix1">
                                                        <button type="button" class="cancelbtn1" onclick="document.getElementById(\'idO01'.$data['idOrdine'].'\').style.display=\'none\'">Annulla</button>
                                                        <button type="button" class="deletebtn1" onclick="location.href=\'eliminaOggetto.php?id=' . $data['idOrdine'] . '&table=' . $table . '\'">Elimina</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>');
    }
    //a.titolo as titolo, a.data_uscita as data_uscita, a.categoria as categoria, a.prezzo as prezzo
}

$main->setContent("body_admin", $body->get());
$main->close();
?>