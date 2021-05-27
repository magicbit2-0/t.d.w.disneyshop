<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/movie_single2.html");

if (isset($mysqli)) {
    $result = $mysqli->query("(select id as idImg, titolo, data_uscita, durata, trama, votazione, prezzo, categoria from articolo where id = {$_GET['id']})");
    $data = $result->fetch_assoc();

    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
        //se non sei loggato non puoi aggiungere articoli al carrello
        if(isset($_SESSION['idUtente'])){
            $body->setContent("bottoneCompra",'<div class="btn-transform transform-vertical">
                                                <div><a href="addtocart.php?id='.$data['idImg'].'" class="item item-1 yellowbtn" style="text-transform: none;"> <i class="ion-card"></i>Aggiungi al carrello '.$data['prezzo'].'€</a></div>
                                                <div><a href="addtocart.php?id='.$data['idImg'].'" class="item item-2 yellowbtn"><i class="ion-card"></i></a></div>
                                            </div>');
        }
    }

    $result1 = $mysqli->query("(select r.id as id_attore, concat(r.nome,' ', r.cognome) as nome_attore from backstage_articolo b join articolo a on b.articolo_id = a.id join regia r on b.regia_id = r.id 
                                    join parola_chiave_regia p on p.regia_id = r.id join parola_chiave k on k.id=p.parola_chiave_id where k.testo = 'attore' and a.id = {$_GET['id']})");

    while ($data1 = $result1->fetch_assoc()) {
        $body->setContent("id_attore", $data1['id_attore']);
        $body->setContent("nome_attore", $data1['nome_attore']);
        $body->setContent("id_attore1", $data1['id_attore']);
        $body->setContent("nome_attore1", $data1['nome_attore']);
        $body->setContent("nome_attore2", $data1['nome_attore']);
    }

    $result1 = $mysqli->query("(SELECT p.id as p_id, p.nome as p_nome FROM personaggio_articolo pa 
                                    join personaggio p on p.id = pa.personaggio_id 
                                    join articolo a on a.id = pa.articolo_id where a.id = {$_GET['id']})");

    while ($data1 = $result1->fetch_assoc()) {
        $body->setContent("id_personaggio", $data1['p_id']);
        $body->setContent("id_personaggio1", $data1['p_id']);
        $body->setContent("idProtagonista", $data1['p_id']);
        $body->setContent("nome_personaggio1", $data1['p_nome']);
        $body->setContent("nome_personaggio", $data1['p_nome']);
        $body->setContent("nome_protagonista1", $data1['p_nome']);
        $body->setContent("nome_protagonista", $data1['p_nome']);
    }

    /*$result1 = $mysqli->query("select p.nome as p_nome from personaggio p
                                    join personaggio_articolo pa on pa.personaggio_id = p.id 
                                    join articolo a on a.id = pa.articolo_id where a.id = {$_GET['id']}");

    while ($data1 = $result1->fetch_assoc()){
        $body->setContent("nome_protagonista1", $data1['p_nome']);
        $body->setContent("nome_protagonista", $data1['p_nome']);
    }*/

    $result = $mysqli->query("(select a1.id , a2.id as id_correlato, a2.titolo as titolo_correlato, a2.categoria as categoria_correlato, a2.votazione as votazione_correlato, 
                                    a2.durata as durata_correlato, a2.trama as trama_correlato, a2.data_uscita as data_uscita_correlato 
                                    from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_id join articolo a2 on a2.id = tab.articolo_correlato_id 
                                    where a1.id = {$_GET['id']} ) union
                                    (select a1.id , a2.id as id_correlato, a2.titolo as titolo_correlato, a2.categoria as categoria_correlato, a2.votazione as votazione_correlato, 
                                    a2.durata as durata_correlato, a2.trama as trama_correlato, a2.data_uscita as data_uscita_correlato 
                                    from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_correlato_id join articolo a2 on a2.id = tab.articolo_id 
                                    where a1.id = {$_GET['id']} )");

    $number_of_results = mysqli_num_rows($result);
    if ($number_of_results > 0) {
        $body->setContent("number_of_results", $number_of_results);
        while ($data = $result->fetch_assoc()) {
            if ($data['categoria_correlato'] <> 'Film Disney') {
                $categoria_film = 'moviesingle2.php?id=' . $data['id_correlato'];
            } else {
                $categoria_film = 'moviesingle.php?id=' . $data['id_correlato'];
            }
            $body->setContent("no_correlati", '
                                        <div class="movie-item-style-2">
                                            <img src="img.php?id=' . $data['id_correlato'] . '" alt="">
                                            <div class="mv-item-infor">
                                                <h6><a href="' . $categoria_film . ' ">' . $data['titolo_correlato'] . '</a></h6>
                                                <p class="rate"><i class="ion-android-star"></i><span>' . $data['votazione_correlato'] . '</span> /10</p>
                                                <p class="describe">' . substr($data['trama_correlato'], 0, 300) . " [...]" . '</p>
                                                <p class="run-time"> Durata: ' . $data['durata_correlato'] . '<span>Data Rilascio: ' . $data['data_uscita_correlato'] . '</span></p>
                                                <p>Categoria:' . $data['categoria_correlato'] . '</p>
                                            </div>
                                        </div>');
        }
    } else {
        $body->setContent("no_correlati", "<div><h2 style='color:#d36b6b'> Non sono stati trovati film correlati a " . $data['titolo'] . "</h2></div>");
        $body->setContent("number_of_results", "Nessun film trovato");
    }


    $result = $mysqli->query("(SELECT r.titolo as titolo_recensione, r.data as data_recensione, r.testo as testo_recensione,
                                     concat(u.nome,' ', u.cognome) as nome_utente, r.voto as votazione_recensione , u.avatar_id as idAvatar
                                     FROM disneydb.recensione r 
                                     join articolo a on r.articolo_id = a.id join utente u on r.utente_id = u.id 
                                     where a.id = {$_GET['id']})");

    $number_of_reviews = mysqli_num_rows($result);
    if ($number_of_reviews > 0) {
        $body->setContent("number_of_reviews", "<p>Trovate <span>$number_of_reviews</span> in totale </p>");
        $body->setContent("number_of_reviews2", "$number_of_reviews recensioni");
        while ($data1 = $result->fetch_assoc()) {
            switch($data1['idAvatar']){
                case '1':
                    $backgroundcolor = 'lightpink';
                    break;
                case '2':
                    $backgroundcolor = '#d3c24b';
                    break;
                case '3':
                    $backgroundcolor = '#d584cf';
                    break;
                case '4':
                    $backgroundcolor = 'cadetblue';
                    break;
                case '5':
                    $backgroundcolor = '#50b666';
                    break;
                case '6':
                    $backgroundcolor = '#6792c7';
                    break;
                case '7':
                    $backgroundcolor = '#e86c6c';
                    break;
                default:
                    $backgroundcolor = 'aliceblue';
                    break;
            }
            $body->setContent("no_reviews", '
                                        <div class="mv-user-review-item">
                                            <div class="user-infor">
                                                <img src="imgAvatar.php?id='.$data1['idAvatar'].'" alt="" style="background-color:'.$backgroundcolor.';border-radius: 50%;width: 70px;height: 70px;">
                                                <div>
                                                    <h3>' . $data1['titolo_recensione'] . '</h3>
                                                    <div class="rate">
                                                        <p><i class="ion-android-star"></i>
                                                        <span>' . $data1['votazione_recensione'] . '</span> /10<br>
                                                    </div>
                                                    <p class="time">
                                                        ' . $data1['data_recensione'] . '<a href="userprofile.html">' . $data1['nome_utente'] . '</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <p>' . $data1['testo_recensione'] . '</p>
                                        </div>');
        }
    } else {
        $body->setContent("no_reviews", "<div><h2 style='color:#d36b6b'> Non ci sono ancora recensioni per questo articolo</h2></div>");
        $body->setContent("number_of_reviews", "<p><span>Nessuna recensione trovata</span></p>");
        $body->setContent("number_of_reviews2", "Nessuna recensione");

    }

    $result = $mysqli->query("select trailer from articolo where id = {$_GET['id']}");
    $number_of_trailer = mysqli_num_rows($result);
    if($number_of_trailer > 0){
        $body->setContent("bottoneTrailer",'<div><a href=\'#\' class=\'item item-1 redbtn\'> <i class=\'ion-play\'></i>Guarda trailer</a></div>
                                            <div><a href=\'https://www.youtube.com/embed/'.$data['trailer'] .'\' class=\'item item-2 redbtn fancybox-media hvr-grow\'><i class=\'ion-play\'></i></a></div>');
    } //trailer.php?id={$_GET['id']}  RYAp1GuzTrE


    $result = $mysqli->query("select * from articolo_preferito where articolo_id={$_GET['id']} and utente_id={$_SESSION['idUtente']};");
    $is_favourite = mysqli_num_rows($result);
    if($is_favourite > 0){
        $body->setContent("aggiugiRimuoviPreferito", "<form action='removefromfavorites.php' method='POST'>
                                                        <i class='ion-heart' style='color: #dd003f; margin-right: 5px;'></i>
                                                        <input type='hidden' name='idFilm' value='{$_GET['id']}'>
                                                        <input type='submit' name='preferito' value='RIMUOVI DAI PREFERITI' style='font-family: Dosis, sans-serif; font-size: 14px; color: #dd003f; font-weight: bold; background: none;'>
                                                    </form>");
    } else {
        $body->setContent("aggiugiRimuoviPreferito", "<form action='addToFavorites.php' method='POST'>
                                                        <i class='ion-heart' style='color: #dd003f; margin-right: 5px;'></i>
                                                        <input type='hidden' name='idFilm' value='{$_GET['id']}'>
                                                        <input type='submit' name='preferito' value='AGGIUNGI AI PREFERITI' style='font-family: Dosis, sans-serif; font-size: 14px; color: #dd003f; font-weight: bold; background: none;'>
                                                    </form>");
    }
}

$main->setContent("body", $body->get());
$main->close();
?>