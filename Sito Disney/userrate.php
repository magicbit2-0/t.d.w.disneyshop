<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/user_rate.html");

if (isset($mysqli)) {
    $result = $mysqli->query("(select * from utente  
                                     where id = {$_SESSION['idUtente']})");
    $data = $result->fetch_assoc();
    switch ($data['avatar_id']) {
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

    foreach ($data as $key => $value) {
        $body->setContent($key, $value);
        $body->setContent("foto_avatar", '<a href="#"><img src="imgAvatar.php?id=' . $data['avatar_id'] . '" alt="" style="background-color:' . $backgroundcolor . ';border-radius: 50%;width: 120px;height: 120px;"><br></a>'
        );
    }

    $result = $mysqli->query("(select r.articolo_id as idArticolo, r.data as data_recensione, r.testo as testo,
	                                r.titolo as titolo_recensione, r.voto as votazione, a.titolo as titolo, YEAR(a.data_uscita) as data_uscita
                                    from utente u join recensione r on r.utente_id = u.id
                                    join articolo a on a.id = r. articolo_id
                                    where u.id = {$_SESSION['idUtente']})");

    $number_of_results = mysqli_num_rows($result);
    if ($number_of_results > 0) {
        while ($data = $result->fetch_assoc()) {
            $body->setContent("number_of_results","<p> Trovati <span>  $number_of_results  film </span> in totale </p>");
            if ($data['categoria'] <> 'Film Disney') {
                $categoria_film = 'moviesingle2.php?id=' . $data['idArticolo'];
            } else {
                $categoria_film = 'moviesingle.php?id=' . $data['idArticolo'];
            }
            $body->setContent("recensione", '
            <div class="movie-item-style-2 userrate">
               <img src="img.php?id='.$data['idArticolo'].'" alt="">
               <div class="mv-item-infor">
                   <h6><a href="'.$categoria_film.'">'.$data['titolo'].' <span>('.$data['data_uscita'].')</span></a></h6>
                   <div style="display: inline-flex;align-items: flex-end;">
                     <p class="time sm-text" style="width: fit-content; margin-right: 10px;">La tua votazione:</p>
                     <p class="rate" ><i class="ion-android-star"></i><span>'.$data['votazione'].'</span> /10</p>                        
               </div>
               <br>
               <div style="display: inline-flex;align-items: baseline;">
                        <p class="time sm-text" style="width: fit-content; margin-right: 10px;">La tua recensione:</p>
                        <h6>'.$data['titolo_recensione'].'</h6>
                        </div>
                        <p class="time sm">'.$data['data_recensione'].'</p>
                        <p>'.$data['testo'].'</p>
               </div>
            </div>');
        }
    } else {
        $body->setContent("recensione", "<div><h2 style='color:#d36b6b'> Non hai ancora recensito un film</h2></div>");
        $body->setContent("number_of_results", "Nessuna recensione trovata");
    }


    $result = $mysqli->query("select id from avatar where id not in (select avatar_id from utente where id = {$_SESSION['idUtente']});");
    while ($data = $result->fetch_assoc()) {
        switch($data['id']){
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
        $body->setContent("avatar_disponibili",'<a><img src="imgAvatar.php?id='.$data['id'] .'" alt="" style="background-color:'.$backgroundcolor.';
                                                border-radius: 50%;width: 120px;height: 120px; margin-bottom: 10px;"><br>
                                                <input type="radio" name="radioAvatar" value="'.$data['id'].'"> Scegli Questo Avatar</a>');
        $body->setContent("idAvatar",$data['id']);

    }

    print_r($_SERVER['HTTP_REFERER']);
}

$main->setContent("body", $body->get());
$main->close();
?>