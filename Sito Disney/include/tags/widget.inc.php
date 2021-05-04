<?php


class widget extends taglibrary
{

    function injectStyle()
    {
    }


    function select($name, $data, $pars)
    {

        global $mysqli;

        $buffer = "<select name=\"{$name}\" id=\"{$name}\">\n";

        $table = $pars['table'];
        $text = $pars['value'];
        $key = $pars['key'];

        $result = $mysqli->query("
				SELECT 
					{$table}.{$text} AS {$table}_{$text},
					{$table}.{$key} AS {$table}_{$key}
				FROM 
					{$table}
			");
        while ($item = $result->fetch_assoc()) {
            $buffer .= "<option value=\"" . $item["{$table}_{$key}"] . "\">" . $item["{$table}_{$text}"] . "</option>\n";
        }

        $buffer .= "</select>\n";

        return $buffer;

    }

    function notification($name, $data, $pars)
    {

        switch ($data) {
            case "errorLogin":
                $buffer = "<p class=\"ion-alert-circled alert-warning\" 
                style=\"background-color: darksalmon;color: unset;font-weight: bold;text-transform: initial;\"
                ><i class=\"icon-remove\"></i> Username/Password errati. Riprova!</p>";
                break;
            case "error":
                $buffer = "<p class=\"warnbox red\"><i class=\"icon-remove\"></i> There was an error!</p>";
                break;
            case "invalidEmail":
                $buffer = "<p class=\"ion-alert-circled alert-warning\" 
                style=\"background-color: darksalmon;color: unset;font-weight: bold;text-transform: initial;\"
                ><i class=\"icon-remove\"></i> Email non valida. Riprova!</p>";
                break;
            case "pwdMatch":
                $buffer = "<p class=\"ion-alert-circled alert-warning\" 
                style=\"background-color: darksalmon;color: unset;font-weight: bold;text-transform: initial;\"
                ><i class=\"icon-remove\"></i> Le password inserite non sono uguali. Riprova!</p>";
                break;
            case "usernameExists":
                $buffer = "<p class=\"ion-alert-circled alert-warning\" 
                style=\"background-color: darksalmon;color: unset;font-weight: bold;text-transform: initial;\"
                ><i class=\"icon-remove\"></i> Username già esistente. Prova con un altro!</p>";
                break;
            case "success";
                $buffer = "<p class=\"alert-success\"><i class=\"icon-ok\"></i> The item has been succesfully added!</p>";
                break;
            case "signedup";
                $buffer = "<p class=\"alert-success\"><i class=\"icon-ok\"></i> Registrazione effettuata!</p>";
                break;
            default:
                $buffer = "";
                break;
        }


        return $buffer;


    }

    function nomeAdmin($nome)
    {
        $buffer = "qui è niente "  ;
        global $mysqli;
        /*if (($_SESSION['idUtente']) != null) {
            $result = $mysqli->query("select nome from utente where id = {$_SESSION['idUtente']}");
            $data = $result->fetch_assoc();
            $nome = $data['nome'];
            $buffer = "<a class=\"d-block\"> $nome </a>";
            echo "qui è " . $nome;
        }*/
        return $buffer;
    }

}

?>