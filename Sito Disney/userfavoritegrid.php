<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/user_favoritegrid.html");

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

    $result = $mysqli->query("(select a.id as idArticolo,a.titolo,a.votazione, a.categoria as categoriaArticolo
                                    from utente u 
                                    join articolo_preferito ap on ap.utente_id=u.id
                                    join articolo a on a.id=ap.articolo_id  
                                    where u.id = {$_SESSION['idUtente']})");

    $number_of_results = mysqli_num_rows($result);
    if ($number_of_results > 0) {
        while ($data = $result->fetch_assoc()) {
            $body->setContent("number_of_results", "<p style=\"padding-right: 0px\"> Trovati <span> $number_of_results film </span> in totale </p>");
            if ($data['categoriaArticolo'] == "Film Disney") {
                $categoria_film = 'moviesingle.php?id=' . $data['idArticolo'];
            } else {
                $categoria_film = 'moviesingle2.php?id=' . $data['idArticolo'];
            }
            $body->setContent("no_preferiti", '<div class="movie-item-style-2 movie-item-style-1 style-3">
                        <img src="img.php?id=' . $data['idArticolo'] . '" alt="">
                        <div class="hvr-inner" style="padding: 10px;margin-left: 25px;margin-right: 5px;">
                            <a href="' . $categoria_film . '">Leggi di più <i class="ion-android-arrow-dropright"></i> </a>
                        </div>
                        <div class="mv-item-infor">
                            <h6><a href="'.$categoria_film.'">' . $data['titolo'] . '</a></h6>
                            <p class="rate"><i class="ion-android-star"></i><span>' . $data['votazione'] . '</span> /10</p>
                        </div>
                        </div>');
        }
    } else {
        $body->setContent("no_preferiti", "<div><h2 style='color:#d36b6b'> Non ci sono articoli preferiti </h2></div>");
        $body->setContent("number_of_results", "Nessun articolo trovato");
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

}
$main->setContent("body", $body->get());
$main->close();
?>