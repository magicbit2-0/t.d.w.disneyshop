<?php

require "include/dbms.inc.php";

$result = $mysqli->query("select sfondo from personalizzasito where id = {$_REQUEST['id']}");

$data = $result->fetch_assoc();

header("Content-Type: image/jpeg");
echo $data['sfondo'];

?>
