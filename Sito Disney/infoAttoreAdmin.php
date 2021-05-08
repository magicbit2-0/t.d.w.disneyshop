<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/persona.html");
if (isset($mysqli)) {
    $result = $mysqli->query("SELECT *
                                    FROM regia where id= {$_GET['id']}");
    $data = $result->fetch_assoc();
    $titolo = $data['titolo'];
    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
    }

    $result = $mysqli->query("select k.testo as parola_chiave from parola_chiave k 
                                         join parola_chiave_regia pr on pr.parola_chiave_id=k.id
                                         join regia r on r.id=pr.regia_id where r.id={$_GET['id']}");
    while($data = $result->fetch_assoc()){
        $body->setContent("parola_chiave", $data['parola_chiave'].'</p>');
    }

    $result = $mysqli->query("select distinct a.id as id_correlato, a.titolo as titolo_correlato, year(a.data_uscita) as data_uscita_correlato
                                    from articolo a join backstage_articolo ba on ba.articolo_id = a.id
                                    join regia r on r.id=ba.regia_id where r.id={$_GET['id']}");
    $number_of_results = mysqli_num_rows($result);
    if($number_of_results > 0) {
        while ($data = $result -> fetch_assoc()) {
            $body->setContent("film_correlati",'<td><a href="infoArticoloAdmin.php?id='.$data['id_correlato'].'">
                                                            <div style="margin-right: 25px;text-align-last: center;">
                                                                <img src=\'img.php?id='.$data['id_correlato'].'\' 
                                                                style="border-radius: 15px;height: 250px;" alt="">
                                                            <br>'.$data['titolo_correlato']
                                                            .'<small> ('.$data['data_uscita_correlato'].' )
                                                            </small></div></a>
                                                            </td>');
        }
    } else {
        $body->setContent("film_correlati", 'Non ci sono ancora film correlati.');
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
