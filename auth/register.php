<?php
require_once '../Core/init.php';
include_once '../body/header.php ';
//require_once 'core/init.php';
//var_dump(Token::check(Input::get('token')));



if (Input::exitsts()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => TRUE,
                'min' => 2,
                'max' => 10,
                'unique' => 'user_table'
            ),
            'password' => array(
                'required' => TRUE,
                'min' => 2,
                'max' => 10
            ),
            'password_again' => array(
                'required' => TRUE,
                'match' => 'password'
            ),
            'password_again' => array(
                'name' => TRUE,
                'min' => 2,
                'max' => 10
            )
        ));
        if ($validation->passed()) {
            $user = new User();
            $salt = Hash::salt(32);

            try {
                $user->create(array(
                    'UserName' => Input::get('username'),
                    'Name'=>Input::get('name'),
                    'Password' => Hash::make(Input::get('password'), $salt),
                    'Email' => Input::get('email'),
                    'Salt' => $salt,
                    'Joined' => date('Y-m-d H:i:s'),
                    'Group' => 1
                ));
            } catch (Exception $exc) {
                die($exc->getMessage());
            }


            Session::flash('home', 'You Register Successfully!');
            Redirect::to('index.php');
        } else {
            //output error\
            foreach ($validation->errors() as $error) {
                echo $error . '<br>';
            }
        }
        //echo Input::get('username');
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
                                <label for="password_again">User Name</label>
                                <input type="password" name="password_again" id="password_again" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input type="text" name="name" id="name" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="box-footer">
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>






    </section><!-- /.content -->
</aside><!-- /.right-side -->
<?php include_once '../body/footer.php'; ?>