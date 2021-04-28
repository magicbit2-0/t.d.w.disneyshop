<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require "include/dbms.inc.php";
    require "include/template2.inc.php";


    if(isset($mysqli)){
        $result = $mysqli->query("(SELECT * FROM utente 
                                        WHERE username = '{$_POST['username']}'
                                        and password = md5('{$_POST['password']}')) 
                                        ");
        if (mysqli_num_rows($result) == 1){
            $main = new Template("dtml/index2.html");
            $body = new Template("dtml/login.html");
        } else {
            $main = new Template("dtml/index.html");
            $body = new Template("dtml/homepage.html");
        }
    }
    $main->setContent("body", $body->get());
    $main->close();
?>