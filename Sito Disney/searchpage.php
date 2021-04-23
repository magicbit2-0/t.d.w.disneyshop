<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index.html");
$body=new Template("dtml/search_page.html");
$ricerca = "%{$_POST['parolaCercata']}%";
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

    $result = $mysqli->query("SELECT distinct a.id as idCercato, a.titolo , a.votazione, a.categoria
                                    FROM articolo a join personaggio_articolo pa on pa.articolo_id = a.id 
                                    join personaggio p on p.id = pa.personaggio_id
									left join backstage_articolo ba on ba.articolo_id = a.id
									left join regia r on r.id = ba.regia_id
                                    join articolo_parola_chiave apk on apk.articolo_id = a.id
                                    join parola_chiave k on k.id = apk.parola_chiave_id
                                    where (a.titolo like '$ricerca' or k.testo like '$ricerca' 
                                    or a.categoria like '$ricerca' or p.nome like '$ricerca') 
                                    ORDER BY votazione desc, data_uscita desc
                                    LIMIT " . $this_page_first_result . ',' . $results_per_page);
                    $result0 = $mysqli->query("SELECT distinct a.id as idCercato, a.titolo , a.votazione, a.categoria FROM articolo a join personaggio_articolo pa on pa.articolo_id = a.id 
                                        join personaggio p on p.id = pa.personaggio_id left join backstage_articolo ba on ba.articolo_id = a.id left join regia r on r.id = ba.regia_id
                                        join articolo_parola_chiave apk on apk.articolo_id = a.id join parola_chiave k on k.id = apk.parola_chiave_id where (a.titolo like '$ricerca' or k.testo like '$ricerca' 
                                        or a.categoria like '$ricerca' or p.nome like '$ricerca')");
                $number_of_results0 = mysqli_num_rows($result0); //conta il numero delle righe ottenute
    $result1 = $mysqli->query("select distinct p.id as idCercato, p.nome , p.data_nascita
									from personaggio p join personaggio_articolo pa on pa.personaggio_id = p.id
                                    join articolo a on a.id = pa.articolo_id
                                    join parola_chiave_personaggio pkp on pkp.personaggio_id = p.id
                                    join parola_chiave k on k.id=pkp.parola_chiave_id
                                    where (p.nome like '%$ricerca%' or k.testo like '%$ricerca%' or a.titolo like '%$ricerca%' or p.data_nascita like '%$ricerca%')
                                    LIMIT " . $this_page_first_result . ',' . $results_per_page);
                    $result0 = $mysqli->query("select distinct p.id as idCercato, p.nome , p.data_nascita from personaggio p join personaggio_articolo pa on pa.personaggio_id = p.id
                                        join articolo a on a.id = pa.articolo_id join parola_chiave_personaggio pkp on pkp.personaggio_id = p.id
                                        join parola_chiave k on k.id=pkp.parola_chiave_id where (p.nome like '%$ricerca%' or k.testo like '%$ricerca%' or a.titolo like '%$ricerca%' or p.data_nascita like '%$ricerca%')");
                $number_of_results1 = mysqli_num_rows($result0); //conta il numero delle righe ottenute
    $result2 = $mysqli->query("select distinct r.id as idCercato, concat (r.nome,' ',r.cognome) as nomeAttore, r.anno_nascita as dataAttore, k.testo as testoAttore
									from regia r join backstage_articolo ba on ba.regia_id= r.id
                                    join articolo a on a.id = ba.articolo_id
                                    join parola_chiave_regia pkr on pkr.regia_id = r.id
                                    join parola_chiave k on k.id=pkr.parola_chiave_id
                                    where (concat(r.nome,' ',r.cognome) like '%$ricerca%' or r.nome like '%$ricerca%' or r.cognome like '%$ricerca%' or k.testo like 
                                    '%$ricerca%' or a.titolo like '%$ricerca%' or r.anno_nascita like '%$ricerca%') and k.testo='attore' or 'regia'
                                    LIMIT " . $this_page_first_result . ',' . $results_per_page);
                    $result0 = $mysqli->query("select distinct r.id as idCercato, concat (r.nome,' ',r.cognome) as nomeAttore, r.anno_nascita as dataAttore, k.testo as testoAttore from regia r join backstage_articolo ba on ba.regia_id= r.id
                                        join articolo a on a.id = ba.articolo_id join parola_chiave_regia pkr on pkr.regia_id = r.id join parola_chiave k on k.id=pkr.parola_chiave_id
                                        where (concat(r.nome,' ',r.cognome) like '%$ricerca%' or r.nome like '%$ricerca%' or r.cognome like '%$ricerca%' or k.testo like 
                                        '%$ricerca%' or a.titolo like '%$ricerca%' or r.anno_nascita like '%$ricerca%') and k.testo='attore' or 'regia'");
                $number_of_results2 = mysqli_num_rows($result0); //conta il numero delle righe ottenute

                $number_of_results = $number_of_results0+$number_of_results1+$number_of_results2;
                echo $number_of_results0." ";
                echo $number_of_results1." ";
                echo $number_of_results2." ";
                $body -> setContent("number_of_films", $number_of_results);
                $number_of_pages = ceil($number_of_results / $results_per_page);
                $body -> setContent("number_of_pages", $number_of_pages);
                for ($page = 1; $page <= $number_of_pages; $page++) {
                    $body->setContent("tagpagina",'<a href="searchpage.php?'.$ricerca.'&page=' . $page . '">' . $page . '</a> ');
                }

    while ($data = $result->fetch_assoc()) {
            if ($data['categoria'] == "Film Disney"){
                $body -> setContent("pagina_articolo_categoria", 'moviesingle.php?id='.$data['idCercato']);
            }
            else if ($data['categoria'] <> "Film Disney"){
                $body -> setContent("pagina_articolo_categoria", 'moviesingle2.php?id='.$data['idCercato']);
            }
            $body->setContent("idCercato", $data['idCercato']); //moviesingle.php?id=<[idImgProd]>
            $body->setContent("titolo", $data['titolo']);
            $body->setContent("votazione", "<i class=\"ion-android-star\"></i>".$data['votazione']." /10");
            $body->setContent("categoria", $data['categoria']);
            $body->setContent("immagineCercata", 'img.php?id='.$data['idCercato']);

    }



    while ($data = $result1->fetch_assoc()) {
            $body -> setContent("pagina_articolo_categoria", 'celebritysingle2.php?id='.$data['idCercato']);
            $body->setContent("idCercato", $data['idCercato']);
            $body->setContent("titolo", $data['nome']);
            $body->setContent("votazione", $data['data_nascita']);
            $body->setContent("categoria", "Personaggio");
            $body->setContent("immagineCercata", 'imgPersonaggio.php?id='.$data['idCercato']);
    }



    while ($data = $result2->fetch_assoc()) {
            $body -> setContent("pagina_articolo_categoria", 'celebritysingle.php?id='.$data['idCercato']);
            $body->setContent("idCercato", $data['idCercato']);
            $body->setContent("titolo", $data['nomeAttore']);
            $body->setContent("votazione", $data['dataAttore']);
            $body->setContent("categoria", $data['testoAttore']);
            $body->setContent("immagineCercata", 'imgActor.php?id='.$data['idCercato']);
    }

}
$main->setContent("body", $body->get());
$main->close();
