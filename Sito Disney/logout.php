<?php
        session_start();

        unset($_SESSION['auth']);
        unset($_SESSION['idUtente']);
        Header("location: index.php");
?>