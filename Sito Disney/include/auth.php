<?php

    class Auth{
        function doLogin(){
            
            global $mysqli;
            $result = $mysqli->query("select * from users where username = {$_POST['username']} and password = md5({$_POST['password']})");
            
            if(!$result){
                echo "Errore Autenticazione";
                exit;
            }

            if($result->num_rows == 1){
                Header("Location: login.php?error");
                exit;
               
            }
        }

    }
    Auth::doLogin();
?>