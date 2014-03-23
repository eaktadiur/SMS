<?php
require_once '../Core/init.php';

if (Session::exists('home')) {
    echo Session::flash('home');
}
//echo Session::get(Config::get('session/session_name'));

include_once '../body/header.php ';


if (Session::get(Config::get('session/session_name'))) {
    ?>
    <p>Hello <a href="#"><?php echo escape(Session::get('user')); ?></a>!</p>
    <ul>
        <li><a href="logout.php">Log Out</a></li>
        <li><a href="change_password.php">Change Password</a></li>
        <li><a href="update.php">Update Profile</a></li>
    </ul>


<?php } else {
    ?>
    <p>You Need to <a href="login.php">Log In</a> or <a href="register.php">Register</a></p>

    <?php
}
?>

<h2>auth/Index Page</h2>



<?php include_once '../body/footer.php'; ?>