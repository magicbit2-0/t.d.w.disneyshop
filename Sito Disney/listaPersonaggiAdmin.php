<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$cont=1;
$body=new Template("dtml/ADMIN/pages/examples/personaggi.html");
if(isset($_SESSION['delete'])){
    $body->setContent("alert", "deleted");
    unset($_SESSION['delete']);
}
$table = 'personaggio';
if (isset($mysqli)) {

    $result = $mysqli->query("SELECT id as idPersonaggio, nome, data_nascita FROM personaggio");
    while($data = $result->fetch_assoc()) {
        foreach ($data as $key => $value) {
            $body->setContent($key, $value);
        }
        $body->setContent("cont", $cont++);
        $body->setContent("idPersonaggio1", $data['idPersonaggio']);
        $body->setContent("elimina", '
                                                <button class="btn btn-danger btn-sm" style="width: -webkit-fill-available;" onclick="document.getElementById(\'idP01'.$data['idPersonaggio'].'\').style.display=\'block\'">
                                                  <i class="fas fa-trash">
                                                  </i>Elimina</button>
                                                <div id="idP01' . $data['idPersonaggio'] . '" class="modal1" style="width: 800px;height: 300px;margin-top: 130px;margin-left: 450px;overflow: hidden;border-radius: 20px;">
                                                  <span onclick="document.getElementById(\'idP01'.$data['idPersonaggio'].'\').style.display=\'none\'" class="close1" title="Close Modal">&times;</span>
                                                  <div class="modal-content1"
                                                       style="width: auto;height: 300px;margin-top: -50px;padding:75px;border-radius: 20px;">
                                                    <div class="container1">
                                                      <h1>Elimina elemento</h1>
                                                      <p>Sei sicuro di voler eliminare questo elemento?</p>
                                                      <div class="clearfix1">
                                                        <button type="button" class="cancelbtn1" onclick="document.getElementById(\'idP01'.$data['idPersonaggio'].'\').style.display=\'none\'">Annulla</button>
                                                        <button type="button" class="deletebtn1" onclick="location.href=\'eliminaOggetto.php?id=' . $data['idPersonaggio'] . '&table=' . $table . '\'">Elimina</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>');
        $result1 = $mysqli->query("select k.testo as parola_chiave from parola_chiave k 
                                         join parola_chiave_personaggio pp on pp.parola_chiave_id=k.id
                                         join personaggio p on p.id=pp.personaggio_id where p.id={$data['idPersonaggio']}");
        while($data1=$result1->fetch_assoc()){
            $body->setContent("parola_chiave", $data1['parola_chiave']);
        }
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
