<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "bottonChange.php";

$body=new Template("dtml/shop_page.html");

if (isset($mysqli)) {
        $totaleParziale = 0;
        $speseSpedizione = 3;
        $items_in_cart = is_array($_SESSION['articoli']) ? count($_SESSION['articoli']) : 0;
        if ($items_in_cart > 0) {
            for ($i = 0; $i < count($_SESSION['articoli']); $i++) {
                $result = $mysqli->query("select id, titolo, year(data_uscita) as data_uscita, durata, prezzo from articolo where id = {$_SESSION['articoli'][$i]};");

                while ($data = $result->fetch_assoc()) {
                    $body->setContent("articoli_carrello", '<div class="movie-item-style-2">
                                                            <img src="img.php?id=' . $data['id'] . '" alt="">
                                                            <div class="mv-item-infor">
                                                                <h6><a>' . $data['titolo'] . '  <span>(' . $data['data_uscita'] . ')</span></a></h6>
                                                                <p class="describe2">€ ' . $data['prezzo'] . '</p>
                                                                <p class="run-time" style="margin-bottom: 50px;"> Durata: ' . $data['durata'] . '       <span>Data Rilascio: ' . $data['data_uscita'] . '</span></p>
                                                                <a class="removecart" href="removeFromCart.php?index=' . $i . '">rimuovi dal carrello</a>
                                                            </div>
                                                        </div>');
                    $totaleParziale = $totaleParziale + $data['prezzo'];
                }
            }
        } else {
            $body->setContent("articoli_carrello", "<h1 style=\"color:aliceblue;\">Non hai nessun articolo nel tuo carrello!</h1>");
            $speseSpedizione = 0;
        }

    $body->setContent("totale_parziale",$totaleParziale);
    $body->setContent("spese_spedizione",$speseSpedizione);
    $body->setContent("totale",$totaleParziale + $speseSpedizione);

}

$main->setContent("body", $body->get());
$main->close();
?>