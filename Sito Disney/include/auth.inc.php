<?php

Class Auth {

    function doLogin(){
        global $mysqli;

        /*if($_SESSION['idUtente'] == null){
            Header("location: ./index.php?accesso=noLogin");
            exit();
        } else {
            Header("location: ./index.php?accesso=LoginOk");

            $_SESSION['auth']=true;
            exit();
        }*/

        if($_SESSION['idUtente'] != null){
            //Header("location: ./index.php?accesso=LoginOk");
            //$_SESSION['auth']=true;
            //exit();
        }
        if(isset($_POST['username']) and isset($_POST['password'])) {
            $result = $mysqli->query("(SELECT * FROM utente
                                        WHERE username = '{$_POST['username']}'
                                        and password = md5('{$_POST['password']}')) ");
            $data = $result->fetch_assoc();
            $_SESSION['idUtente']=$data['id'];
            $result0 = $mysqli->query("SELECT servizi.nome 
                                                FROM utente 
                                                LEFT JOIN gruppo_utente ON gruppo_utente.utente_id = utente.id 
                                                LEFT JOIN servizi_gruppo ON servizi_gruppo.id_gruppo = gruppo_utente.gruppo_id 
                                                LEFT JOIN servizi ON servizi.id = servizi_gruppo.id_servizi 
                                                WHERE username = '{$_POST['username']}'
                                                and password = MD5('{$_POST['password']}');");
            if (!$result){
                echo "errore";
                exit();
            }

            if (mysqli_num_rows($result0) == 0) {
                Header("location: ./index.php?accesso=LoginError2");
                exit();
                /*$main = new Template("dtml/index.html"); //accedi
                $body2 = new Template("dtml/login.html");
                $body2->setContent("message", "errorLogin");
                $main->setContent("body2", $body2->get());*/
            }



            /*$main = new Template("dtml/index2.html"); //esci
              $body = new Template("dtml/homepage.html");*/

            $script=array();

            while($data = $result0 -> fetch_assoc()){
                $script[$data['nome']]=true;
            }
            $_SESSION['auth']=$script;
            Header("location: ./index.php");

        }else {
            if(!isset($_SESSION['auth'])) {
                /*$main = new Template("dtml/index.html");
                $body = new Template("dtml/homepage.html");*/
                Header("location: ./index.php");
                exit;
            }
        }

        $script = basename($_SERVER['SCRIPT_NAME']);

        if (!isset($_SESSION['auth'][$script])){
            Header("location: ./index.php?accesso=LoginError3");
            exit;
        }
    }

}

Auth::doLogin();

?>