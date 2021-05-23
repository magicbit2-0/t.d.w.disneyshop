<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/project-add.html");
if (isset($mysqli)) {

    $result = $mysqli->query("select * from parola_chiave");
    while ($data = $result->fetch_assoc()){
        $body->setContent("paroleChiave", '<option value="'.$data['id'].'">'.$data['testo'].'</option>');
        $body->setContent("paroleChiave1", '<option value="'.$data['id'].'">'.$data['testo'].'</option>');
    }

    $result = $mysqli->query("select id, nome from personaggio");
    while ($data = $result->fetch_assoc()){
        $body->setContent("nomiPersonaggi", '<option value="'.$data['id'].'">'.$data['nome'].'</option>');
    }
    $result = $mysqli->query("select r.id, concat(r.nome,' ',r.cognome) as nomeAttore from regia r 
                                    join parola_chiave_regia pcr on pcr.regia_id=r.id
                                    join parola_chiave p on p.id= pcr.parola_chiave_id
                                    where p.testo='attore'");
    while ($data = $result->fetch_assoc()){
        $body->setContent("nomiAttori", '<option value="'.$data['id'].'">'.$data['nomeAttore'].'</option>');
    }
    $result = $mysqli->query("select r.id, concat(r.nome,' ',r.cognome) as nomeRegista from regia r 
                                    join parola_chiave_regia pcr on pcr.regia_id=r.id
                                    join parola_chiave p on p.id= pcr.parola_chiave_id
                                    where p.testo='regia'");
    while ($data = $result->fetch_assoc()){
        $body->setContent("nomiRegisti", '<option value="'.$data['id'].'">'.$data['nomeRegista'].'</option>');
    }

    if(isset($_POST['aggiungiProdotto'])){
        $result = $mysqli->query("select id from articolo 
                                        where titolo like '{$_POST['inputName']}' and 
                                        categoria like '{$_POST['inputCategoria']}' and 
                                        data_uscita = '{$_POST['inputData']}' ");
        if(mysqli_num_rows($result) === 0 ) {
            $inputName = addslashes($_POST['inputName']);
            $inputCategoria = addslashes($_POST['inputCategoria']);
            $inputTrama = addslashes($_POST['inputTrama']);
            $inputDurata = addslashes($_POST['inputDurata']);
            $inputPrezzo = addslashes($_POST['inputPrezzo']);
            $imgName = $_FILES["customFile"]["name"];
            $imgType = $_FILES["customFile"]["type"];
            $img_size = $_FILES["customFile"]["size"];
            $imgData = addslashes(file_get_contents($_FILES["customFile"]["tmp_name"]));
            if (isset($_FILES['customTrailer']) and $_FILES['customTrailer']['error'] != 4)
            $vdoData = addslashes(file_get_contents($_FILES["customTrailer"]["tmp_name"]));
            else $vdoData = null;
            $error = $_FILES["customFile"]["error"];
            if ($error === 0) {
                if ($img_size > 1250000) {
                    $em = "il file è troppo grande";
                } else {
                    $img_ex = pathinfo($imgName, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);

                    $allowed_exs = array("jpg", "jpeg", "png","jfif");
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        /*$result = $mysqli->query("insert into articolo (titolo, data_uscita, durata, trama, votazione, prezzo, locandina, trailer,  categoria)
                                                    values ('$inputName','{$_POST['inputData']}',
                                                    '$inputDurata','$inputTrama', 0 ,
                                                    '$inputPrezzo','$imgData',
                                                    '$vdoData','$inputCategoria')");*/
                        echo "insert into articolo (titolo, data_uscita, durata, trama, votazione, prezzo, locandina, trailer,  categoria)
                                                    values ('$inputName','{$_POST['inputData']}',
                                                    '$inputDurata','$inputTrama', 0 ,
                                                    '$inputPrezzo','$imgData',
                                                    '$vdoData','$inputCategoria')" . "<br>";
                        $idArticolo = $mysqli->insert_id;
                        if(isset($_POST['aggiungiProdotto'])) {
                            echo "REGISTA: <br>";
                            if ($_POST['inputRegista'] !== '- - -' and count($_POST['inputRegista']) == 1) {
                                echo $_POST['inputRegista']."<br>";
                            } else echo "nessun regista messo <br>";
                            $parole_chiave = is_array($_POST['inputParoleChiave']) ? count($_POST['inputParoleChiave']) : 0;
                            if ($parole_chiave > 0) {
                                echo "PAROLE CHIAVE: <br>";
                                foreach ($_POST['inputParoleChiave'] as $idParolaChiave) {
                                    //$result = $mysqli->query("insert into articolo_parola_chiave (articolo_id , parola_chiave_id)
                                    //                    values ('$idArticolo','$idParolaChiave')");
                                    echo "$idParolaChiave <br>";

                                }
                            }
                            $attori_correlati = is_array($_POST['inputAttoriCorrelati']) ? count($_POST['inputAttoriCorrelati']) : 0;
                            if ($attori_correlati > 0) {
                                echo "ATTORI CORRELATI: <br>";
                                foreach ($_POST['inputAttoriCorrelati'] as $idAttoriCorrelati) {
                                //    $result = $mysqli->query("insert into backstage_articolo (regia_id , articolo_id)
                                //                        values ('$idAttoriCorrelati','$idArticolo')");
                                    echo "$idAttoriCorrelati <br>";
                                }
                            }
                            $personaggi_correlati = is_array($_POST['inputPersonaggiCorrelati']) ? count($_POST['inputPersonaggiCorrelati']) : 0;
                            if ($personaggi_correlati > 0) {
                                echo "PERSONAGGI CORRELATI: <br>";
                                foreach ($_POST['inputPersonaggiCorrelati'] as $idPersonaggiCorrelati) {
                                //    $result = $mysqli->query("insert into personaggio_articolo (personaggio_id , articolo_id)
                                //                        values ('$idPersonaggiCorrelati','$idArticolo')");
                                    echo "$idPersonaggiCorrelati <br>";
                                }
                            }
                            exit;
                        }
                        //$_POST = array();
                        //unset($_POST['aggiungiAttore']);
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

        print_r($_POST);
        exit;
    }

}
$main->setContent("body_admin", $body->get());
$main->close();
