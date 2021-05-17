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
            $data = $result->fetch_assoc();
            $_SESSION['idUtente']=$data['id'];
            $result0 = $mysqli->query("select u.id as id, s.nome as script from servizi s join servizi_gruppo sg on sg.id_servizi = s.id
                                            join gruppo g on g.id = sg.id_gruppo
                                            join gruppo_utente gu on gu.gruppo_id=g.id
                                            join utente u on u.id = gu.utente_id 
                                            where u.username = '{$_POST['username']}'
                                            and password = md5('{$_POST['password']}')");
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
            
            Header("location: ./index.php");
            
           

            /*$main = new Template("dtml/index2.html"); //esci
              $body = new Template("dtml/homepage.html");*/


            $script=array();

            while($data = $result0 -> fetch_assoc()){
                $script[$data['script']]=true;
            }

            $_SESSION['auth']=$script;
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

        /*$script = basename($_SERVER['SCRIPT_NAME']);

        if (!isset($_SESSION['auth'][$script])){
            Header("location: ./index.php?accesso=LoginError");
            exit;
        }*/
    }

}

Auth::doLogin();


?>