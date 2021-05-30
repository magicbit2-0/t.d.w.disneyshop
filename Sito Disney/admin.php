<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth.inc.php";
require "include/adminFunctions.inc.php";
//$main=new Template("dtml/ADMIN/pages/examples/admin_body.html");

$body=new Template("dtml/ADMIN/pages/examples/admin.html");
if (isset($mysqli)) {

    $result0 = $mysqli->query("select o.id from ordine o");
    $number_of_results = mysqli_num_rows($result0);
    $body -> setContent("ordini", $number_of_results);

    $result1 = $mysqli->query("select a.id from articolo a");
    $number_of_results = mysqli_num_rows($result1);
    $body -> setContent("film", $number_of_results);

    $result2 = $mysqli->query("select a.id from articolo_preferito a");
    $number_of_results = mysqli_num_rows($result2);
    $body -> setContent("preferiti", $number_of_results);

    $result3 = $mysqli->query("select u.id from utente u");
    $number_of_results = mysqli_num_rows($result3);
    $body -> setContent("utenti_registrati", $number_of_results);
}
$main->setContent("body_admin", $body->get());
$main->close();
?>