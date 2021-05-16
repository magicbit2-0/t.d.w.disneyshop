<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";
$var = array();
$body=new Template("dtml/ADMIN/pages/examples/modifica-regia.html");

$body->setContent("goBack", $_SERVER['HTTP_REFERER']);
if (isset($mysqli)) {
    $result = $mysqli->query("SELECT *
                                    FROM regia where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    $foto = $data['foto'];
    //echo $foto;
    //exit;
    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
    }
    $result = $mysqli->query("select k.id as id_parola,k.testo from parola_chiave k
                                         join parola_chiave_regia pr on pr.parola_chiave_id=k.id
                                         join regia r on r.id=pr.regia_id where r.id={$_GET['id']} order by k.id");
    $count = mysqli_num_rows($result);
    while ($data = $result->fetch_assoc()) {
        $var['id'][] = $data['id_parola'];
    }
    $result = $mysqli->query("select distinct id,testo from parola_chiave");
    for ($i = 0; $i <= $count; $i++) {
        while ($data = $result->fetch_assoc()) {
            if ($var['id'][$i] == $data['id']) {
                $body->setContent("parola_chiave", '<option selected value="' . $data['id'] . '">' . $data['testo'] . '</option>');
                break;
            } else {
                $body->setContent("parola_chiave", '<option value="' . $data['id'] . '">' . $data['testo'] . '</option>');
            }
        }
    }
    $var = array();
    $result = $mysqli->query("select distinct a.id as id_correlato, a.titolo as titolo_correlato, year(a.data_uscita) as data_uscita_correlato
                                    from articolo a join backstage_articolo ba on ba.articolo_id = a.id
                                    join regia r on r.id=ba.regia_id where r.id={$_GET['id']} order by a.id");
    $count = mysqli_num_rows($result);
    while ($data = $result->fetch_assoc()) {
        $var['id'][] = $data['id_correlato'];
    }
    $result = $mysqli->query("select distinct id,titolo from articolo where categoria like 'Film Disney'");
    for ($i = 0; $i <= $count; $i++) {
        while ($data = $result->fetch_assoc()) {
            if ($var['id'][$i] == $data['id']) {
                $body->setContent("film_correlati", '<option selected value="' . $data['id'] . '">' . $data['titolo'] . '</option>');
                break;
            } else {
                $body->setContent("film_correlati", '<option value="' . $data['id'] . '">' . $data['titolo'] . '</option>');
            }
        }
    }
    if (isset($_POST['submit'])) {
        $inputName =addslashes($_POST['inputName']);
        $inputSurname =addslashes($_POST['inputSurname']);
        $inputNazionalita =addslashes($_POST['inputNazionalità']);
        $inputPaese =addslashes($_POST['inputPeseNascita']);
        $inputBiografia =addslashes($_POST['inputDescription']);
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
                        $result = $mysqli->query("update regia set
                                                                nome = '$inputName',
                                                                cognome = '$inputSurname',
                                                                anno_nascita = '{$_POST['inputData']}',
                                                                eta = year(now())-year('{$_POST['inputData']}'),
                                                                nazionalità = '$inputNazionalita',
                                                                paese_nascita = '$inputPaese',
                                                                biografia = '$inputBiografia',
                                                                foto = '$imgData' where id = {$_GET['id']}");
                    }
                }
            }
        } else {
            $result = $mysqli->query("update regia set
                                                    nome = '$inputName',
                                                    cognome = '$inputSurname',
                                                    anno_nascita = '{$_POST['inputData']}',
                                                    eta = year(now())-year('{$_POST['inputData']}'),
                                                    nazionalità = '$inputNazionalita',
                                                    paese_nascita = '$inputPaese',
                                                    biografia = '$inputBiografia'
                                                    where id = {$_GET['id']}");
        }
        if (isset($_POST['inputParoleChiave'])){
            $result = $mysqli->query("delete from parola_chiave_regia where regia_id = {$_GET['id']}");
            foreach ($_POST['inputParoleChiave'] as $idParolaChiave) {
                $result = $mysqli->query("insert into parola_chiave_regia (regia_id , parola_chiave_id)
                                                       values ('{$_GET['id']}','$idParolaChiave')");
            }
        }
        if (isset($_POST['inputFilmCorrelati'])){
            $result = $mysqli->query("delete from backstage_articolo where regia_id = {$_GET['id']}");
            foreach ($_POST['inputFilmCorrelati'] as $idFilmCorrelati) {
                $result = $mysqli->query("insert into backstage_articolo (regia_id , articolo_id)
                                                        values ('{$_GET['id']}','$idFilmCorrelati')");
            }
        }
        header("location: infoAttoreAdmin.php?id={$_GET['id']}");
    }
}

$main->setContent("body_admin", $body->get());
$main->close();
?>