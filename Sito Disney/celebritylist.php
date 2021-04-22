<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/celebrity_list.html");

if (isset($mysqli)) {

    $results_per_page = 15;
    if (!isset($_GET['page'])) {
        $page = 1;
        $body -> setContent("actual_page", 1);
    } else {
        $page = $_GET['page'];
        $body -> setContent("actual_page", $_GET['page']);
    }
    $this_page_first_result = ($page - 1) * $results_per_page;
    switch($_GET['testo']) {
        case "'attore'":
            $result = $mysqli->query("select r.id as idPersonaggio, concat(r.nome,' ', r.cognome) as nomePersonaggio, k.testo as testo 
                                    from parola_chiave_regia pr 
                                    join parola_chiave k on pr.parola_chiave_id = k.id join regia r on pr.regia_id=r.id
                                    ORDER BY nome LIMIT " . $this_page_first_result . ',' . $results_per_page);
            $body -> setContent("categoria_lista",'celebritylist.php?testo='. $_GET['testo']);
            $body -> setContent("categoria_griglia",'celebritygrid01.php?testo='. $_GET['testo']);

            $result0 = $mysqli->query("SELECT id FROM regia");
            $number_of_results = mysqli_num_rows($result0); //conta il numero delle righe ottenute
            $body -> setContent("number_of_films", $number_of_results);
            $number_of_pages = ceil($number_of_results / $results_per_page);
            $body -> setContent("number_of_pages", $number_of_pages);
            for ($page = 1; $page <= $number_of_pages; $page++) {
                $body->setContent("tagpagina",'<a href="celebritygrid01.php?testo=\'attore\'&page=' . $page . '">' . $page . '</a> ');
            };
            break;
        case "'personaggio'":
            $result = $mysqli->query("select p.id as idPersonaggio, p.nome as nomePersonaggio, k.testo as testo from personaggio p 
                                    join parola_chiave_personaggio pc on pc.personaggio_id = p.id join parola_chiave k on pc.parola_chiave_id = k.id 
                                    where k.testo = 'personaggio' ORDER BY nome LIMIT " . $this_page_first_result . ',' . $results_per_page);
            $body -> setContent("categoria_lista",'celebritylist.php?testo='. $_GET['testo']);
            $body -> setContent("categoria_griglia",'celebritygrid01.php?testo='. $_GET['testo']);

            $result0 = $mysqli->query("SELECT id FROM personaggio");
            $number_of_results = mysqli_num_rows($result0); //conta il numero delle righe ottenute
            $body -> setContent("number_of_films", $number_of_results);
            $number_of_pages = ceil($number_of_results / $results_per_page);
            $body -> setContent("number_of_pages", $number_of_pages);
            for ($page = 1; $page <= $number_of_pages; $page++) {
                $body->setContent("tagpagina",'<a href="celebritygrid01.php?testo=\'personaggio\'&page=' . $page . '">' . $page . '</a> ');
            };
            break;
        default:
            $result = $mysqli->query("select p.id as idPersonaggio, p.nome as nomePersonaggio, k.testo as testo from personaggio p 
                                    join parola_chiave_personaggio pc on pc.personaggio_id = p.id join parola_chiave k on pc.parola_chiave_id = k.id where k.testo = 'personaggio' 
                                    union select p.id, p.nome, p.nome from personaggio p where p.id > 25 union
                                    select r.id, concat(r.nome,' ', r.cognome) , k.testo from parola_chiave_regia pr 
                                    join parola_chiave k on pr.parola_chiave_id = k.id join regia r on pr.regia_id=r.id
                                    ORDER BY nomePersonaggio LIMIT " . $this_page_first_result . ',' . $results_per_page);
            $body -> setContent("categoria_lista",'celebritylist.php');
            $body -> setContent("categoria_griglia",'celebritygrid01.php');

            $result0 = $mysqli->query("SELECT id FROM personaggio");
            $number_of_results = mysqli_num_rows($result0); //conta il numero delle righe ottenute
            $body -> setContent("number_of_films", $number_of_results);
            $number_of_pages = ceil($number_of_results / $results_per_page);
            $body -> setContent("number_of_pages", $number_of_pages);
            for ($page = 1; $page <= $number_of_pages; $page++) {
                $body->setContent("tagpagina",'<a href="celebritygrid01.php?page=' . $page . '">' . $page . '</a> ');
            };
            break;
    }
    while ($data = $result->fetch_assoc()){
        if ($data['testo'] == "attore" or $data['testo'] == "regia"){
            $body -> setContent("immagine_cast", "imgActor.php?id=".$data['idPersonaggio']);
            $body -> setContent("pagina_celebrità", "celebritysingle.php?id=".$data['idPersonaggio']);
            $body -> setContent("testo", $data['testo']);
            $body -> setContent("nome_celebrità", $data['nomePersonaggio']);
        } else {
            $body -> setContent("immagine_cast", "imgPersonaggio.php?id=".$data['idPersonaggio']);
            $body -> setContent("pagina_celebrità", "celebritysingle2.php?id=".$data['idPersonaggio']);
            $body -> setContent("testo", "PERSONAGGIO");
            $body -> setContent("nome_celebrità", $data['nomePersonaggio']);
        }
    }
    $result = $mysqli->query("select p.id as idPersonaggio1, p.nome as nomePersonaggio1, k.testo as testo1 from personaggio p 
                                    join parola_chiave_personaggio pc on pc.personaggio_id = p.id join parola_chiave k on pc.parola_chiave_id = k.id
                                    where (k.testo = 'personaggio' and (p.nome like 'Simba' or p.nome like 'Elsa'))
                                    union select r.id, concat(r.nome,' ', r.cognome) , k.testo from parola_chiave_regia pr 
                                    join parola_chiave k on pr.parola_chiave_id = k.id join regia r on pr.regia_id=r.id LIMIT 3");
    while ($data = $result->fetch_assoc()){
        if ($data['testo1'] == "attore" or $data['testo'] == "regia"){
            $body -> setContent("immagine_cast1", "imgActor.php?id=".$data['idPersonaggio1']);
            $body -> setContent("pagina_celebrità1", "celebritysingle.php?id=".$data['idPersonaggio1']);
            $body -> setContent("testo1", $data['testo1']);
            $body -> setContent("nome_celebrità1", $data['nomePersonaggio1']);
        } else {
            $body -> setContent("immagine_cast1", "imgPersonaggio.php?id=".$data['idPersonaggio1']);
            $body -> setContent("pagina_celebrità1", "celebritysingle2.php?id=".$data['idPersonaggio1']);
            $body -> setContent("testo1", "PERSONAGGIO");
            $body -> setContent("nome_celebrità1", $data['nomePersonaggio1']);
        }
    }
    $body -> setContent("actual_page", $_GET['page']);


}
$main->setContent("body", $body->get());
$main->close();
?>