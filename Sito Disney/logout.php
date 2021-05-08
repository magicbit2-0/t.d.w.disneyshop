<?php
        session_start();

        unset($_SESSION['auth']);
        unset($_SESSION['idUtente']);
        unset($_SESSION['articoli']);
        
        if($_SERVER['HTTP_REFERER'] ==
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/userfavoritegrid.php" || 
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/userfavoritegrid.php?" ||
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/userprofile.php" ||
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/userprofile.php?" ||
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/userrate.php" ||
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/userrate.php?" ||
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/shoppage.php" ||
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/shoppage.php?" ||
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/infouser.php" ||
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/infouser.php?" ||
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/acquistoSimulato.php" ||
        "http://localhost/t.d.w.disneyshop/Sito%20Disney/acquistoSimulato.php?"
        ){
                Header("location: index.php");
        } else {
                if(isset($_GET)){
                $elem="";
                foreach ($_GET as $ind => $val){
                        $elem = $elem."&".$ind."=".$val;
                }
                Header("location: ".$_SERVER['HTTP_REFERER'].$elem);
                } else {
                Header("location: ".$_SERVER['HTTP_REFERER']);
                }
        }
?>