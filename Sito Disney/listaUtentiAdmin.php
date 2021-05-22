<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";

$body=new Template("dtml/ADMIN/pages/examples/contacts.html");
if (isset($mysqli)) {

    $results_per_page = 9;
    if (!isset($_GET['page'])) {
        $page = 1;
        $body -> setContent("actual_page", 1);
    } else {
        $page = $_GET['page'];
        $body -> setContent("actual_page", $_GET['page']);
    }
    $this_page_first_result = ($page - 1) * $results_per_page;

    $result0 = $mysqli->query("SELECT id FROM utente");
    $number_of_results = mysqli_num_rows($result0);
    $body -> setContent("numero_utenti", $number_of_results);
    $number_of_pages = ceil($number_of_results / $results_per_page);
    $body -> setContent("number_of_pages", $number_of_pages);
    for ($page = 1; $page <= $number_of_pages; $page++) {
        $body->setContent("tagpagina",'<a href="listaUtentiAdmin.php?page=' . $page . '">' . $page . '</a> ');
    }

    $result = $mysqli->query("select a.id as idAvatar, u.id as idUtente, concat(u.nome,' ', u.cognome) as nome, u.paese, u.regione, u.indirizzo, u.email 
                                    from utente u 
                                    join avatar a on u.avatar_id=a.id
                                    where u.id != {$_SESSION['idUtente']}");
    while ($data = $result->fetch_assoc()){
        switch($data['idAvatar']){
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
        $body->setContent("idAvatar", $data['idAvatar']);
        $body->setContent("nome", $data['nome']);
        $body->setContent("paese", $data['paese']);
        $body->setContent("regione", $data['regione']);
        $body->setContent("indirizzo", $data['indirizzo']);
        $body->setContent("email", $data['email']);
        $body->setContent("avatar", '<img src="imgAvatar.php?id='.$data['idAvatar'].'" style="background-color:'. $backgroundcolor .'" alt="user-avatar" class="img-circle img-fluid">');
        $body -> setContent("pagina_utente", "profileUtente.php?id=".$data['idUtente']);
        $body -> setContent("pagina_utente2", "aggiungiAdmin.php?id=".$data['idUtente']);
    }

}
$main->setContent("body_admin", $body->get());
$main->close();
?>
