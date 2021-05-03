<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/index.html");
    $body = new Template("dtml/signup.html");


    if(isset($_POST['submit'])){
        $good = 1;
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $birthdate = $_POST['birthdate'];
        $email = $_POST['email'];
        $paese = $_POST['paese'];
        $regione = $_POST['regione'];
        $indirizzo = $_POST['indirizzo'];
        $username = $_POST['username2'];
        $pwd = $_POST['password2'];
        $pwdRe = $_POST['passwordRe'];

        $body->setContent("nome", $nome);
        $body->setContent("cognome", $cognome);
        $body->setContent("birthdate", $birthdate);
        $body->setContent("email", $email);
        $body->setContent("regione", $regione);
        $body->setContent("indirizzo", $indirizzo);

        require "include/functions.inc.php";

        if(invalidEmail($email) !== false){
            $body->setContent("message", "invalidEmail");
            $good = 0;
            //header("location: signup.php?error=invalidEmail");
            //exit;
        }
        if(pwdMatch($pwd,$pwdRe) !== false){
            //header("location: signup.php?error=pwdMatch");
            $body->setContent("message", "pwdMatch");
            $good = 0;
            //exit;
        }
        if(UsernameExists($mysqli,$username) !== false){
            // header("location: signup.php?error=usernameExists");
            $body->setContent("message", "usernameExists");
            $good = 0;
            //exit;
        }
        if($good == 1){
            $body -> setContent("allerta","<body onunload=\"window.alert('Registrazione effettuata!')\"");
            createUser($mysqli,$nome,$cognome,$birthdate,$email,$paese,$regione,$indirizzo,$username,$pwd);
        }

    }
    /*else {
        header("location: signup.php");
    }*/

    $main->setContent("body", $body->get());
    $main->close();
?>