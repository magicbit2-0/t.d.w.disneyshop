<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/celebrity_single2.html");
$numero=0;

if(isset($mysqli)){

    $result = $mysqli->query("select id as id_personaggio, nome, descrizione, data_nascita from personaggio where id = {$_GET['id']}");
    $data = $result->fetch_assoc();
    foreach($data as $key => $value){
        $body->setContent($key,$value);
    }

    $result = $mysqli-> query("SELECT p.testo as parola_chiave from parola_chiave_personaggio pc join parola_chiave p on pc.parola_chiave_id = p.id join personaggio d on d.id = pc.personaggio_id where d.id = {$_GET['id']}");
    while ($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave", $data['parola_chiave']);
    }

    $result = $mysqli->query("select a.id, a.titolo, a.data_uscita, a.categoria 
    from personaggio_articolo pa 
    join articolo a on a.id = pa.articolo_id 
    join personaggio p on p.id = pa.personaggio_id 
    join categoria c on a.categoria=c.id
    where p.id = {$_GET['id']}");

    while ($data = $result->fetch_assoc()){
        $body->setContent("idcartone", $data['id']);
        $body->setContent("titolo_film", $data['titolo']);
        $body->setContent("titolo_cartone", $data['titolo']);
        $body->setContent("data_cartone", $data['data_uscita']);

        if ($data['categoria'] <> 'Film Disney'){
            $body->setContent("collegamento","moviesingle2.php?id=".$data['id']);
        } else {
            $body->setContent("collegamento","moviesingle2.php?id=".$data['id']);
        }
    }

    $result = $mysqli->query("select a.id as idfilm, a.titolo as titolofilm, a.categoria as categoriafilm, a.data_uscita as data from personaggio as p join personaggio_articolo as pa on (p.id = pa.personaggio_id) join articolo as a on (pa.articolo_id = a.id) where p.id = {$_GET['id']}");   
    while($data = $result->fetch_assoc()){
        $numero++;
        $body->setContent("idfilm1",$data['idfilm']);
        $body->setContent("titolofilm1",$data['titolofilm']);
        $body->setContent("categoria_film",$data['categoria']);
        $body->setContent("datafilm1",$data['data']);
        
        if ($data['categoriafilm'] <> 'Film Disney'){
            $body->setContent("collegamento1","moviesingle2.php?id=".$data['idfilm']);
        } else {
            $body->setContent("collegamento1","moviesingle2.php?id=".$data['idfilm']);
        }
    }

    $body->setContent("numero",$numero);

}

$main->setContent("body", $body->get());
$main->close();
?>