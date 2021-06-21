<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/project-edit.html");
$body->setContent("goBack", $_SERVER['HTTP_REFERER']);

if (isset($mysqli)) {
    $result = $mysqli->query("SELECT *
                                    FROM articolo where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    $foto = $data['locandina'];
    $trailer = $data['trailer'];
    //echo $foto;
    //exit;
    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
    }
    $result = $mysqli->query("SELECT c.id as cid,c.categoria_articolo as categoria, b.id as bid, b.nome as brand
                                    from categoria c join articolo a on c.id = a.categoria join brand b on b.id=a.id_brand 
                                    where a.id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    $body->setContent("categoria1", '<option value="' . $data['cid'] . '" selected>' . $data['categoria'] . '</option>');
    $body->setContent("brand1", '<option value="' . $data['bid'] . '" selected>' . $data['brand'] . '</option>');
    $result = $mysqli->query("select distinct c.id as cid, c.categoria_articolo as categoria from categoria c where c.id not in (
                                    SELECT distinct c.id from articolo a join categoria c on a.categoria=c.id
                                    where a.id = {$_GET['id']})");
    while($data = $result->fetch_assoc()){
        $body->setContent("categorie", '<option value="'. $data['cid'] .'">'. $data['categoria'] .'</option>');
    }
    $result = $mysqli->query("select distinct b.id as bid, b.nome as brand from brand b where b.id not in (
                                    SELECT distinct b.id from articolo a join brand b on a.id_brand=b.id
                                    where a.id = {$_GET['id']})");
    while($data = $result->fetch_assoc()){
        $body->setContent("brands", '<option value="' . $data['bid'] . '">' . $data['brand'] . '</option>');
    }
    if ($data['categoria'] <> 'Film') {
        $result = $mysqli->query("select p.id as id_personaggio from personaggio_articolo pa
                                                 join articolo a on a.id = pa.articolo_id
                                                 join personaggio p on p.id = pa.personaggio_id
                                                 where a.id={$_GET['id']} order by p.nome");
        $count = mysqli_num_rows($result);
        while ($data = $result->fetch_assoc()) {
            $var['id'][] = $data['id_personaggio'];
        }
        $result = $mysqli->query("select distinct id,nome from personaggio");
        $buffer = '<div class="form-group">
                          <label>Lista Personaggi</label>
                          <div class="select2-purple">
                            <select class="select2 select2-hidden-accessible" name="inputPersonaggiCorrelati[]" multiple="" data-placeholder="Seleziona gli attori del film" data-dropdown-css-class="select2-purple" style="width: 100%;" data-select2-id="2" tabindex="-1" aria-hidden="true">';
        for ($i = 0; $i <= $count; $i++) {
            while ($data = $result->fetch_assoc()) {
                if ($var['id'][$i] == $data['id']) {
                    $buffer .= '<option selected value="' . $data['id'] . '">' . $data['nome'] . '</option>';
                    break;
                } else {
                    $buffer .= '<option value="' . $data['id'] . '">' . $data['nome'] . '</option>';
                }
            }
        }
        $buffer .= '</select></div><!-- /.form-group --></div>';
        $body->setContent("personaggi", $buffer);

    } else {

        $body->setContent("categorie", '<option value="Film Disney" selected>Film Disney</option>');
        $result = $mysqli->query("select r.id as id_regista from backstage_articolo ba
                                                 join articolo a on a.id = ba.articolo_id
                                                 join regia r on r.id = ba.regia_id
                                                 join parola_chiave_regia kr on kr.regia_id = r.id
                                                 join parola_chiave k on k.id = kr.parola_chiave_id
                                                 where a.id={$_GET['id']} and k.testo='regia' ");
        $var['id'][] = $data['id_regista'];
        $result = $mysqli->query("select r.id, concat(r.nome,' ',r.cognome) as nomeRegista from regia r 
                                         join parola_chiave_regia pcr on pcr.regia_id=r.id
                                         join parola_chiave p on p.id= pcr.parola_chiave_id
                                         where p.testo='regia'");
        $count = mysqli_num_rows($result);
        $buffer = '<div class="form-group">
                  <label for="inputRegista">Regista</label>
                  <select name="inputRegista" id="inputRegista" class="form-control">';
        for ($i = 0; $i <= $count; $i++) {
            while ($data = $result->fetch_assoc()) {
                if ($var['id'][$i] == $data['id']) {
                    $buffer .= '<option selected value="' . $data['id'] . '">' . $data['nomeRegista'] . '</option>';
                    break;
                } else {
                    $buffer .= '<option value="' . $data['id'] . '">' . $data['nomeRegista'] . '</option>';
                }
            }
        }
        $buffer .= '</select></div>';
        $body->setContent("regista", $buffer);
        $var = array();
        $result = $mysqli->query("select r.id as id_attore from backstage_articolo ba
                                                 join articolo a on a.id = ba.articolo_id
                                                 join regia r on r.id = ba.regia_id
                                                 join parola_chiave_regia kr on kr.regia_id = r.id
                                                 join parola_chiave k on k.id = kr.parola_chiave_id
                                                 where a.id={$_GET['id']} and k.testo='attore' ");
        $count = mysqli_num_rows($result);
        while ($data = $result->fetch_assoc()) {
            $var['id'][] = $data['id_attore'];
        }
        $result = $mysqli->query("select r.id, concat(r.nome,' ',r.cognome) as nomeAttore from regia r 
                                                 join parola_chiave_regia pcr on pcr.regia_id=r.id
                                                 join parola_chiave p on p.id= pcr.parola_chiave_id
                                                 where p.testo='attore'");
        $buffer = '<div class="form-group">
                          <label>Lista Attori</label>
                          <div class="select2-purple">
                            <select class="select2 select2-hidden-accessible" name="inputAttoriCorrelati[]" multiple="" data-placeholder="Seleziona gli attori del film" data-dropdown-css-class="select2-purple" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">';
        for ($i = 0; $i <= $count; $i++) {
            while ($data = $result->fetch_assoc()) {
                if ($var['id'][$i] == $data['id']) {
                    $buffer .= '<option selected value="' . $data['id'] . '">' . $data['nomeAttore'] . '</option>';
                    break;
                } else {
                    $buffer .= '<option value="' . $data['id'] . '">' . $data['nomeAttore'] . '</option>';
                }
            }
        }
        $buffer .= '</select></div><!-- /.form-group --></div>';
        $body->setContent("personaggi", $buffer);

    }
    $var = array();
    $result = $mysqli->query("select k.id as id_parola,k.testo from parola_chiave k
                                         join articolo_parola_chiave pr on pr.parola_chiave_id=k.id
                                         join articolo a on a.id=pr.articolo_id where a.id={$_GET['id']} order by k.id");
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
    $result = $mysqli->query("(select a1.id , a2.id as id_correlato,a1.titolo as titolo, a2.titolo as titolo_correlato, 
                                    a2.categoria as categoria_correlato, YEAR(a2.data_uscita) as data_uscita_correlato 
                                    from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_id join articolo a2 on a2.id = tab.articolo_correlato_id 
                                    where a1.id = {$_GET['id']} ) union
                                    (select a1.id , a2.id as id_correlato,a1.titolo as titolo, a2.titolo as titolo_correlato, 
                                    a2.categoria as categoria_correlato, YEAR(a2.data_uscita) as data_uscita_correlato 
                                    from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_correlato_id join articolo a2 on a2.id = tab.articolo_id 
                                    where a1.id = {$_GET['id']} )");
    $count = mysqli_num_rows($result);
    while ($data = $result->fetch_assoc()) {
        $var['id'][] = $data['id_correlato'];
    }
    $result = $mysqli->query("select distinct id,titolo, categoria from articolo where id <> {$_GET['id']}");
    for ($i = 0; $i <= $count; $i++) {
        while ($data = $result->fetch_assoc()) {
            if ($var['id'][$i] == $data['id']) {
                $body->setContent("film_correlati", '<option selected value="' . $data['id'] . '">' . $data['titolo'] . ' - ' . $data['categoria'] . '</option>');
                break;
            } else {
                $body->setContent("film_correlati", '<option value="' . $data['id'] . '">' . $data['titolo'] . ' - ' . $data['categoria'] . '</option>');
            }
        }
    }
    if (isset($_POST['submit'])) {
        $inputName = addslashes($_POST['inputName']);
        $inputCategoria = addslashes($_POST['inputCategoria']);
        $inputTrama = addslashes($_POST['inputTrama']);
        $inputDurata = addslashes($_POST['inputDurata']);
        $inputPrezzo = addslashes($_POST['inputPrezzo']);
        $url = addslashes($_POST['customTrailer']);
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $inputTrailer = parse_url($url, PHP_URL_PATH);
        if (filter_var($url, FILTER_VALIDATE_URL) or $url == '') {
        } else {
            goto URL_INVALIDO;
        }
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
                        /*echo 'update articolo set titolo = '.$inputName.',data_uscita = '.$_POST['inputData'].',durata = '.$inputDurata.',
                                                    trama = '.$inputTrama.',prezzo = '.$inputPrezzo.',trailer = '.$inputTrailer.',
                                                    locandina = '.$imgData.',categoria = '.$inputCategoria.' where id ='. $_GET['id'];
                        */
                        $result = $mysqli->query("update articolo set
                                                                titolo = '$inputName',
                                                                data_uscita = '{$_POST['inputData']}',
                                                                durata = '$inputDurata',
                                                                trama = '$inputTrama',
                                                                prezzo = '$inputPrezzo',
                                                                locandina = '$imgData',
                                                                trailer = '$inputTrailer',
                                                                categoria = '$inputCategoria' where id = {$_GET['id']}");
                    }
                }
            }
        } else {
            $result = $mysqli->query("update articolo set
                                                    titolo = '$inputName',
                                                    data_uscita = '{$_POST['inputData']}',
                                                    durata = '$inputDurata',
                                                    trama = '$inputTrama',
                                                    prezzo = '$inputPrezzo',
                                                    trailer = '$inputTrailer',
                                                    categoria = '$inputCategoria' where id = {$_GET['id']}");
        }
            /*echo 'update articolo set titolo = '.$inputName.',data_uscita = '.$_POST['inputData'].',durata = '.$inputDurata.',
                                                        trama = '.$inputTrama.',prezzo = '.$inputPrezzo.',trailer = '.$inputTrailer.',
                                                        categoria = '.$inputCategoria.' where id ='. $_GET['id'];}
            echo "<br> PAROLE CORRELATE: <br>";*/
            if (isset($_POST['inputParoleChiave'])) {
                $result = $mysqli->query("delete from articolo_parola_chiave where regia_id = {$_GET['id']}");
                foreach ($_POST['inputParoleChiave'] as $idParolaChiave) {
                    //echo "$idParolaChiave <br>";
                    $result = $mysqli->query("insert into articolo_parola_chiave (articolo_id , parola_chiave_id)
                                                       values ('{$_GET['id']}','$idParolaChiave')");
                }
            }
            //echo "FILM CORRELATI: <br>";
            if (isset($_POST['inputFilmCorrelati'])) {
                $result = $mysqli->query("delete from articolo_correlato where articolo_id = {$_GET['id']}");
                foreach ($_POST['inputFilmCorrelati'] as $idFilmCorrelati) {
                    //echo "$idFilmCorrelati <br>";
                    $result = $mysqli->query("insert into articolo_correlato (articolo_id , articolo_correlato_id)
                                                       values ('{$_GET['id']}','$idFilmCorrelati')");
                }
            }
            //echo "PERSONAGGI: <br>";
            if (isset($_POST['inputPersonaggiCorrelati'])) {
                $result = $mysqli->query("delete from personaggio_articolo where articolo_id = {$_GET['id']}");
                foreach ($_POST['inputPersonaggiCorrelati'] as $idPersonaggiCorrelati) {
                    //echo "$idPersonaggiCorrelati <br>";
                    $result = $mysqli->query("insert into personaggio_articolo (articolo_id , personaggio_id)
                                                       values ('{$_GET['id']}','$idPersonaggiCorrelati')");
                }
            } else if (isset($_POST['inputAttoriCorrelati'])) {
                $result = $mysqli->query("delete from backstage_articolo where articolo_id = {$_GET['id']}");
                if (isset($_POST['inputRegista'])) {
                    //echo 'REGISTA: ' . $_POST['inputRegista'] . '<br>';
                    $result = $mysqli->query("insert into backstage_articolo (articolo_id , regia_id)
                                                           values ('{$_GET['id']}','{$_POST['inputRegista']}')");
                }
                //echo "ATTORI: <br>";
                foreach ($_POST['inputAttoriCorrelati'] as $idAttoriCorrelati) {
                    //echo "$idAttoriCorrelati <br>";
                    $result = $mysqli->query("insert into backstage_articolo (articolo_id , regia_id)
                                                       values ('{$_GET['id']}','$idAttoriCorrelati')");
                }
            }
            header("location: infoArticoloAdmin.php?id={$_GET['id']}");
            exit;
            URL_INVALIDO:
            $body->setContent("alert", "url non valido");
            foreach ($_POST as $key => $selectedOption) {
                $body->setContent($key, $selectedOption);
            }
        }
    }

$main->setContent("body_admin", $body->get());
$main->close();