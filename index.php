<?php

//header("Location: admin/dashboard.php"); 

require_once 'core/init.php';

$user=DB::getInstance()->get('user_table', array('UserName','=', 'admin'));

//$user = DB::getInstance()->insert("user_table", array('UserName', '=', 'admin'));

//$user = DB::getInstance()
//        ->update("user_table", 48, array(
//        'UserName' => 'ccadmin',
//        'Password' => 'New Pass'
//        ));

if (!$user->count()) {
    echo 'No User';
} else {
    echo $user->first()->UserName;
//    foreach ($user->results() as $user) {
//        echo $user->UserName.'<br>';
//    }
    
    //echo $user->results()[0]->UserName;
}
?>