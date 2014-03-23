<?php

function escape($string) {
    if (strlen($string) > 0){
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }  else {
        return '';    
    }
}

?>