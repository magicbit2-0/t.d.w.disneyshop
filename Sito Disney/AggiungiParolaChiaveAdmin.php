<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/aggiungi-parolaChiave.html");
if(isset($_POST['eliminaParola'])){
    header("location: eliminaOggetto.php?id={$_POST['inputKeyToDelete']}&table=parola_chiave");
}
if(isset($_SESSION['delete'])){
    if($_SESSION['delete'] == 'el'){
    $body->setContent("alert", "deletedKeyWord");
    }
    elseif($_SESSION['delete'] == 'add'){
        $body->setContent("alert",'addedItem');
    }
    unset($_SESSION['delete']);
}
if (isset($mysqli)) {

    $result = $mysqli->query("select * from parola_chiave order by testo");
    while ($data = $result->fetch_assoc()){
        $body->setContent("paroleChiave", '<option selected value="'.$data['id'].'">'.$data['testo'].'</option>');
        $body->setContent("parola_chiave", '<option value="'.$data['id'].'">'.$data['testo'].'</option>');
    }

    if(isset($_POST['aggiungiParola'])){
        $inputTesto = addslashes($_POST['inputTesto']);
        $result = $mysqli->query("select testo from parola_chiave where testo = '$inputTesto';");
        if(mysqli_num_rows($result) === 0 ) {

            $result = $mysqli->query("insert into parola_chiave (testo) values ('$inputTesto');");
            header("location: eliminaOggetto.php?table=parola_chiave_add");

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
$main->setContent("body_admin", $body->get());
$main->close();
?>
