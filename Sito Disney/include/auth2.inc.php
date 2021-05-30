<?php

class Auth{

    function doLogin(){
        global $mysqli;

        if(isset($_POST['username']) and isset($_POST['password'])) {
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
                                                    WHERE username = '{$_POST['username']}'
                                                    and password = MD5('{$_POST['password']}');");

            if (!$result) {
                echo "Error!";
                exit;
            }

            if ($result->num_rows == 0) {
                Header("Location: login.php?error");
                exit;
            }

            $nome=array();
            while($data = $result->fetch_assoc()){
                $nome[$data['nome']]=true;
            }

            $_SESSION['auth']=$nome;

        } else{
            if(!isset($_SESSION['auth'])){
                Header("Location: login.php?error");
                exit;
            }
        }

        $nome = basename($_SERVER['SCRIPT_FILENAME']);

        if(!isset($_SESSION['auth'][$nome])){
            Header("Location: login.php?error&non_autorizzato");
            exit;
        }


    }
}

Auth::doLogin();
?>
