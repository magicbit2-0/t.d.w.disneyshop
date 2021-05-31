<?php
require "include/dbms.inc.php";
session_start();
$main=new Template("dtml/index.html");
if($_SESSION['idUtente']!= null) {
    $main = new Template("dtml/index2.html");
    $result = $mysqli->query("(select g.`tipologia utente` as tipo_utente from gruppo g join gruppo_utente gu on gu.gruppo_id = g.id
                                    join utente u on u.id = gu.utente_id where u.id = '{$_SESSION['idUtente']}' order by tipo_utente)");
    while ($data = $result->fetch_assoc()) {
        if ($data['tipo_utente'] == 'amministratore') {
            $main->setContent("tipo_utente", '<li><a href="admin.php">Dashboard</a></li>');
        }
        if ($data['tipo_utente'] == 'cliente') {
            $main->setContent("tipo_utente", '<li><a href="userfavoritegrid.php">Preferiti</a></li>
                                                         <li><a href="userrate.php">Recensioni</a></li>
                                                         <li><a href="shoppage.php">Carrello</a></li>');
        }
    }
}
    if (isset($_REQUEST['accesso'])) {
        if ($_REQUEST['accesso'] == 'LoginError') {
            $body2 = new Template("dtml/login.html"); //ritenta accesso
            $body2->setContent("message", "errorLogin");
            $main->setContent("body2", $body2->get());
        }
        else if($_REQUEST['accesso'] == 'noLogin'){
            $body2 = new Template("dtml/login.html"); //ritenta accesso
            $body2->setContent("message", "noLogin");
            $main->setContent("body2", $body2->get());
        }

        /*else if($_REQUEST['accesso'] == 'LoginOk'){
            $main = new Template("dtml/index2.html"); //accesso effettuato
            $main->setContent("tipo_utente", '<li><a href="userfavoritegrid.php">Preferiti</a></li>
                                                             <li><a href="userrate.php">Recensioni</a></li>
                                                             <li><a href="userprofile.php?">Profilo</a></li>');
        exit;
        }*/
    }
?>