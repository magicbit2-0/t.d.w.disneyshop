<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";

$main=new Template("dtml/index2.html");
$body=new Template("dtml/user_favoritegrid.html");

print_r($_SESSION);
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

    $result = $mysqli->query("(select a.id as idArticolo,a.titolo,a.votazione, a.categoria
                                    from utente u 
                                    join articolo_preferito ap on ap.utente_id=u.id
                                    join articolo a on a.id=ap.articolo_id  
                                    where u.id = {$_SESSION['idUtente']})");

    $number_of_results = mysqli_num_rows($result);
    if ($number_of_results > 0) {
        while ($data = $result->fetch_assoc()) {
            $body->setContent("number_of_results", $number_of_results);
            if ($data['categoria'] <> 'Film Disney') {
                $categoria_film = 'moviesingle2.php?id=' . $data['idArticolo'];
            } else {
                $categoria_film = 'moviesingle.php?id=' . $data['idArticolo'];
            }
            $body->setContent("no_preferiti", '<div class="movie-item-style-2 movie-item-style-1 style-3">
                        <img src="img.php?id=' . $data['idArticolo'] . '" alt="">
                        <div class="hvr-inner">
                            <a href="' . $categoria_film . '">Leggi di più <i class="ion-android-arrow-dropright"></i> </a>
                        </div>
                        <div class="mv-item-infor">
                            <h6><a href="moviesingle.php?id=' . $data['idArticolo'] . '">' . $data['titolo'] . '</a></h6>
                            <p class="rate"><i class="ion-android-star"></i><span>' . $data['votazione'] . '</span> /10</p>
                        </div>
                        </div>');
        }
    } else {
        $body->setContent("no_preferiti", "<div><h2 style='color:#d36b6b'> Non sono stati trovati film correlati a " . $data['titolo'] . "</h2></div>");
        $body->setContent("number_of_results", "Nessun film trovato");
    }
}
$main->setContent("body", $body->get());
$main->close();
?>