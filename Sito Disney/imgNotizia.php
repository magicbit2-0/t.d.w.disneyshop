<?php

require "include/dbms.inc.php";

$result = $mysqli->query("select immagine from notizia where id = ".$_REQUEST['id']);
//$_GET['id']
$data = $result->fetch_assoc();

header("Content-Type: image/jpeg");
echo $data['immagine'];

?>