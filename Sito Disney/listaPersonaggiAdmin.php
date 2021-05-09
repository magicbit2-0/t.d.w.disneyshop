<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/personaggi.html");
if (isset($mysqli)) {


    $result = $mysqli->query("SELECT id as idPersonaggio, nome, data_nascita FROM personaggio");
    while($data = $result->fetch_assoc()) {
        foreach ($data as $key => $value) {
            $body->setContent($key, $value);
        }
        $body->setContent("idPersonaggio1", $data['idPersonaggio']);
        $result1 = $mysqli->query("select k.testo as parola_chiave from parola_chiave k 
                                         join parola_chiave_personaggio pp on pp.parola_chiave_id=k.id
                                         join personaggio p on p.id=pp.personaggio_id where p.id={$data['idPersonaggio']}");
        while($data1=$result1->fetch_assoc()){
            $body->setContent("parola_chiave", $data1['parola_chiave']);
        }
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
