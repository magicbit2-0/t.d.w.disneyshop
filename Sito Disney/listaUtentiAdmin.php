<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/contacts.html");
if (isset($mysqli)) {

    $result = $mysqli->query("select a.id as idAvatar, u.id as idUtente, concat(u.nome,' ', u.cognome) as nome, u.paese, u.regione, u.indirizzo, u.email from utente u join avatar a on u.avatar_id=a.id");
    while ($data = $result->fetch_assoc()){
        $body->setContent("idAvatar", $data['idAvatar']);
        $body->setContent("nome", $data['nome']);
        $body->setContent("paese", $data['paese']);
        $body->setContent("regione", $data['regione']);
        $body->setContent("indirizzo", $data['indirizzo']);
        $body->setContent("email", $data['email']);
        $body -> setContent("pagina_utente", "profileUtente.php?id=".$data['idUtente']);
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
