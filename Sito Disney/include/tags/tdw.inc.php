<?php

Class tdw extends taglibrary {

    function injectStyle() {}

    function upper($name, $data, $pars) {

        return strtoupper($data);
    }

    function format($name, $data, $pars) {

        switch($pars['type']) {
            case "upper":
                $result = strtoupper($data);
                break;
            case "lower":
                $result = strtolower($data);
                break;
            case "ucwords":
                $result = ucwords($data);
                break;
            default:
                $result = $data;
                break;
        }

        return $result;
    }


}

?>
