<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/modificaBrand.html");

if (isset($mysqli)) {
    $result = $mysqli->query("SELECT *
                                    FROM brand where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
    }

    if (isset($_POST['modificaBrand'])) {
        $inputName = addslashes($_POST['inputName']);
        $inputDescription = addslashes($_POST['inputDescription']);

        $result = $mysqli->query("update brand set
                                        nome = '$inputName',
                                        descrizione = '$inputDescription'
                                        where id = {$_GET['id']}");

        header("location: brand.php?id={$_GET['id']}");
    }
}

$main->setContent("body_admin", $body->get());
$main->close();
?>