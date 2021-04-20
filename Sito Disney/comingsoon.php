<?php
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("coming_soon.html");
if (isset($mysqli)) {

    $result = $mysqli->query("SELECT id as idImg FROM articolo WHERE data_uscita = '2021-11-09';");

    while ($data = $result->fetch_assoc()) {
        $body->setContent("idImg", $data['idImg']);
    }
}
$main->close();
?>