<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/notizia.html");
if (isset($mysqli)) {
    /*per la categoria????*/
    $result = $mysqli->query("SELECT *
                                    FROM notizia where id= {$_GET['id']}");
    $data = $result->fetch_assoc();
    $table = 'notizia';
    $body->setContent("table", $table);
    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>