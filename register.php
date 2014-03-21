<?php
require_once './Core/init.php';
//require_once 'core/init.php';


if (Input::exitsts()) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'username' => array(
            'required' => TRUE,
            'min' => 2,
            'max' => 10,
            'unique' => 'user_table'
        ),
        'password' => array(
            'required' => TRUE
        ),
        'password_again' => array(
            'required' => TRUE,
            'matches' => 'password'
        )
    ));

    if ($validation->passed()) {
        //register user
        
    } else {
        //output error\
        print_r($validation->error());
    }
    echo Input::get('username');
}
?>


<form action="" method="POST">
    <div>
        <label for="username">User Name</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>"/>
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" value=""/>
    </div>
    <div>
        <label for="password_again">User Name</label>
        <input type="password" name="password_again" id="password_again" value=""/>
    </div>
    <div>
        <label for="name">Your Name</label>
        <input type="text" name="name" id="name" value=""/>
    </div>


    <button type="submit" name="save">Submit</button>
</form>