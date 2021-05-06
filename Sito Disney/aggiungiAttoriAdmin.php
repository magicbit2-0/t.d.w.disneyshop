<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

//$main=new Template("dtml/ADMIN/admin.html");
$body=new Template("dtml/ADMIN/pages/examples/aggiungi-regia.html");
if (isset($mysqli)) {

    $result = $mysqli->query("select * from parola_chiave");
    while ($data = $result->fetch_assoc()){
        $body->setContent("paroleChiave", '<option value="'.$data['id'].'">'.$data['testo'].'</option>');
    }
    $result = $mysqli->query("select a.id,a.titolo from articolo a where a.categoria like '%Film%'");
    while ($data = $result->fetch_assoc()){
        $body->setContent("filmCorrelati", '<option value="'.$data['id'].'">'.$data['titolo'].'</option>');
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
