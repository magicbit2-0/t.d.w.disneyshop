<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/invoice_utenti.html");

if (isset($mysqli)) {

    /*fatta a cazzo vederla n'attimo giusto per far apparire qualcosa. Vado al dentista ciao*/
    $result = $mysqli->query("(SELECT u.avatar_id as idAvatar, u.nome as titolo, u.username as data_uscita, u.email as categoria 
                                    FROM utente u join avatar a on u.avatar_id=a.id
                                    join ordine o on u.id=o.utente_id
                                    join articolo_ordinato ao on o.id=ao.ordine_id
                                    join articolo ar on ao.articolo_id=ar.id) union 
                                    (SELECT a.titolo, a.data_uscita, a.categoria, a.prezzo FROM articolo a 
                                    join articolo_ordinato ao on a.id=ao.articolo_id
                                    join ordine o on ao.ordine_id=o.id
                                    join utente u on o.utente_id=u.id
                                    join avatar av on u.avatar_id=av.id);");
    while($data = $result->fetch_assoc()) {
        $body->setContent("idAvatar", $data['idAvatar']);
        $body->setContent("titolo", $data['titolo']);
        $body->setContent("data_uscita", $data['data_uscita']);
        $body->setContent("categoria_prod", $data['categoria']);
        $body->setContent("prezzo", $data['prezzo']);
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>