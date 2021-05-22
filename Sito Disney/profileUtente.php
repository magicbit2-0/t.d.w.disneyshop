<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/profileUtente.html");
if (isset($mysqli)) {

    $result0 = $mysqli->query("select a.id from articolo_preferito a join utente u on a.utente_id=u.id where u.id={$_GET['id']}");
    $number_of_results = mysqli_num_rows($result0);
    $body -> setContent("n_preferiti", $number_of_results);

    $result1 = $mysqli->query("select o.id from ordine o 
                                     join utente u 
                                     on u.id = o.utente_id where u.id={$_GET['id']}
                                     group by o.id;");
    $number_of_results = mysqli_num_rows($result1);
    $body -> setContent("n_ordini", $number_of_results);

    $result2 = $mysqli->query("select r.id from recensione r join utente u on r.utente_id=u.id where u.id={$_GET['id']}");
    $number_of_results = mysqli_num_rows($result2);
    $body -> setContent("n_votazioni", $number_of_results);

    $result = $mysqli->query("select a.id as idAvatar, u.id as idUtente, concat(nome,' ',cognome) as nome, paese, regione, indirizzo, email 
                                    from utente u join avatar a on u.avatar_id=a.id where u.id= {$_GET['id']}");
    while ($data1 = $result->fetch_assoc()){
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
        $body->setContent("idAvatar", $data1['idAvatar']);
        $body->setContent("avatar", '<img class="profile-user-img img-fluid img-circle" src="imgAvatar.php?id='.$data1['idAvatar'].'" style="background-color: '.$backgroundcolor.'" alt="User profile picture">');
        $body->setContent("nome", $data1['nome']);
        $body->setContent("paese", $data1['paese']);
        $body->setContent("regione", $data1['regione']);
        $body->setContent("indirizzo", $data1['indirizzo']);
        $body->setContent("email", $data1['email']);
    }

    $result3 = $mysqli->query("select a.id as idArticolo, a.titolo, a.data_uscita, a.prezzo
                                    from articolo a 
                                    join articolo_ordinato ao on a.id=ao.articolo_id
                                    join ordine o on o.id=ao.ordine_id
                                    join utente u on u.id=o.utente_id where u.id= {$_GET['id']}");
    $number_of_results1 = mysqli_num_rows($result3);
    if($number_of_results1 > 0) {
        while ($data2 = $result3->fetch_assoc()) {
            $body->setContent("ordini",  '<div class="post">
                                                            <p>
                                                              <img class="img-circle img-fluid" style="border-radius: 15px;width: 75px;height: auto;" src="img.php?id=' . $data2['idArticolo'] . '" alt="">
                                                              <strong>
                                                                ' . $data2['titolo'] . '
                                                              </strong>
                                                            </p>
                                                            <p>
                                                                Data uscita: ' . $data2['data_uscita'] . '
                                                            </p>
                                                            <p>
                                                                Prezzo: ' . $data2['prezzo'] . '
                                                            </p>
                                                          </div>');
        }
    }
    else {
        $body->setContent("ordini", "<div><h2 style='color:#d36b6b'> Non sono stati trovati ordini! " . "</h2></div>");
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
