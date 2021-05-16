<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/project-add.html");
if (isset($mysqli)) {

    $result = $mysqli->query("select id, nome from personaggio");
    while ($data = $result->fetch_assoc()){
        $body->setContent("nomiPersonaggi", '<option>'.$data['nome'].'</option>');
    }
    $result = $mysqli->query("select r.id, concat(r.nome,' ',r.cognome) as nomeAttore from regia r 
                                    join parola_chiave_regia pcr on pcr.regia_id=r.id
                                    join parola_chiave p on p.id= pcr.parola_chiave_id
                                    where p.testo='attore'");
    while ($data = $result->fetch_assoc()){
        $body->setContent("nomiAttori", '<option>'.$data['nomeAttore'].'</option>');
    }
    $result = $mysqli->query("select r.id, concat(r.nome,' ',r.cognome) as nomeRegista from regia r 
                                    join parola_chiave_regia pcr on pcr.regia_id=r.id
                                    join parola_chiave p on p.id= pcr.parola_chiave_id
                                    where p.testo='regia'");
    while ($data = $result->fetch_assoc()){
        $body->setContent("nomiRegisti", '<option>'.$data['nomeRegista'].'</option>');
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
