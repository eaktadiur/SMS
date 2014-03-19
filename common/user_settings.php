<?php
include '../lib/DbManager.php';

$userPass = find("SELECT `Password`, Email 
    FROM user_table ut
    LEFT JOIN employee e ON e.EmployeeId=ut.EmployeeId
    WHERE ut.EmployeeId='$employeeId'");


if (isSave()) {
    $errors = array();
    $successes = array();


    $password = getParam("password");
    $password_new = getParam("passwordc");
    $password_confirm = getParam("passwordcheck");
    $email = getParam("email");

    if (trim($password) == '') {
        $errors[] = "Account Password Required";
    } elseif (md5($password) != "$userPass->Password") {
        $errors[] = "Password Not Match";
    }

    if ($password_new != $password_confirm) {
        $errors[] = "Account Password Invalid";
    }

    if ($password_new != "" OR $password_confirm != "") {
        if (trim($password_new) == "") {
            $errors[] = "ACCOUNT_SPECIFY_NEW_PASSWORD";
        } else if (trim($password_confirm) == "") {
            $errors[] = "ACCOUNT_SPECIFY_CONFIRM_PASSWORD";
        } else if ($password_new != $password_confirm) {
            $errors[] = "ACCOUNT_PASS_MISMATCH";
        }

        //End data validation
        if (count($errors) == 0) {
            //This function will create the new hash and update the hash_pw property.
            $entered_pass = md5($password_new);
            query("UPDATE user_table SET Password='$entered_pass' WHERE EmployeeId='$employeeId'");
            //$loggedInUser->updatePassword($password_new);
            echo "<script>location.replace('../index/index.php');</script>";
        }
    }

    if (count($errors) == 0 AND count($successes) == 0) {
        $errors[] = "NOTHING_TO_UPDATE";
    }
}

require_once("../body/header.php");
?>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> User Settings</h2>

        </div>
        <div class="box-content">
            <?php // echo resultBlock($errors, $successes); ?>
            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="control-group">
                    <label class="control-label" for="focusedInput">Password</label>
                    <div class="controls">
                        <input name="password" type="password" class="input-xlarge focused" id="password" value="">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="focusedInput">Email</label>
                    <div class="controls">
                        <input name="email" type="text" class="input-xlarge focused" id="email" value="<?php echo $userPass->Email ?>" readonly="readonly">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="focusedInput">New Password</label>
                    <div class="controls">
                        <input name="passwordc" type="password" class="input-xlarge focused" id="passwordc" value="">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="focusedInput">Confirm Password</label>
                    <div class="controls">
                        <input name="passwordcheck" type="password" class="input-xlarge focused" id="passwordcheck" value="">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="save" value="save" class="btn btn-primary">
                        <i class="icon icon-edit"></i> Update
                    </button>
                    <button type="reset" class="btn btn-primary">
                        <i class="icon icon-cancel"></i>Cancel
                    </button>
                </div>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->
<?php include('../body/footer.php'); ?>
