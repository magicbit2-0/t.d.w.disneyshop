<?php
    require "include/dbms.inc.php";
    require "include/template2.inc.php";

    $main=new Template("dtml/index.html");

    $result = $mysqli -> query("select * from articolo order by titolo asc");

    while ($data = $result -> fetch_assoc()){
    };

    exit;

    $main->close();
?>