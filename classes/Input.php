<?php

class Input {

    public static function exitsts($type = 'post') {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? TRUE : FALSE;
                break;
            case 'get':
                return (!empty($_GET)) ? TRUE : FALSE;
                break;
            default:
                break;
        }
    }

    public static function get($item) {
        if (array_key_exists($item, $_POST)) {
            return $_POST[$item];
        } elseif (array_key_exists($item, $_GET)) {
            return $_GET[$item];
        }
        return '';
    }

}

?>
    