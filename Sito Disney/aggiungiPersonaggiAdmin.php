<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

//$main=new Template("dtml/ADMIN/admin.html");
$body=new Template("dtml/ADMIN/pages/examples/aggiungi-personaggi.html");

if (isset($mysqli)) {

    $result = $mysqli->query("select * from parola_chiave");
    while ($data = $result->fetch_assoc()){
        $body->setContent("paroleChiave", '<option value="'.$data['id'].'">'.$data['testo'].'</option>');
    }
    $result = $mysqli->query("select a.id, a.titolo from articolo a where a.categoria like '%Cartone%' or '%Cortometraggi%'");
    while ($data = $result->fetch_assoc()){
        $body->setContent("cartoniCorrelati", '<option value="'.$data['id'].'">'.$data['titolo'].'</option>');
    }

    if(isset($_POST['aggiungiFilm'])){
        $result = $mysqli->query("select titolo from articolo where nome like '{$_POST['inputName']}'");
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
                        $result = $mysqli->query("insert into personaggio (nome, descrizione, data_nascita, foto)
                                                    values ('{$_POST['inputName']}','{$_POST['inputDescription']}',
                                                    '{$_POST['inputData']}','$imgData')");
                        $idPersonaggio = $mysqli->insert_id;
                        foreach ($_POST['inputParoleChiave'] as $idParolaChiave) {
                            $result = $mysqli->query("insert into parola_chiave_personaggio (personaggio_id , parola_chiave_id)
                                                        values ('$idPersonaggio','$idParolaChiave')");
                        }
                        $cartoni_correlati = is_array($_POST['inputCartoniCorrelati']) ? count($_POST['inputCartoniCorrelati']) : 0;
                        if ($cartoni_correlati > 0) {
                            foreach ($_POST['inputCartoniCorrelati'] as $idCartoniCorrelati) {
                                $result = $mysqli->query("insert into personaggio_articolo (articolo_id , personaggio_id)
                                                        values ('$idCartoniCorrelati','$idPersonaggio')");
                            }
                        }
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
    print_r($_POST);
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
