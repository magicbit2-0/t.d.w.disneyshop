<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";
$var = array();
$body=new Template("dtml/ADMIN/pages/examples/modifica-regia.html");
if (isset($mysqli)) {
    $result = $mysqli->query("SELECT *
                                    FROM regia where id= {$_GET['id']}");
    $data = $result->fetch_assoc();
    $titolo = $data['titolo'];
    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
    }
    /*$result = $mysqli->query("select k.id,k.testo from parola_chiave k
                                         join parola_chiave_regia pr on pr.parola_chiave_id=k.id
                                         join regia r on r.id=pr.regia_id where r.id={$_GET['id']}");
    */
    $result = $mysqli->query("select distinct a.id as id_correlato, a.titolo as titolo_correlato, year(a.data_uscita) as data_uscita_correlato
                                    from articolo a join backstage_articolo ba on ba.articolo_id = a.id
                                    join regia r on r.id=ba.regia_id where r.id={$_GET['id']}");
    while($data = $result->fetch_assoc()){
        $var['id'][]= $data['id_correlato'];
    }
    //$result = $mysqli->query("select id,testo from parola_chiave");
    $result = $mysqli->query("select distinct id,titolo from articolo where categoria like 'Film Disney'");
    while($data = $result->fetch_assoc()){
        foreach ($var['id'] as $key => $value){
        if ($value == $data['id']){
            $body->setContent("film_correlati", '<option selected value="'.$data['id'].'">'.$data['titolo'].'</option>');
            break;
        }else{
            $body->setContent("film_correlati", '<option value="'.$data['id'].'">'.$data['titolo'].'</option>');
        }
        }
    }
    while ($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave", '<option selected value="'.$data['id'].'">'.$data['testo'].'</option>');
    }

}
$main->setContent("body_admin", $body->get());
$main->close();
?>