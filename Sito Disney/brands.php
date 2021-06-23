<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/brands.html");

if(isset($_SESSION['delete'])){
    $body->setContent("alert", "deleted");
    unset($_SESSION['delete']);
}

if (isset($mysqli)) {
    $table = 'brand';
    $result = $mysqli->query("SELECT id as idBrand1, nome, descrizione FROM brand where id > 0");
    while($data = $result->fetch_assoc()) {
        $body->setContent("nome", $data['nome']);
        $body->setContent("idBrand1", $data['idBrand1']);
        $body->setContent("elimina", '
                                                <button class="btn btn-danger btn-sm" style="width: -webkit-fill-available;" onclick="document.getElementById(\'idN02'.$data['idBrand1'].'\').style.display=\'block\'">
                                                  <i class="fas fa-trash">
                                                  </i>Elimina</button>
                                                <div id="idN02' . $data['idBrand1'] . '" class="modal1" style="width: 800px;height: 300px;margin-top: 130px;margin-left: 450px;overflow: hidden;border-radius: 20px;">
                                                  <span onclick="document.getElementById(\'idN02'.$data['idBrand1'].'\').style.display=\'none\'" class="close1" title="Close Modal">&times;</span>
                                                  <div class="modal-content1"
                                                       style="width: auto;height: 300px;margin-top: -50px;padding:75px;border-radius: 20px;">
                                                    <div class="container1">
                                                      <h1>Elimina elemento</h1>
                                                      <p>Sei sicuro di voler eliminare questo elemento?</p>
                                                      <div class="clearfix1">
                                                        <button type="button" class="cancelbtn1" onclick="document.getElementById(\'idN02'.$data['idBrand1'].'\').style.display=\'none\'">Annulla</button>
                                                        <button type="button" class="deletebtn1" onclick="location.href=\'eliminaOggetto.php?id=' . $data['idBrand1'] . '&table=' . $table . '\'">Elimina</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>');
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
