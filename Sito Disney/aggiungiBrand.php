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

    if (isset($_POST['aggiungiBrand'])) {
        $inputName = addslashes($_POST['inputName']);
        $inputDescrizione = addslashes($_POST['inputDescription']);
        $result = $mysqli->query("select nome from brand where nome = '$inputName'");
        if (mysqli_num_rows($result) === 0) {
            $imgName = $_FILES["customFile"]["name"];
            $imgType = $_FILES["customFile"]["type"];
            $img_size = $_FILES["customFile"]["size"];
            $imgData = addslashes(file_get_contents($_FILES["customFile"]["tmp_name"]));
            $error = $_FILES["customFile"]["error"];
            if ($error === 0) {
                if ($img_size > 1250000) {
                    $em = "Il file è troppo grande";
                } else {
                    $img_ex = pathinfo($imgName, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);

                    $allowed_exs = array("jpg", "jpeg", "png", "jfif");
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $result = $mysqli->query("insert into brand (nome, descrizione, foto) values ('$inputName', '$inputDescrizione','$imgData');");
                        $body->setContent("alert", 'addedItem');
                        if (!$result) {
                            echo "Error!";
                            exit;
                        }
                    } else {
                        $em = "Non puoi caricare file di questo tipo";
                    }
                }
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
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
