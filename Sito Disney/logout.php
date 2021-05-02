<?php
        session_start();

        unset($_SESSION['auth']);
        unset($_SESSION['idUtente']);
        unset($_SESSION['articoli']);
        Header("location: index.php");
?>