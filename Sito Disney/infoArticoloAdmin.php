<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/e-commerce.html");
if (isset($mysqli)) {
    $result = $mysqli->query("SELECT a.id as idImg, a.titolo, a.trama, a.durata, a.data_uscita, a.votazione, a.prezzo,c.categoria_articolo as categoria, 
                                    b.nome as brand
                                    FROM articolo a join categoria c on a.categoria=c.id
                                    join brand b on b.id=a.id_brand where a.id= {$_GET['id']}");
    $data = $result->fetch_assoc();
    $table = 'articolo';
    $body->setContent("table", $table);
    $titolo = $data['titolo'];
        foreach ($data as $key => $value) {
            $body->setContent($key, $value);
        }
    // if($data['categoria'] <> 'Film'){
        $result = $mysqli->query("(SELECT p.id as p_id, p.nome as p_nome FROM personaggio_articolo pa 
                                    join personaggio p on p.id = pa.personaggio_id 
                                    join articolo a on a.id = pa.articolo_id where a.id = {$_GET['id']})");
            if (mysqli_num_rows($result) > 0) {
                $buffer = '<p>Personaggi:  * ';
                while ($data = $result->fetch_assoc()) {
                    $buffer .= $data['p_nome'] . ' * ';
                }
                $body->setContent("personaggi", $buffer . '</p>');
            }
       // } else {
        $result = $mysqli->query("(select r.id as idRegista, concat(r.nome,' ', r.cognome) as regista from backstage_articolo b join articolo a on b.articolo_id = a.id join regia r on b.regia_id = r.id
                                    join parola_chiave_regia p on p.regia_id = r.id join parola_chiave k on k.id=p.parola_chiave_id 
                                    where k.testo = 'regia' and a.id = {$_GET['id']})");
        if(mysqli_num_rows($result) > 0){
            $data = $result->fetch_assoc();
                $body->setContent("regista",'<p>Regista: * '.$data['regista']. ' * </p>');
            }
        $result = $mysqli->query("(select distinct r.id as id_attore, concat(r.nome,' ', r.cognome) as attore from backstage_articolo b join articolo a on b.articolo_id = a.id join regia r on b.regia_id = r.id 
                                    join parola_chiave_regia p on p.regia_id = r.id join parola_chiave k on k.id=p.parola_chiave_id 
                                    where k.testo = 'attore' and a.id = {$_GET['id']})");
        if (mysqli_num_rows($result) > 0) {
            $buffer = '<p>Attori: * ';
            while ($data = $result->fetch_assoc()) {
                $buffer .= $data['attore'] . ' * ';
            }
            $body->setContent("attori", $buffer . '</p>');
        }
    //}
$result = $mysqli->query("(select a1.id , a2.id as id_correlato,a1.titolo as titolo, a2.titolo as titolo_correlato, 
                                    a2.categoria as categoria_correlato, YEAR(a2.data_uscita) as data_uscita_correlato 
                                    from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_id join articolo a2 on a2.id = tab.articolo_correlato_id 
                                    where a1.id = {$_GET['id']} ) union
                                    (select a1.id , a2.id as id_correlato,a1.titolo as titolo, a2.titolo as titolo_correlato, 
                                    a2.categoria as categoria_correlato, YEAR(a2.data_uscita) as data_uscita_correlato 
                                    from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_correlato_id join articolo a2 on a2.id = tab.articolo_id 
                                    where a1.id = {$_GET['id']} )");
$number_of_results = mysqli_num_rows($result);
if($number_of_results > 0) {
    while ($data = $result -> fetch_assoc()) {
        $body->setContent("correlati_text",'<td><a href="infoArticoloAdmin.php?id='.$data['id_correlato'].'">
                                                            <div style="margin-right: 25px;text-align-last: center;">
                                                                <img src=\'img.php?id='.$data['id_correlato'].'\' 
                                                                style="border-radius: 15px;height: 250px;" alt="">
                                                            <br>'.$data['titolo_correlato']
                                                            .'<small> ('.$data['data_uscita_correlato'].' )
                                                        </small></div></a>
                                                        </td>');
    }
} else {
    $body->setContent("correlati_text", 'Non ci sono film correlati a ' . $titolo);
}
}
$main->setContent("body_admin", $body->get());
$main->close();
?>

