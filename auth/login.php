<?php
require_once '../Core/init.php';
//include_once '../body/header.php ';

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
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Student</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content box">
        <div class="row">

            <div class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">New Registration</h3>
                    </div>

                    <form action="" method="post">
                        <div class="box-body">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="username">User Name</label>
                                    <input type="text" name="username" id="username" class="form-control" value="<?php echo escape(Input::get('username')); ?>"/>                            </div>
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

                        <div class="box-body">
                            <div class="box-footer">
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
                                <button type="submit" class="btn btn-primary">Log In</button>
                            </div>
                        </div>
                    </form>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>






    </section><!-- /.content -->
</aside><!-- /.right-side -->

<?php
//include_once '../body/footer.php'; ?>