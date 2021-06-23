<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/aggiungi-categoria.html");
if(isset($_POST['eliminaParola'])){
    header("location: eliminaOggetto.php?id={$_POST['inputKeyToDelete']}&table=categoria");
}
if(isset($_SESSION['delete'])){
    if($_SESSION['delete'] == 'el'){
    $body->setContent("alert", "deletedCategoria");
    }
    elseif($_SESSION['delete'] == 'add'){
        $body->setContent("alert",'addedItem');
    }
    unset($_SESSION['delete']);
}
if (isset($mysqli)) {

    $result = $mysqli->query("select * from categoria where id > 0 order by categoria_articolo");
    while ($data = $result->fetch_assoc()){
        $body->setContent("categorie", '<option selected value="'.$data['id'].'">'.$data['categoria_articolo'].'</option>');
        $body->setContent("categoria", '<option value="'.$data['id'].'">'.$data['categoria_articolo'].'</option>');
    }

    if(isset($_POST['aggiungiCategoria'])){
        $inputTesto = addslashes($_POST['inputTesto']);
        $result = $mysqli->query("select categoria_articolo from categoria where categoria_articolo = '$inputTesto';");
        if(mysqli_num_rows($result) === 0 ) {
            $result = $mysqli->query("insert into categoria (categoria_articolo) values ('$inputTesto');");
            header("location: eliminaOggetto.php?table=categoria_add");

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
