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
            $main->setContent("tipo_utente", '<li><a href="admin.php">Dashboard</a></li>
                                                         <li><a href="userfavoritegrid.php">Preferiti</a></li>
                                                         <li><a href="userrate.php">Recensioni</a></li>
                                                         <li><a href="shoppage.php">Carrello</a></li>');
            break;
        }
        else if ($data['tipo_utente'] == 'cliente') {
            $main->setContent("tipo_utente", '<li><a href="userfavoritegrid.php">Preferiti</a></li>
                                                         <li><a href="userrate.php">Recensioni</a></li>
                                                         <li><a href="shoppage.php">Carrello</a></li>');
            break;
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
$result = $mysqli->query("select distinct c.id,c.categoria_articolo as categoria, b.nome as brand from articolo a join categoria c on c.id=a.categoria 
                                    join brand b on b.id=a.id_brand");
$buffer = '<li><a href="moviegrid.php">Tutti gli Articoli</a></li>
           <li><a href="moviegrid.php?categoria=\'Cartone\'">Tutti i Cartoni</a></li>
           <li><a href="moviegrid.php?categoria=\'Film\'">Tutti i Film</a></li>';
while ($data = $result->fetch_assoc()) {
    $buffer .= '<li><a href="moviegrid.php?categoria=\''.$data['categoria'].'\'&brand=\''. $data['brand'].'\'">'.$data['categoria'].' ' . $data['brand'].'</a></li>';
}
$main -> setContent('menuCategorie',$buffer);
?>