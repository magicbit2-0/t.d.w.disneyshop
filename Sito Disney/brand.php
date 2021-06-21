<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/brand.html");
if (isset($mysqli)) {
    $table = 'brand';
    $body->setContent("table", $table);
    $result = $mysqli->query("SELECT *
                                    FROM brand where id = {$_GET['id']}");
    $data = $result->fetch_assoc();

    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>