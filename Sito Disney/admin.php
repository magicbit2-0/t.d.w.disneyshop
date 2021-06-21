<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/admin.html");
if (isset($mysqli)) {

    $result0 = $mysqli->query("select o.id from ordine o");
    $number_of_results = mysqli_num_rows($result0);
    $body -> setContent("ordini", $number_of_results);

    $result1 = $mysqli->query("select a.id from articolo a");
    $number_of_results = mysqli_num_rows($result1);
    $body -> setContent("film", $number_of_results);

    $result2 = $mysqli->query("select p.id from personaggio p ");
    $number_of_results = mysqli_num_rows($result2);
    $body -> setContent("preferiti", $number_of_results);

    $result3 = $mysqli->query("select u.id from utente u");
    $number_of_results = mysqli_num_rows($result3);
    $body -> setContent("utenti_registrati", $number_of_results);

    $result = $mysqli->query("select sfondo, background_color from personalizzasito order by id desc");
    while($data = $result -> fetch_assoc()){
    $body->setContent("sfondo", $data['sfondo']);
    $body->setContent("color", $data['background_color']);
    }

    $var = array();
    $result = $mysqli->query("select a.id as id_correlato, a.trailer from trailer_home t join articolo a where t.id_articolo = a.id limit 6");
    $count = mysqli_num_rows($result);
    while ($data = $result->fetch_assoc()) {
        $var['id'][] = $data['id_correlato'];
    }
    $result = $mysqli->query("select distinct a.id, a.titolo from articolo a join categoria c on c.id = a.categoria join brand b on b.id = a.id_brand where a.trailer is not null");
    for ($i = 0; $i <= $count; $i++) {
        while ($data = $result->fetch_assoc()) {
            if ($var['id'][$i] == $data['id']) {
                $body->setContent("trailer", '<option selected value="' . $data['id'] . '">' . $data['titolo'] . ' - '.$data['categoria'].' </option>');
                break;
            } else {
                $body->setContent("trailer", '<option value="' . $data['id'] . '">' . $data['titolo'] . '- '.$data['categoria'].'</option>');
            }
        }
    }
    if (isset($_POST['submit'])) {
        if (isset($_POST['inputTrailerHomepage'])) {
            $result = $mysqli->query("delete from trailer_home");
            foreach ($_POST['inputTrailerHomepage'] as $idTrailerHome) {
                $result = $mysqli->query("insert into trailer_home (id_articolo)
                                                        values ('$idTrailerHome')");
            }
            header("location: admin.php");
        }
    }
    if (isset($_POST['submitSfondo'])) {
        if (isset($_POST['customSfondo'])) {
            $url = addslashes($_POST['customSfondo']);
            if (filter_var($url, FILTER_VALIDATE_URL) or $url == '') {
                $mysqli->query("delete from personalizzasito where sfondo is not null");
                $mysqli->query("insert into personalizzasito (sfondo) values ('$url')");
                header("Location: admin.php");
            } else {
                $em = "url non valido";
            }
        }
    } else if (isset($_POST['submitColor'])) {
        if (isset($_POST['customColor'])) {
            $color = addslashes($_POST['customColor']);
            $mysqli->query("delete from personalizzasito where background_color is not null");
            $mysqli->query("insert into personalizzasito (background_color) values ('$color')");
            header("Location: admin.php");
        } else {
            $em = "inserimento non valido";
        }
    }
    if ($em != null) {
        $body->setContent("alert", $em);
    }

}
$main->setContent("body_admin", $body->get());
$main->close();
?>