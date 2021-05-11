<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/notizie.html");
if (isset($mysqli)) {

    $result = $mysqli->query("SELECT id as idNotizia, titolo, fonte, data_pubblicazione, categria FROM notizia");
    while($data = $result->fetch_assoc()) {
        foreach ($data as $key => $value) {
            $body->setContent($key, $value);
        }
        $body->setContent("idNotizia1", $data['idNotizia']);
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
