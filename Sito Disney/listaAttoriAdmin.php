<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/regia.html");
if (isset($mysqli)) {


    $result = $mysqli->query("SELECT id as idActor, concat(nome,' ',cognome) as nomeAttore, anno_nascita,
                                    nazionalità FROM regia");
    while($data = $result->fetch_assoc()) {
        foreach ($data as $key => $value) {
            $body->setContent($key, $value);
        }
        $body->setContent("idActor1", $data['idActor']);
        $result1 = $mysqli->query("select k.testo as parola_chiave from parola_chiave k 
                                         join parola_chiave_regia pr on pr.parola_chiave_id=k.id
                                         join regia r on r.id=pr.regia_id where r.id={$data['idActor']}");
        while($data1=$result1->fetch_assoc()){
            $body->setContent("parola_chiave", $data1['parola_chiave']);
        }
    /*$result = $mysqli->query("select id as idImgAttore, nome, cognome, anno_nascita, eta, nazionalità as nazionalita, paese_nascita, biografia, foto from regia where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    while ($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave", $data['testo']);
    }*/
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
