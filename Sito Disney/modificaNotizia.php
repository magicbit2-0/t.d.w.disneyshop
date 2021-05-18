<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/modifica-notizia.html");

if (isset($mysqli)) {
    $result = $mysqli->query("SELECT *
                                    FROM notizia where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    $immagine = $data['immagine'];
    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
    }

    $result = $mysqli->query("select distinct categoria from articolo");
    while ($data = $result->fetch_assoc()){
        $body->setContent("categoria", '<option>'.$data['categoria'].'</option>');
    }

    if (isset($_POST['submit'])) {
        $inputName =addslashes($_POST['inputName']);
        $inputFonte =addslashes($_POST['inputFonte']);
        $inputDescription =addslashes($_POST['inputDescription']);
        if (isset($_FILES) and $_FILES['customFile']['error'] != 4) {
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
                        $result = $mysqli->query("update notizia set
                                                            titolo = '$inputName',
                                                            fonte = '$inputFonte',
                                                            data_pubblicazione = '{$_POST['inputData']}',
                                                            descrizione = '$inputDescription',
                                                            categoria = '{$_POST['categoria']}',
                                                            immagine = '$imgData'
                                                            where id = {$_GET['id']}");
                    }
                }
            }
        } else {
            $result = $mysqli->query("update notizia set
                                                titolo = '$inputName',
                                                fonte = '$inputFonte',
                                                data_pubblicazione = '{$_POST['inputData']}',
                                                descrizione = '$inputDescription',
                                                categoria = '{$_POST['categoria']}'
                                                where id = {$_GET['id']}");
        }

        header("location: notizia.php?id={$_GET['id']}");
    }
}

$main->setContent("body_admin", $body->get());
$main->close();
?>