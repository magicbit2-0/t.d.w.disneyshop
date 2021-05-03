<?php
require "dbms.inc.php";
function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;

    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd,$pwdRe){
    $result;
    if ($pwd !== $pwdRe){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function UsernameExists($mysqli,$username){
    $result0 = $mysqli->query("select * from utente where username ='$username'");
    $count = mysqli_num_rows($result0);
    if( $count > 0){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createUser($mysqli,$nome,$cognome,$birthdate,$email,$paese,$regione,$indirizzo,$username,$pwd){
    $indirizzo1 = addslashes($indirizzo);
    $result = $mysqli->query("insert into utente 
                              (id,username,nome,cognome,data_nascita,email,paese,regione,indirizzo,password,avatar_id) 
                              values
                              (null,\"$username\", \"$nome\", \"$cognome\",\"$birthdate\",
                              \"$email\", \"$paese\", \"$regione\" ,
                              \"$indirizzo1\", md5(\"$pwd\"), 1 )");

    if(!$result){
        echo "errore";
        exit;
    }
    else {
        $result = $mysqli->query("select id as idUtente from utente where username = '$username' and password = md5('$pwd')");
        if (mysqli_num_rows($result) == 1) {
            $data = $result->fetch_assoc();
            $idUtente = $data['idUtente'];
        $result = $mysqli->query("insert into gruppo_utente (id, utente_id,gruppo_id)
                                  values (null,'$idUtente',1)
                                  ");
            if(!$result){
                echo "errore";
                exit;
            } else {

        header("location: ./index.php?signedup");
            }
        }
    }
}
?>
