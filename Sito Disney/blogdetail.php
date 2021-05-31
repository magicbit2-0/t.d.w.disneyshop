<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";
    require "bottonChange.php";

    $body=new Template("dtml/blog_detail.html");

    if (isset($mysqli)) {

        $result = $mysqli->query("SELECT id, titolo, data_pubblicazione, descrizione, fonte FROM notizia WHERE id={$_GET['id']}");

        while ($data = $result->fetch_assoc()){
            $body->setContent("titolo_notizia", $data['titolo']);
            $body->setContent("data_notizia", $data['data_pubblicazione']);
            $body->setContent("descrizione_notizia", $data['descrizione']);
            $body->setContent("fonte_notizia", $data['fonte']);
            $body->setContent("idImgNotizia", $data['id']);
        }

        $result = $mysqli->query("select * from commento where notizia_id ={$_GET['id']}");
        $numberOfComments = mysqli_num_rows($result);
        if($numberOfComments > 0){
            while ($data1 = $result->fetch_assoc()) {
                $body->setContent("commenti", '<div class="cmt-item flex-it">
                                                <div class="author-infor">
                                                    <div class="flex-it2">
                                                        <h6 style="color: whitesmoke;">'.$data1['nome'].'</h6>
                                                        <span class="time">'.$data1['data'].'</span>
                                                    </div>
                                                    <p>'.$data1['testo'].'</p>
                                                </div>
                                            </div>');}
        } else {
            $body->setContent("commenti", "<div><h2 style='color:#d36b6b; margin-top: 10px;'>Non ci sono commenti per questa notizia</h2></div>");
        }

        $result = $mysqli->query("SELECT id as idNotizia1, titolo FROM notizia WHERE categoria='Cartone Disney' limit 1");
        while ($data2 = $result->fetch_assoc()) {
            $body->setContent("notizia1", $data2['titolo']);
            $body->setContent("pagina_notizia1", 'blogdetail.php?id='.$data2['idNotizia1']);
        }

        $result = $mysqli->query("SELECT id as idNotizia2, titolo FROM notizia WHERE categoria='Film Disney' limit 1");
        while ($data3 = $result->fetch_assoc()) {
            $body->setContent("notizia2", $data3['titolo']);
            $body->setContent("pagina_notizia2", 'blogdetail.php?id='.$data3['idNotizia2']);
        }

        $result = $mysqli->query("SELECT id as idNotizia3, titolo FROM notizia order by data_pubblicazione desc limit 1");
        while ($data4 = $result->fetch_assoc()) {
            $body->setContent("notizia3", $data4['titolo']);
            $body->setContent("pagina_notizia3", 'blogdetail.php?id='.$data4['idNotizia3']);
        }
    }

    if(isset($_SESSION['idUtente'])){
        $result=$mysqli->query("select concat(nome,' ',cognome) as nome, email from utente where id = {$_SESSION['idUtente']}");
        while ($data = $result->fetch_assoc()) {
            $body->setContent("inputNome", $data['nome']);
            $body->setContent("inputEmail", $data['email']);
        }
    }

    print_r($_SESSION);

    $main->setContent("body", $body->get());
    $main->close();
?>