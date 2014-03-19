<?php

//Forms posted
if (isSave()) {
    login();
}
include('../body/header.php');
?>
<div class="row-fluid">
    <div class="span12 center login-header">
        <h2>Welcome to Schoolify LMS</h2>
    </div><!--/span-->
</div><!--/row-->

<div class="container">

    <div class="row-fluid">
        <div class="span7">
            <img src="../public/images/side.png" alt="logo" class="img-responsive"/>
        </div>
        <div class="span5 offset1">
            <div class="center"><h1>Join With Us</h1></div>
            
            <hr>
            <div class="row-fluid">
                <div class="well center login-box">
                    <div class="alert alert-info">
                        Please login with your Company, Username and Password.
                    </div>
                    <?php //echo resultBlock($errors, $successes);  ?>
                    <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                        <fieldset>
                            <div class="input-prepend" title="Company" data-rel="tooltip">
                                <span class="add-on"><i class="icon-user"></i></span>
                                <input autofocus class="input-large span10" name="company" id="company" type="text" required style="widows: 98%;" />
                            </div>
                            <div class="clearfix"></div>
                            <div class="input-prepend" title="Username" data-rel="tooltip">
                                <span class="add-on"><i class="icon-user"></i></span>
                                <input class="input-large span10" name="username" id="username" type="text" required />
                            </div>
                            <div class="clearfix"></div>

                            <div class="input-prepend" title="Password" data-rel="tooltip">
                                <span class="add-on"><i class="icon-lock"></i></span>
                                <input class="input-large span10" name="password" id="password" type="password" required />
                            </div>
                            <p class="center span5">
                                <button type="submit" name="save" class="btn btn-primary">Login</button>
                            </p>
                            <p><a href="../common/forgot-password.php">Forgot Password</a></p>
                        </fieldset>
                    </form>
                </div><!--/span-->
            </div><!--/row-->
        </div>
    </div>
    <hr>

</div>




