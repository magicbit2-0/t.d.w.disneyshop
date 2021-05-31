<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/aggiungi-admin.html");
if (isset($mysqli)) {

    $result = $mysqli->query("SELECT *
                                    FROM utente where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
    }
    $var = array();
    $result = $mysqli->query("select g.id as id_gruppo, g.`tipologia utente` as tipo_utente from gruppo g
                                         join gruppo_utente gu on g.id=gu.gruppo_id
                                         join utente u on u.id=gu.utente_id where u.id={$_GET['id']} and g.`tipologia utente`='amministratore'");
    $count = mysqli_num_rows($result);
    while ($data = $result->fetch_assoc()) {
        $var['id'][] = $data['id_gruppo'];
    }
    $result = $mysqli->query("select distinct g.id, g.`tipologia utente` as tipo_utente from gruppo g where g.`tipologia utente`='amministratore'");
    for ($i = 0; $i <= $count; $i++) {
        while ($data = $result->fetch_assoc()) {
            if ($var['id'][$i] == $data['id']) {
                $body->setContent("gruppi", '<option selected value="' . $data['id'] . '">' . $data['tipo_utente'] . '</option>');
                break;
            } else {
                $body->setContent("gruppi", '<option value="' . $data['id'] . '">' . $data['tipo_utente'] . '</option>');
            }
        }
    }

    if (isset($_POST['submit'])) {
        if (isset($_FILES) and $_FILES['customFile']['error'] != 4) {
            $imgName = $_FILES["customFile"]["name"];
            $imgType = $_FILES["customFile"]["type"];
            $img_size = $_FILES["customFile"]["size"];
            $imgData = addslashes(file_get_contents($_FILES["customFile"]["tmp_name"]));
            $error = $_FILES["customFile"]["error"];
            if ($error === 0) {
                if ($img_size > 1250000) {
                    $em = "il file è troppo grande";
                } else {
                    $img_ex = pathinfo($imgName, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);

                    $allowed_exs = array("jpg", "jpeg", "png", "jfif");
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $result = $mysqli->query("update utente set
                                                                nome = '{$_POST['inputName']}',
                                                                cognome = '{$_POST['inputSurname']}',
                                                                data_nascita = '{$_POST['inputData']}',
                                                                paese = '{$_POST['inputPaese']}',
                                                                regione = '{$_POST['inputRegione']}',
                                                                indirizzo = '{$_POST['inputIndirizzo']}',
                                                                email = '{$_POST['inputEmail']}',
                                                                where id = {$_GET['id']}");
                    }
                }
            }
        } else {
            $result = $mysqli->query("update utente set
                                            nome = '{$_POST['inputName']}',
                                            cognome = '{$_POST['inputSurname']}',
                                            data_nascita = '{$_POST['inputData']}',
                                            paese = '{$_POST['inputPaese']}',
                                            regione = '{$_POST['inputRegione']}',
                                            indirizzo = '{$_POST['inputIndirizzo']}',
                                            email = '{$_POST['inputEmail']}',
                                            where id = {$_GET['id']}");
        }
        if (isset($_POST['inputTipologia'])){
            $result = $mysqli->query("update gruppo_utente set gruppo_id = 2 where utente_id = {$_GET['id']}");
            /*
            $result = $mysqli->query("delete from gruppo_utente where utente_id = {$_GET['id']}");
            foreach ($_POST['inputTipologia'] as $idTipologia) {
                $result = $mysqli->query("insert into gruppo_utente (utente_id , gruppo_id)
                                                       values ('{$_GET['id']}',2)");
            }*/
        } else {
            $result = $mysqli->query("update gruppo_utente set gruppo_id = 1 where utente_id = {$_GET['id']}");
        }
        header("location: profileUtente.php?id={$_GET['id']}");
    }
}

$main->setContent("body_admin", $body->get());
$main->close();
?>
