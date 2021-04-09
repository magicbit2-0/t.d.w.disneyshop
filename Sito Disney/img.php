<?php

require "include/dbms.inc.php";

$result = $mysqli->query("select locandina from articolo where id=101");

$data = $result->fetch_assoc();

header("Content-Type: image/jpeg");
echo $data['locandina'];

?>