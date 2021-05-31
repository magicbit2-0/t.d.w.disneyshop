<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";


$body=new Template("dtml/ADMIN/pages/examples/aggiungi-notizia.html");

if (isset($mysqli)) {

    if(isset($_POST['aggiungiNotizia'])){
        $result = $mysqli->query("select titolo from notizia where titolo like '{$_POST['inputName']}'");
        if(mysqli_num_rows($result) === 0 ) {
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

                    $allowed_exs = array("jpg", "jpeg", "png","jfif");
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $result = $mysqli->query("insert into notizia (titolo, fonte, data_pubblicazione, descrizione, categoria, immagine)
                                                    values ('{$_POST['inputName']}','{$_POST['inputFonte']}','{$_POST['inputData']}',
                                                    '{$_POST['inputDescription']}','{$_POST['categoria']}','$imgData')");
                        $body->setContent("alert",'addedItem');
                        if (!$result) {
                            echo "Error!";
                            exit;
                        }
                    } else {
                        $em = "Non puoi caricare file di questo tipo";
                    }
                }
            } else {
                $em = "unknown error occured!";
            }
        } else {
            $em = "questo elemento già esiste!";
        }
    }
    if ($em != null) {
        $body->setContent("alert", $em);
        foreach ($_POST as $key => $selectedOption) {
            $body->setContent($key, $selectedOption);
        }
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
