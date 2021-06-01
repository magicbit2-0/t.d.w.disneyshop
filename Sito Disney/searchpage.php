<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/search_page.html");
$ricerca = "%{$_POST['parolaCercata']}%";
$ricerca2 = "%{$_POST['parolaCercata2']}%";

if (isset($mysqli)) {
    $result = $mysqli->query("select sfondo,background_color from personalizzasito order by id desc limit 1");
    $data = $result ->fetch_assoc();
    if(mysqli_num_rows($result) != 0){
        if($data['sfondo'] != null){
            $body->setContent("common-hero", '<div class="hero common-hero" style="background: url(' . $data['sfondo'] . '); background-position: center">');
        } else {
            $body->setContent("common-hero", '<div class="hero common-hero" style="background:' . $data['background_color'] . ';">');
        }
    } else {
        $body->setContent("common-hero",'<div class="hero common-hero">');
    }

    if(isset($_POST['categorie'])){
        $result = $mysqli->query("(SELECT distinct a.id as idCercato, a.titolo as nomeEntita, a.votazione as votazione, a.categoria as categoria , a.data_uscita as data_nascita
                                    FROM articolo a join articolo_parola_chiave apk on apk.articolo_id = a.id
                                    join parola_chiave k on k.id = apk.parola_chiave_id
                                    where a.titolo like '$ricerca2' and a.categoria like \"{$_POST['categorie']}\"
                                    and year(a.data_uscita) >= {$_POST['da']} and year(a.data_uscita) <= {$_POST['a']} 
                                    ORDER BY votazione desc, data_uscita desc)");
    } else
    if(isset($_POST['categoriaCelebrità'])){
        $result = $mysqli->query("(SELECT distinct p.id as idCercato, p.nome as nomeEntita,p.nome as categoria, p.data_nascita
                                    from personaggio p join parola_chiave_personaggio pkp on pkp.personaggio_id = p.id
                                    join parola_chiave k on k.id=pkp.parola_chiave_id
                                    where p.nome like '$ricerca2' and substr(p.nome,1,1) like \"{$_POST['lettera']}\" and k.testo like \"{$_POST['categoriaCelebrità']}\"
                                    and year(p.data_nascita)>= {$_POST['da']} and year(p.data_nascita) <= {$_POST['a']}) union
                                    (SELECT distinct r.id as idCercato, concat(r.nome,' ',r.cognome)  as nomeEntita, k.testo as categoria, r.anno_nascita
                                    from regia r join parola_chiave_regia pkp on pkp.regia_id = r.id
                                    join parola_chiave k on k.id=pkp.parola_chiave_id
                                    where (concat(r.nome,' ',r.cognome) like '$ricerca2' and (substr(r.nome,1,1) like \"{$_POST['lettera']}\"
                                    or substr(r.cognome,1,1) like \"{$_POST['lettera']}\") and k.testo like \"{$_POST['categoriaCelebrità']}\"
                                    and year(r.anno_nascita) >= {$_POST['da']} and year(r.anno_nascita) <= {$_POST['a']}))");

    }
    else {
        $result = $mysqli->query("(select distinct a.id as idCercato, a.titolo as nomeEntita, a.votazione as votazione, a.categoria as categoria , a.data_uscita as data_nascita
                                    FROM articolo a where (a.titolo like '$ricerca' or a.categoria like '$ricerca') union 
                                    (SELECT distinct a.id as idCercato, a.titolo as nomeEntita, a.votazione as votazione, a.categoria as categoria , a.data_uscita as data_nascita
                                    FROM articolo a join personaggio_articolo pa on pa.articolo_id = a.id 
                                    join personaggio p on p.id = pa.personaggio_id
									left join backstage_articolo ba on ba.articolo_id = a.id
									left join regia r on r.id = ba.regia_id
                                    join articolo_parola_chiave apk on apk.articolo_id = a.id
                                    join parola_chiave k on k.id = apk.parola_chiave_id
                                    where (a.titolo like '$ricerca' or k.testo like '$ricerca' 
                                    or a.categoria like '$ricerca' or p.nome like '$ricerca') 
                                    ORDER BY votazione desc, data_uscita desc) union
                                    (select distinct p.id as idCercato, p.nome as nome, p.nome as votazione, p.nome as categoria, p.data_nascita
									from personaggio p join personaggio_articolo pa on pa.personaggio_id = p.id
                                    join articolo a on a.id = pa.articolo_id
                                    join parola_chiave_personaggio pkp on pkp.personaggio_id = p.id
                                    join parola_chiave k on k.id=pkp.parola_chiave_id
                                    where (p.nome like '$ricerca' or k.testo like '$ricerca' or a.titolo like '$ricerca' or p.data_nascita like '$ricerca')) union 
                                    (select distinct r.id as idCercato, concat (r.nome,' ',r.cognome) as nomeEntita, r.anno_nascita as data_nascita, k.testo as categoria, r.nome as votazione
									from regia r join backstage_articolo ba on ba.regia_id= r.id
                                    join articolo a on a.id = ba.articolo_id
                                    join parola_chiave_regia pkr on pkr.regia_id = r.id
                                    join parola_chiave k on k.id=pkr.parola_chiave_id
                                    where (concat(r.nome,' ',r.cognome) like '$ricerca' or r.nome like '$ricerca' or r.cognome like '$ricerca' or k.testo like 
                                    '$ricerca' or a.titolo like '$ricerca' or r.anno_nascita like '$ricerca') and k.testo='attore' or 'regia'))");
    }

    $number_of_results = mysqli_num_rows($result);
    $body -> setContent("number_of_films", $number_of_results);

    while ($data = $result->fetch_assoc()) {
        if ($data['categoria'] == "Film Disney"){
            $body->setContent("pagina_articolo_categoria", 'moviesingle.php?id='.$data['idCercato']);
            $body->setContent("idCercato", $data['idCercato']); //moviesingle.php?id=<[idImgProd]>
            $body->setContent("titolo", $data['nomeEntita']);
            $body->setContent("votazione", "<i class=\"ion-android-star\"></i>".$data['votazione']." /10");
            $body->setContent("categoria", $data['categoria']);
            $body->setContent("immagineCercata", 'img.php?id='.$data['idCercato']);
        }
        else if ($data['categoria'] == "Cartone Pixar" or $data['categoria'] == "Cartone Disney" or $data['categoria'] == "Cortometraggi Pixar"){
            $body->setContent("pagina_articolo_categoria", 'moviesingle2.php?id='.$data['idCercato']);
            $body->setContent("idCercato", $data['idCercato']); //moviesingle.php?id=<[idImgProd]>
            $body->setContent("titolo", $data['nomeEntita']);
            $body->setContent("votazione", "<i class=\"ion-android-star\"></i>".$data['votazione']." /10");
            $body->setContent("categoria", $data['categoria']);
            $body->setContent("immagineCercata", 'img.php?id='.$data['idCercato']);}

        else if ($data['categoria'] == "attore" or $data['categoria'] == "regia"){
            $body->setContent("pagina_articolo_categoria", 'celebritysingle.php?id='.$data['idCercato']);
            $body->setContent("idCercato", $data['idCercato']); //moviesingle.php?id=<[idImgProd]>
            $body->setContent("titolo", $data['nomeEntita']);
            $body->setContent("votazione", $data['data_nascita']);
            $body->setContent("categoria", $data['categoria']);
            $body->setContent("immagineCercata", 'imgActor.php?id='.$data['idCercato']);}
        else {
            $body->setContent("pagina_articolo_categoria", 'celebritysingle2.php?id='.$data['idCercato']);
            $body->setContent("idCercato", $data['idCercato']);
            $body->setContent("titolo", $data['nomeEntita']);
            $body->setContent("votazione", $data['data_nascita']);
            $body->setContent("categoria", "Personaggio");
            $body->setContent("immagineCercata", 'imgPersonaggio.php?id='.$data['idCercato']);
        }
    }
}
$main->setContent("body", $body->get());
$main->close();
