<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/admin.html");
if (isset($mysqli)) {

    $result0 = $mysqli->query("select o.id from ordine o");
    $number_of_results = mysqli_num_rows($result0);
    $body -> setContent("ordini", $number_of_results);

    $result1 = $mysqli->query("select a.id from articolo a");
    $number_of_results = mysqli_num_rows($result1);
    $body -> setContent("film", $number_of_results);

    $result2 = $mysqli->query("select a.id from articolo_preferito a");
    $number_of_results = mysqli_num_rows($result2);
    $body -> setContent("preferiti", $number_of_results);

    $result3 = $mysqli->query("select u.id from utente u");
    $number_of_results = mysqli_num_rows($result3);
    $body -> setContent("utenti_registrati", $number_of_results);




    $var = array();
    $result = $mysqli->query("select a.id as id_correlato, a.trailer from trailer_home t join articolo a where t.id_articolo = a.id limit 6");
    $count = mysqli_num_rows($result);
    while ($data = $result->fetch_assoc()) {
        $var['id'][] = $data['id_correlato'];
    }
    $result = $mysqli->query("select distinct id, titolo, categoria from articolo where trailer is not null");
    for ($i = 0; $i <= $count; $i++) {
        while ($data = $result->fetch_assoc()) {
            if ($var['id'][$i] == $data['id']) {
                $body->setContent("trailer", '<option selected value="' . $data['id'] . '">' . $data['titolo'] . ' - '.$data['categoria'].' </option>');
                break;
            } else {
                $body->setContent("trailer", '<option value="' . $data['id'] . '">' . $data['titolo'] . '- '.$data['categoria'].'</option>');
            }
        }
    }

    if (isset($_POST['submit'])) {
        if (isset($_POST['inputTrailerHomepage'])){
            $result = $mysqli->query("delete from trailer_home");
            foreach ($_POST['inputTrailerHomepage'] as $idTrailerHome) {
                $result = $mysqli->query("insert into trailer_home (id_articolo)
                                                        values ('$idTrailerHome')");
            }
            header("location: admin.php");
        }
        //$inputBackgroundcolor = addslashes($_POST['inputBackgroundcolor']);
        /*if (isset($_FILES) and $_FILES['customFile']['error'] != 4) {
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
                        $result = $mysqli->query("update personalizzasito set
                                                        sfondo = '$imgData'");
                                                        //backgroundcolor
                    }
                }
            }
        }*/

    }

}
$main->setContent("body_admin", $body->get());
$main->close();
?>