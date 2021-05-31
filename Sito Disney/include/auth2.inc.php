<?php

class Auth{

    function doLogin(){
        global $mysqli;

        //if(isset($_POST['username']) and isset($_POST['password'])) {
        if(isset($_SESSION['idUtente'])) {
            echo 'sessione 1: ';
            print_r($_SESSION);
            /*SOLA AUTENTICAZIONE
            $result = $mysqli->query("SELECT *
                                FROM users
                                WHERE username = '{$_POST['username']}'
                                and password = MD5('{$_POST['password']}'); ");
            */

            $result = $mysqli->query("SELECT servizi.nome 
                                                    FROM utente 
                                                    LEFT JOIN gruppo_utente ON gruppo_utente.utente_id = utente.id 
                                                    LEFT JOIN servizi_gruppo ON servizi_gruppo.id_gruppo = gruppo_utente.gruppo_id 
                                                    LEFT JOIN servizi ON servizi.id = servizi_gruppo.id_servizi 
                                                    WHERE utente.id = {$_SESSION['idUtente']};");

            if (!$result) {
                echo "Error!";
                exit;
            }

            if ($result->num_rows == 0) {
                Header("Location: index.php?error1");
                exit;
            }

            $nome=array();
            while($data = $result->fetch_assoc()){
                $nome[$data['nome']]=true;
            }

            $_SESSION['auth']=$nome;

        } else {
            echo 'sessione2: ';
            print_r($_SESSION);
            if(!isset($_SESSION['auth'])){
                Header("Location: index.php?error2");
                exit;
            }
        }

        $nome = basename($_SERVER['SCRIPT_FILENAME']);

        if(!isset($_SESSION['auth'][$nome])){
            Header("Location: index.php?accesso=AccessDenied");
            exit;
        }
        echo 'sessione 3: ';
        print_r($_SESSION);

    }
}

Auth::doLogin();
?>
