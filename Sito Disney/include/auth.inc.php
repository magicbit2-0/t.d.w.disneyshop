<?php
Class Auth {

    function doLogin() {


        global $mysqli;

        if (isset($_POST['username']) and isset($_POST['password'])) {

            /* username and passowrd have been entered in login.php */

            /* AUTHENTICATION ONLY */
            $result = $mysqli->query("
                SELECT * 
                FROM utenti
                WHERE username = '{$_POST['username']}' AND password = MD5('{$_POST['password']}');
            ");



            /*$result = $mysqli->query("

                    SELECT service.script
                    from users
                    left join user_group
                    on user_group.username = users.username
                    left join group_service
                    ON group_service.id_group = user_group.id_groups
                    left JOIN service
                    ON service.id = group_service.id_servoce
                    where users.username = '{$_POST['username']}' AND users.password = MD5('{$_POST['password']}')

                ");*/
            if (!$result) {
                echo "Error!";
                exit();
            }

            if ($result->num_rows == 0) {
                Header("Location: index.php?error");
                exit();
            }
            /*$script = array();
            while ($data = $result->fetch_assoc()) {

                $script[$data['script']] = true;

            }
            $_SESSION['auth'] = $script;*/


        } else {

            /* una richiesta di autenticazione fuori da login.php */


           // if (!isset($_SESSION['auth'])) {

             //   Header("Location: index.php?error");
             //   exit;

            //}


        }

        /*$script = basename($_SERVER['SCRIPT_NAME']);

        if (!isset($_SESSION['auth'][$script])) {
            Header("Location: login.php?error&non_autorizzato");
            exit;
        }*/

    }

}

Auth::doLogin();


?>