<?php
require_once '../Core/init.php';
include_once '../body/header.php';

$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exitsts()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, array(
            'current_password' => array(
                'required' => TRUE
            ),
            'password_new' => array(
                'required' => TRUE,
                'min' => 2,
                'max' => 10
            ),
            'password_new_again' => array(
                'required' => TRUE,
                'min' => 2,
                'match' => 'password_new'
            )
        ));

        if ($validation->passed()) {
            if (Hash::make(Input::get('current_password'), $user->data()->Salt) !== $user->data()->Password) {
                echo 'Your Current Password is worng';
            } else {
                $salt = Hash::salt(32);
                $user->update(array(
                    'Password' => Hash::make(Input::get('password_new'), $salt),
                    'Salt' => $salt
                ));


                Session::flash('home', 'You Password have been Change Successfully!');
                Redirect::to('index.php');
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
                        <h3 class="box-title">Change Password</h3>
                    </div>

                    <form action="" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password_new" id="password" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="password_again">New Password Again</label>
                                <input type="password" name="password_new_again" id="password_again" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="box-footer">
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </div>
                    </form>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>






    </section><!-- /.content -->
</aside><!-- /.right-side -->

<?php include_once '../body/footer.php'; ?>