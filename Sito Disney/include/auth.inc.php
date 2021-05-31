<?php
error_reporting(E_ALL & ~E_NOTICE);

Class Auth {

    function doLogin()
    {
        global $mysqli;
        if(isset($_POST['username']) and isset($_POST['password'])){
            $result = $mysqli->query("(SELECT * FROM utente
                                        WHERE username = '{$_POST['username']}'
                                        and password = md5('{$_POST['password']}'))");
            if(mysqli_num_rows($result) != 1){
                header("Location: ./index.php?accesso=LoginError");
                exit();
            }
            $data = $result->fetch_assoc();
            $_SESSION['idUtente']=$data['id'];
            header("Location: ./index.php");
            exit();
        }
        if (!isset($_SESSION['idUtente'])){
            header("Location: ./index.php?accesso=noLogin");
            exit();
        }
    }

}

(new Auth)->doLogin();

?>