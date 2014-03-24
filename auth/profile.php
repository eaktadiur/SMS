<?php
require_once '../Core/init.php';
include '../body/header.php';

if (!$userName = Input::get('user')) {
    Redirect::to('index.php');
} else {
    $user = new User($userName);

    if (!$user->exists()) {
        Redirect::to(404);
    } else {
        $data = $user->data();
    }
    ?>
    <h3><?php echo escape($data->UserName); ?></h3>
    <p>Full Name: <?php echo escape($data->Name); ?></p>
    <?php
}
?>





<?php include_once '../body/footer.php'; ?>