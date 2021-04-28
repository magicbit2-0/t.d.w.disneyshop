<?php
Class Auth {
    function doLogin()
    {
        global $mysqli;
        if($_SESSION['idUtente'] != null){
            Header("location: ./index.php?accesso=LoginOk");
            $_SESSION['auth']=true;
            exit;
        }
        if(isset($_POST['username']) and isset($_POST['password'])) {
            $result = $mysqli->query("(SELECT * FROM utente 
                                        WHERE username = '{$_POST['username']}'
                                        and password = md5('{$_POST['password']}')) 
                                        ");
            $data =$result->fetch_assoc();
            $_SESSION['idUtente']=$data['id'];
            if (!$result){
                echo "errore";
                exit;
            }
            if (mysqli_num_rows($result) != 1) {
                Header("location: ./index.php?accesso=LoginError");
                exit;
                /*$main = new Template("dtml/index.html"); //accedi
                $body2 = new Template("dtml/login.html");
                $body2->setContent("message", "errorLogin");
                $main->setContent("body2", $body2->get());*/
            }
            Header("location: ./index.php?accesso=LoginOk");
            /*$main = new Template("dtml/index2.html"); //esci
                $body = new Template("dtml/homepage.html");*/
            $_SESSION['auth']=true;
        }
        else
        {
            if(!isset($_SESSION['auth'])) {
                /*$main = new Template("dtml/index.html");
                $body = new Template("dtml/homepage.html");*/
                Header("location: ./index.php");
                exit;
            }
        }
    }

}

Auth::doLogin();


?>