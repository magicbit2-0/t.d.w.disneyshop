<?php

require "include/dbms.inc.php";

$result = $mysqli->query("select foto from brand where id = ".$_REQUEST['id']);
//$_GET['id']
$data = $result->fetch_assoc();

header("Content-Type: image/jpeg");
echo $data['foto'];

?>
<?php
