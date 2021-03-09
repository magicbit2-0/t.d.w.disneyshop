<?php

require "include/dbms.inc.php";

$result = $mysqli->query("select trailer from articolo where id={$_REQUEST['id']}");

$data = $result->fetch_assoc();

header("Content-Type: video/mp4");
echo $data['locandina'];

//commento prova per git su vs code
?>
