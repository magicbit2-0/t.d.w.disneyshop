<?php
error_reporting(E_ALL & ~E_NOTICE);
require "include/dbms.inc.php";
require "include/template2.inc.php";
require "include/adminFunctions.inc.php";
$body=new Template("dtml/ADMIN/pages/examples/projects.html");
if (isset($mysqli)) {

    $result = $mysqli->query("SELECT id as idImg, titolo, data_uscita, votazione, categoria 
                                    FROM articolo");
    while($data = $result->fetch_assoc()) {
        foreach ($data as $key => $value) {
            $body->setContent($key, $value);
            }
        $body->setContent("votazione1", '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'.$data['votazione'].'" 
                                                        aria-valuemin="0" aria-valuemax="10" style="width: '. $data['votazione']*10 .'%"></div>');
    }
}
$main->setContent("body_admin", $body->get());
$main->close();
?>
