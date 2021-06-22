<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/movie_single2.html");

if (isset($mysqli)) {
    if(!empty($_GET['id'])){
        $result = $mysqli->query("select a.id as idImg, titolo, data_uscita, durata, trama, votazione, prezzo, c.categoria_articolo as categoria,b.nome as brand from articolo a join categoria c on c.id=a.categoria 
                                        join brand b on b.id=a.id_brand where a.id = {$_GET['id']}");
        $data = $result->fetch_assoc();
        $titolo = $data['titolo'];
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
        //REGISTA PER FILM
        $result = $mysqli->query("select r.id as idRegista, concat(r.nome,' ', r.cognome) as nome_regista from backstage_articolo b join articolo a on b.articolo_id = a.id join regia r on b.regia_id = r.id
                                        join parola_chiave_regia p on p.regia_id = r.id join parola_chiave k on k.id=p.parola_chiave_id where k.testo = 'regia' and a.id = {$_GET['id']}");
        $n_regia = mysqli_num_rows($result);
        if(mysqli_num_rows($result) > 0) {
            $body->setContent('tipoMenu','Cast');
            $bufferCartone = '<h3>Cast di</h3>
                                        <h2>'.$titolo.'</h2>
                                        <div class="title-hd-sm">
                                            <h4>Regista</h4>
                                        </div>';
            $bufferx = '<div class="title-hd-sm"><h4>Cast</h4></div><!-- movie cast -->
                                            <div class="mvcast-item">';
            /*$data = $result->fetch_assoc();
            foreach ($data as $key => $value) {
                $body->setContent($key, $value);}*/
            while ($data = $result->fetch_assoc()){
                $bufferCartone .= '<div class="mvcast-item">
                                         <div class="cast-it">
                                            <div class="cast-left">
                                                    <img src="imgActor.php?id='.$data['idRegista'].'" style="width:100px" alt="">
                                                    <a href="celebritysingle.php?id='.$data['idRegista'].'">Clicca qui per saperne di più</a>
                                            </div>
                                                <p>'.$data['nome_regista'].'</p>
                                         </div>
                                    </div> <hr style="background-color: #232a50;">';
               $bufferx .= '<div class="cast-it">
                            <div class="cast-left">
                                <img src=\'imgActor.php?id='.$data['idRegista'].'\' style="width:80px" alt="">
                                <a href="celebritysingle.php?id='.$data['idRegista'].'">'.$data['nome_regista'].'</a>
                            </div>
                           </div>';
               $buffer2 = '<div class="sb-it">
                                                <h6>Regista: </h6>
                                                <p><a href="celebritysingle.php?id='.$data['idRegista'].'">'.$data['nome_regista'].'</a></p>
                                            </div>';

                //$body->setContent("id_regista1", $data['idRegista']);
                //$body->setContent("nome_regista1", $data['nome_regista']);
            }
            $body->setContent('registiTrue',$buffer2);
        }

        // ATTORI PER FILM
        $result1 = $mysqli->query("select r.id as id_attore, concat(r.nome,' ', r.cognome) as nome_attore from backstage_articolo b join articolo a on b.articolo_id = a.id join regia r on b.regia_id = r.id 
                                        join parola_chiave_regia p on p.regia_id = r.id join parola_chiave k on k.id=p.parola_chiave_id where k.testo = 'attore' and a.id = {$_GET['id']}");
        if(mysqli_num_rows($result1) > 0) {
            $body->setContent('tipoMenu','Cast');
            if ($bufferx == null) $bufferx = '<div class="title-hd-sm"><h4>Cast</h4></div><!-- movie cast --><div class="mvcast-item">';
            $buffer2 = '<div class="sb-it"><h6>Attori: </h6>';
            $bufferCartone .= '<div class="title-hd-sm">
                                            <h4>Attori</h4>
                                        </div>
                                        <div class="mvcast-item">';
            while ($data1 = $result1->fetch_assoc()) {
                $bufferCartone .= '<div class="cast-it">
                                    <div class="cast-left">
                                        <img src=\'imgActor.php?id='.$data1['id_attore'].'\' style="width:100px" alt="">
                                        <a href="celebritysingle.php?id='.$data1['id_attore'].'">'.$data1['nome_attore'].'</a>
                                    </div>
                                   </div>';
                $bufferx .= '<div class="cast-it">
                                <div class="cast-left">
                                     <img src=\'imgActor.php?id='.$data1['id_attore'].'\' style="width:80px" alt="">
                                     <a href="celebritysingle.php?id='.$data1['id_attore'].'">'.$data1['nome_attore'].'</a>
                                </div>
                            </div>';
                $buffer2 = '<p><a href="celebritysingle.php?id='.$data1['id_attore'].'">'.$data1['nome_attore'].'</a></p>';
                $body->setContent("id_attore", $data1['id_attore']);
                $body->setContent("nome_attore", $data1['nome_attore']);
                /*$body->setContent("id_attore1", $data1['id_attore']);//
                $body->setContent("id_attore2", $data1['id_attore']);//
                $body->setContent("nome_attore1", $data1['nome_attore']);//
                $body->setContent("nome_attore2", $data1['nome_attore']);//*/
            }
            $body -> setContent('attoriTrue',$buffer2.'</div>');
            $bufferCartone .= '</div>';
        } else {
            $bufferCartone .= "<div><h2 style='color:#d36b6b;text-align-last: center;'> Non ci sono attori correlati a questo articolo </h2></div>";
        }
        if(!empty($bufferx))
        $body->setContent('CastTrue',$bufferx.'</div>');

        //PERSONAGGI
        $result1 = $mysqli->query("(SELECT p.id as p_id, p.nome as p_nome FROM personaggio_articolo pa 
                                        join personaggio p on p.id = pa.personaggio_id 
                                        join articolo a on a.id = pa.articolo_id where a.id = {$_GET['id']})");

            $body->setContent('tipoMenu','Personaggi');
        $bufferPersonaggi = '<h3>Scopri i personaggi di</h3>
                                        <h2>'.$titolo.'</h2>
                                        <div class="title-hd-sm">
                                            <h4>Protagonisti</h4>
                                        </div>
                                        <div class="mvsingle-item ov-item celebrity-items" style="align-items: flex-end;">';
        while ($data1 = $result1->fetch_assoc()) {
            $bufferPersonaggi .= ' <div class="ceb-item">
                                                <img src=\'imgPersonaggio.php?id='.$data1['p_id'].'\' alt="">
                                                <p><a class="img-lightbox"  data-fancybox-group="gallery" href="celebritysingle2.php?id='.$data1['p_id'].'">'.$data1['p_nome'].' </a></p>
                                            </div>';
            $body->setContent("id_personaggio", $data1['p_id']);
            $body->setContent("id_personaggio1", $data1['p_id']);
            $body->setContent("idProtagonista", $data1['p_id']);
            $body->setContent("nome_personaggio1", $data1['p_nome']);
            $body->setContent("nome_personaggio", $data1['p_nome']);
            //$body->setContent("nome_protagonista1", $data1['p_nome']);
            $body->setContent("nome_protagonista", $data1['p_nome']);
        }
        if(!empty($bufferCartone)){
            if ($n_regia < 1) {
                $bufferCartone = '';
                $body->setContent('CasoCartone',$bufferCartone); }
            else $body->setContent('CasoCartone',$bufferCartone);}
        $body->setContent('CasoCartone',$bufferPersonaggi.'</div>');

        //PAROLE CHIAVE PER ATTORI E PERSONAGGI
        $result1 = $mysqli->query("select p.nome as p_nome, r.nome as r_nome, r.cognome as r_cog from personaggio p 
                                        join personaggio_articolo pa on pa.personaggio_id = p.id 
                                        join articolo a on a.id = pa.articolo_id 
                                        join backstage_articolo ba on ba.articolo_id = a.id
                                        join regia r on r.id = ba.regia_id where a.id = {$_GET['id']}");
        if(mysqli_num_rows($result1) > 0){
            while ($data1 = $result1->fetch_assoc()){
                $body->setContent("regia1",'<span class="time"><a href="celebritygrid01.php">'.$data1['r_nome'].'</a></span>');
                $body->setContent("regia1",'<span class="time"><a href="celebritygrid01.php">'.$data1['r_cog'].'</a></span>');
            }
        }
        $result1 = $mysqli->query("select p.nome as p_nome from personaggio p 
                                        join personaggio_articolo pa on pa.personaggio_id = p.id 
                                        join articolo a on a.id = pa.articolo_id where a.id = {$_GET['id']}");
        if(mysqli_num_rows($result1)) {
            while ($data1 = $result1->fetch_assoc()) {
                $body->setContent("nome_protagonista1", $data1['p_nome']);
            }
        }

        $result = $mysqli->query("(select a1.id , a2.id as id_correlato, a2.titolo as titolo_correlato, c2.categoria_articolo as categoria_correlato, a2.votazione as votazione_correlato, b2.nome as brand, 
                                        a2.durata as durata_correlato, a2.trama as trama_correlato, a2.data_uscita as data_uscita_correlato 
                                        from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_id join articolo a2 on a2.id = tab.articolo_correlato_id join categoria c2 on c2.id=a2.categoria join brand b2 on b2.id=a2.id_brand
                                        where a1.id = {$_GET['id']}) union
                                        (select a1.id , a2.id as id_correlato, a2.titolo as titolo_correlato, c2.categoria_articolo as categoria_correlato, a2.votazione as votazione_correlato, b2.nome as brand,
                                        a2.durata as durata_correlato, a2.trama as trama_correlato, a2.data_uscita as data_uscita_correlato 
                                        from articolo_correlato tab join articolo a1 on a1.id = tab.articolo_correlato_id join articolo a2 on a2.id = tab.articolo_id join categoria c2 on c2.id=a2.categoria join brand b2 on b2.id=a2.id_brand
                                        where a1.id = {$_GET['id']})");
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
                                                    <p>Brand:'.$data['brand'].'</p>
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
                                                            ' . $data1['data_recensione'] . " ". $data1['nome_utente'] . '
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
            $data = $result->fetch_assoc();
            $body->setContent("bottoneTrailer",'<div><a href=\'#\' class=\'item item-1 redbtn\'> <i class=\'ion-play\'></i>Guarda trailer</a></div>
                                                <div><a href=\'https://www.youtube.com/embed'.$data['trailer'] .'\' class=\'item item-2 redbtn fancybox-media hvr-grow\'><i class=\'ion-play\'></i></a></div>');
        } //sfondo.php?id={$_GET['id']}  RYAp1GuzTrE

        $result = $mysqli->query("select votazione from articolo where id = {$_GET['id']}");
        $data = $result->fetch_assoc();
        $star = floor($data['votazione']);
        $str = "";
        for($i=0; $i<=$star-1; $i++){
            $str = $str . '<i class="ion-ios-star"> </i>';
        }
        $str2 = "";
        for($i=0; $i<=10-$star-1;$i++){
            $str2 = $str2 . '<i class="ion-ios-star-outline"></i>';
        }
        $body->setContent("stellina_gialla", $str);
        $body->setContent("stellina_nera", $str2);

        if(isset($_SESSION['idUtente'])){
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

            $body->setContent("aggiungiRecensione",'<div class="comment-form" style="margin-top: 50px;">
                                                    <form method="POST" action="addReview.php">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="voto" style="color: white;">Voto:</label>
                                                                <input type="number" step="0.1" min="0" max="10.0" value="0" id="voto" name="voto" class="form-control" required style="font-family: Nunito, sans-serif; font-size: 14px; color: #abb7c4; font-weight: 300; text-transform: none; border: 1px solid #405266; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; height: 42px; background-color: rgb(28, 28, 44); margin-bottom: 10px;">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="titolo" style="color: white;">Titolo Recensione:</label>
                                                                <input type="text" id="titolo" name="titolo" class="form-control" required style="font-family: Nunito, sans-serif; font-size: 14px; color: #abb7c4; font-weight: 300; text-transform: none; border: 1px solid #405266; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; height: 42px; background-color: rgb(28, 28, 44); margin-bottom: 10px;">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12" style="width: 750px;">
                                                                <label for="testo" style="color: white;">Scrivi qui la tua recensione:</label>
                                                                <textarea type="text" id="testo" name="testo" class="form-control" required style="font-family: Nunito, sans-serif; font-size: 14px; background-color: rgb(28, 28, 44); color: rgb(171, 183, 196); font-weight: 300; text-transform: none; border: 1px solid rgb(64, 82, 102); border-radius: 3px; height: 94px; margin: 0px 240px 10px 0px; width: 480px;"></textarea>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="articolo_id" value='.$_GET['id'].'>
                                                        <input type="submit" name="aggiungiRecensione" value="Aggiungi Recensione" class="redbtn recensioneBtn" style="border-radius: 30px;" >
                                                    </form>
                                                </div>');
        }
    } else {
        header("Location: http://localhost/t.d.w.disneyshop/Sito%20Disney/index.php");
    }    
}

$main->setContent("body", $body->get());
$main->close();
?>