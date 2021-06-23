<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/brandSito.html");

if (isset($mysqli)) {
    if ($_GET['id'] > 0) {
        $result = $mysqli->query("select * from brand where id={$_GET['id']} ");
        $data = $result->fetch_assoc();
        foreach ($data as $key => $value) {
            $body->setContent($key, $value);
        }
    }
    else {
        header("Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/index.php");
    }
}

$main->setContent("body", $body->get());
$main->close();
?>