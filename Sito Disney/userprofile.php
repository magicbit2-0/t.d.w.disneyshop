<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/auth.inc.php";
require "bottonChange.php";


$body=new Template("dtml/user_profile.html");
if (isset($mysqli)){

    $result = $mysqli->query("select * from utente  
                                     where id = {$_SESSION['idUtente']}");
    $data = $result->fetch_assoc();
    switch($data['avatar_id']){
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

    foreach ($data as $key => $value){
        $body->setContent($key,$value);
        $body->setContent("foto_avatar",'<a href="#"><img src="imgAvatar.php?id='.$data['avatar_id'] .'" alt="" style="background-color:'.$backgroundcolor.';border-radius: 50%;width: 120px;height: 120px;"><br></a>');
    }
    /*
    while ($data = $result->fetch_assoc()) {
        $body->setContent("nome_attore", $data['nomeT']);
        $body->setContent("idImgAttore", $data['id']);
    }*/

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

        $result = $mysqli->query("select g.`tipologia utente` as tipo_utente from utente u 
        join gruppo_utente gu on(u.id = gu.utente_id) join gruppo g on(gu.gruppo_id = g.id) where u.id = {$_SESSION['idUtente']};");
        while($data = $result->fetch_assoc()){
            if($data['tipo_utente'] == "cliente"){
                $body->setContent("serviziUtente","<li><a href='userfavoritegrid.php'>Film Preferiti</a></li>
                                                    <li><a href='userrate.php'>Votazioni Film</a></li>'");
            }
        }

    }
    
}

$main->setContent("body", $body->get());
$main->close();
?>