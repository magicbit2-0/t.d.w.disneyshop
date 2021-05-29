<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";
$body=new Template("dtml/ADMIN/pages/examples/projects.html");
$cont=1;
if(isset($_SESSION['delete'])){
    $body->setContent("alert", "deleted");
    unset($_SESSION['delete']);
}
if (isset($mysqli)) {
    $table = 'articolo';
    $result = $mysqli->query("SELECT id as idImg, titolo, data_uscita, votazione, categoria 
                                    FROM articolo");
    while($data = $result->fetch_assoc()) {
        foreach ($data as $key => $value) {
            $body->setContent($key, $value);
            }
        $body->setContent("cont", $cont++);
        $body->setContent("votazione1", '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'.$data['votazione'].'" 
                                                        aria-valuemin="0" aria-valuemax="10" style="width: '. $data['votazione']*10 .'%"></div>');
    $body->setContent("elimina", '<button class="btn btn-danger btn-sm" style="width: -webkit-fill-available;" onclick="document.getElementById(\'idA01'.$data['idImg'].'\').style.display=\'block\'">
                                                  <i class="fas fa-trash">
                                                  </i>Elimina</button>
                                                <div id="idA01' . $data['idImg'] . '" class="modal1" style="width: 800px;height: 300px;margin-top: 130px;margin-left: 450px;overflow: hidden;border-radius: 20px;">
                                                  <span onclick="document.getElementById(\'idA01'.$data['idImg'].'\').style.display=\'none\'" class="close1" title="Close Modal">&times;</span>
                                                  <div class="modal-content1"
                                                       style="width: auto;height: 300px;margin-top: -50px;padding:75px;border-radius: 20px;">
                                                    <div class="container1">
                                                      <h1>Elimina elemento</h1>
                                                      <p>Sei sicuro di voler eliminare questo elemento?</p>
                                                      <div class="clearfix1">
                                                        <button type="button" class="cancelbtn1" onclick="document.getElementById(\'idA01'.$data['idImg'].'\').style.display=\'none\'">Annulla</button>
                                                        <button type="button" class="deletebtn1" onclick="location.href=\'eliminaOggetto.php?id=' . $data['idImg'] . '&table=' . $table . '\'">Elimina</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>');
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
