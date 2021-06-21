<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/aggiungiBrand.html");

if(isset($_SESSION['delete'])){
    if($_SESSION['delete'] == 'el'){
        $body->setContent("alert", "deletedBrand");
    }
    elseif($_SESSION['delete'] == 'add'){
        $body->setContent("alert",'addedItem');
    }
    unset($_SESSION['delete']);
}

if (isset($mysqli)) {
    $result = $mysqli->query("select * from brand");
    $data = $result->fetch_assoc();

    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
    }

    if(isset($_POST['aggiungiBrand'])){
        $inputName = addslashes($_POST['inputName']);
        $inputDescrizione = addslashes($_POST['inputDescription']);
        $result = $mysqli->query("select nome from brand where nome = '$inputName';");
        if(mysqli_num_rows($result) === 0 ) {

            $result = $mysqli->query("insert into brand (nome, descrizione) values ('$inputName', '$inputDescrizione');");
            header("location: eliminaOggetto.php?table=brand_add");
            if (!$result) {
                echo "Error!";
                exit;
            }
        } else {
            $em = "questo elemento già esiste!";
            $body->setContent("alert", $em);
            foreach ($_POST as $key => $selectedOption) {
                $body->setContent($key, $selectedOption);
            }
        }
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
