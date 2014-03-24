<?php
include_once '../Core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exitsts()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => TRUE,
                'min' => 2,
                'max' => 50
            )
        ));

        if ($validation->passed()) {

            try {
                $user->update(array(
                    'Name' => Input::get('name')
                ));
            } catch (Exception $exc) {
                die($exc->getMessage());
            }


            Session::flash('home', 'You Profile have been Update Successfully!');
            Redirect::to('index.php');
        } else {
            //output error\
            foreach ($validation->errors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}

include_once '../body/header.php';
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
                                    <label for="name">User Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="<?php echo escape($user->data()->Name); ?>"/>                            </div>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="box-footer">
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>






    </section><!-- /.content -->
</aside><!-- /.right-side -->


<?php include_once '../body/footer.php'; ?>