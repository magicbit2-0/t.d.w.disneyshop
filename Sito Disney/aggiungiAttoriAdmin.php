<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

//$main=new Template("dtml/ADMIN/admin.html");
$body=new Template("dtml/ADMIN/pages/examples/aggiungi-regia.html");
if (isset($mysqli)) {

    $result = $mysqli->query("select * from parola_chiave");
    while ($data = $result->fetch_assoc()){
        $body->setContent("paroleChiave", '<option value="'.$data['id'].'">'.$data['testo'].'</option>');
    }
    $result = $mysqli->query("select a.id,a.titolo from articolo a where a.categoria like '%Film%'");
    while ($data = $result->fetch_assoc()){
        $body->setContent("filmCorrelati", '<option value="'.$data['id'].'">'.$data['titolo'].'</option>');
    }

    if(isset($_POST['aggiungiAttore'])){
        /*foreach ($_POST['inputParoleChiave'] as $selectedOption)
            echo $selectedOption."\n";
        */
        $result = $mysqli->query("select nome, cognome from regia where nome like '{$_POST['inputName']}' and cognome like '{$_POST['inputSurname']}'");
        if(mysqli_num_rows($result) === 0 ) {
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

                    $allowed_exs = array("jpg", "jpeg", "png");
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $result = $mysqli->query("insert into regia (nome, cognome, anno_nascita, eta, nazionalità, paese_nascita, biografia, foto)
                                                    values ('{$_POST['inputName']}','{$_POST['inputSurname']}',
                                                    '{$_POST['inputData']}',year(now())-year('{$_POST['inputData']}'),
                                                    '{$_POST['inputNazionalità']}','{$_POST['inputPeseNascita']}',
                                                    '{$_POST['inputDescription']}','$imgData')");
                        $idRegia = $mysqli->insert_id;
                        foreach ($_POST['inputParoleChiave'] as $idParolaChiave) {
                            $result = $mysqli->query("insert into parola_chiave_regia (regia_id , parola_chiave_id)
                                                        values ('$idRegia','$idParolaChiave')");
                        }
                        $film_correlati = is_array($_POST['inputFilmCorrelati']) ? count($_POST['inputFilmCorrelati']) : 0;
                        if ($film_correlati > 0) {
                            foreach ($_POST['inputFilmCorrelati'] as $idFilmCorrelati) {
                                $result = $mysqli->query("insert into backstage_articolo (regia_id , articolo_id)
                                                        values ('$idRegia','$idFilmCorrelati')");
                            }
                        }
                        unset($_POST['aggiungiAttore']);
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
    if ($em != null){
        $body->setContent("alert",$em);
        header("location: aggiungiAttoriAdmin.php?error=$em");
    } else {
        
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
