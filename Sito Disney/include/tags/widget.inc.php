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
            case "noLogin":
                $buffer = "<p class=\"ion-alert-circled alert-warning\" 
                style=\"background-color: darksalmon;color: unset;font-weight: bold;text-transform: initial;\"
                ><i class=\"icon-warning\"></i> Non puoi accedere a questa pagina! Effettua prima il login</p>";
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
            case "questo elemento già esiste!":
                $buffer = '<div class="alert" style="padding: 20px;background-color: #f44336; /* Red */color: white;margin-bottom: 15px;">
                            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';" style="margin-left: 15px;
                            color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;
                            </span>Questo elemento già esiste!</div>';
                break;
            case "unknown error occured!":
                $buffer = '<div class="alert" style="padding: 20px;background-color: #f44336; /* Red */color: white;margin-bottom: 15px;">
                            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';" style="margin-left: 15px;
                            color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;
                            </span>Unknown error occured!</div>';
                break;
            case "Non puoi caricare file di questo tipo":
                $buffer = '<div class="alert" style="padding: 20px;background-color: #f44336; /* Red */color: white;margin-bottom: 15px;">
                            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';" style="margin-left: 15px;
                            color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;
                            </span>Non puoi caricare file di questo tipo!</div>';
                break;
            case "Il file è troppo grande":
                $buffer = '<div class="alert" style="padding: 20px;background-color: #f44336; /* Red */color: white;margin-bottom: 15px;">
                            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';" style="margin-left: 15px;
                            color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;
                            </span>Il file è troppo grande!</div>';
                break;
            case "url non valido":
                $buffer = '<div class="alert" style="padding: 20px;background-color: #DBAB41FF; /* Red */color: white;margin-bottom: 15px;">
                            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';" style="margin-left: 15px;
                            color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;
                            </span>L\'Url del trailer inserito non è valido!</div>';
                break;
            case "deletedKeyWord":
                    $buffer = '<div class="alert" style="padding: 20px;background-color: #f44336; /* Red */color: white;margin-bottom: 15px;">
                            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';" style="margin-left: 15px;
                            color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;
                            </span>Parola Chiave eliminata con successo</div>';
                    break;
            case "deleted":
                    $buffer = '<div class="alert" style="background-color: #f44336; /* Red */color: white;margin-bottom: 10px;width: 310px;height: 20px;
                            padding-bottom: 30px;margin-left: 935px;"> <span class="closebtn" onclick="this.parentElement.style.display=\'none\';" style="margin-left: 15px;
                            color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;
                            </span>Elemento cancellato con successo!</div>';
                    break;
            case "addedItem";
                $buffer = '<div class="alert" style="padding: 20px;background-color: #00bb00; /* Red */color: white;margin-bottom: 15px;">
                           <span class="closebtn" onclick="this.parentElement.style.display=\'none\';" style="margin-left: 15px;color: white;font-weight: bold;float: right;
                           font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;</span>Elemento aggiunto con successo.</div>';
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