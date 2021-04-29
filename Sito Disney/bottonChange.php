<?php
session_start();
$main=new Template("dtml/index.html");

if(isset($_REQUEST['accesso'])){
    if($_REQUEST['accesso'] == 'LoginError'){
        $body2 = new Template("dtml/login.html"); //ritenta accesso
        $body2->setContent("message", "errorLogin");
        $main->setContent("body2", $body2->get());
    }
    else if($_REQUEST['accesso'] == 'LoginOk'){
        $main = new Template("dtml/index2.html"); //accesso effettuato
    }
}
if($_SESSION['idUtente']!= null){
    $main = new Template("dtml/index2.html");
}
print_r($_SESSION);
?>