<?php
require_once '../Core/init.php';

if (Session::get(Config::get('session/session_name'))) {
    Redirect::to('index.php');
}
include_once '../body/header.php';

if (Input::exitsts()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, array(
            'username' => array('required' => TRUE),
            'password' => array('required' => TRUE)
        ));

        if ($validation->passed()) {
            $user = new User();

            $remember = (Input::get('remember')) === 'on' ? TRUE : FALSE;

            $login = $user->login(Input::get('username'), Input::get('password'), $remember);
            if ($login) {
                Session::flash('home', 'You Register Successfully!');
                Redirect::to('index.php');
                echo 'Successfully Login';
            } else {
                echo 'Sorry, Login is failed';
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}
?>


<div class="row">
    <!--<div class="col-lg-offset-3"></div>-->

    <div class="col-lg-4 col-lg-offset-4">
        <div class="box box-solid box-success form-box">

            <div class="box-header bg-olive">
                <h3 class="box-title">Log In</h3>
            </div>

            <form action="" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="username">User Name</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?php echo escape(Input::get('username')); ?>"/>                 
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" value=""/>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label for="remember">Remember</label>
                        <input type="checkbox" name="remember" id="remember" class="form-control" value="on"/>
                    </div>
                </div>

                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
                <button type="submit" class="btn bg-olive btn-block">Log In</button>

                <div class="margin text-center">
                    <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                    <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                    <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>
                </div>

                <div class="box-body">                                                               
                    <a href="#">I forgot my password</a><br>
                    <a href="register.php">Register a new membership</a>
                </div>
                <br>
            </form>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div>

<!--<div class="col-lg-offset-3"></div>-->






<?php include_once '../body/footer.php'; ?>