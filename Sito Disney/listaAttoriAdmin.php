<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";
$cont = 1;
$body=new Template("dtml/ADMIN/pages/examples/regia.html");
if(isset($_SESSION['delete'])){
    $body->setContent("alert", "deleted");
    unset($_SESSION['delete']);
}
$table = 'regia';
if (isset($mysqli)) {
    $result = $mysqli->query("SELECT id as idActor, concat(nome,' ',cognome) as nomeAttore, anno_nascita,
                                    nazionalità FROM regia order by nomeAttore");
    while($data = $result->fetch_assoc()) {
        foreach ($data as $key => $value) {
            $body->setContent($key, $value);
        }
        $body->setContent("cont", $cont++);
        $body->setContent("idActor1", $data['idActor']);
        $body->setContent("elimina", '
                                                <button class="btn btn-danger btn-sm" style="width: -webkit-fill-available;" onclick="document.getElementById(\'idR01'.$data['idActor'].'\').style.display=\'block\'">
                                                  <i class="fas fa-trash">
                                                  </i>Elimina</button>
                                                <div id="idR01' . $data['idActor'] . '" class="modal1" style="width: 800px;height: 300px;margin-top: 130px;margin-left: 450px;overflow: hidden;border-radius: 20px;">
                                                  <span onclick="document.getElementById(\'idR01'.$data['idActor'].'\').style.display=\'none\'" class="close1" title="Close Modal">&times;</span>
                                                  <div class="modal-content1"
                                                       style="width: auto;height: 300px;margin-top: -50px;padding:75px;border-radius: 20px;">
                                                    <div class="container1">
                                                      <h1>Elimina elemento</h1>
                                                      <p>Sei sicuro di voler eliminare questo elemento?</p>
                                                      <div class="clearfix1">
                                                        <button type="button" class="cancelbtn1" onclick="document.getElementById(\'idR01'.$data['idActor'].'\').style.display=\'none\'">Annulla</button>
                                                        <button type="button" class="deletebtn1" onclick="location.href=\'eliminaOggetto.php?id=' . $data['idActor'] . '&table=' . $table . '\'">Elimina</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>');


        $result1 = $mysqli->query("select k.testo as parola_chiave from parola_chiave k 
                                         join parola_chiave_regia pr on pr.parola_chiave_id=k.id
                                         join regia r on r.id=pr.regia_id where r.id={$data['idActor']}");
        while ($data1 = $result1->fetch_assoc()) {
            $body->setContent("parola_chiave", $data1['parola_chiave']);
        }

    }


    /*$result = $mysqli->query("select id as idImgAttore, nome, cognome, anno_nascita, eta, nazionalità as nazionalita, paese_nascita, biografia, foto from regia where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    while ($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave", $data['testo']);
    }*/

}
$main->setContent("body_admin", $body->get());
$main->close();
?>
