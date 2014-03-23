<?php

class Redirect {

    public static function to($location) {
        if(is_null($location)){
            switch ($location) {
                case 404:
                    header('HTTP/1.0 404 Not Found');
                    include '../includes/errors/404.php';
                    exit();
                    break;

                default:
                    break;
            }

        }
        if ($location) {
            header('Location: ' . $location);
            exit();
        }
    }

}
