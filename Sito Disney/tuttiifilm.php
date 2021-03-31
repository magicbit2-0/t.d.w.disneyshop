<?php
    
    $connessione = mysqli_connect("127.0.0.1","root","","disneydb");
    $query = "select titolo,votazione from disneydb.articolo;";
    $result = mysqli_query($connessione,$query);

    while ($var = mysqli_fetch_assoc($result)){
        echo $var['titolo'];
    }
?>


