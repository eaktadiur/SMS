<?php
require_once '../Core/init.php';
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
            <li class="active">Index</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content box">
        <div class="row">
            <?php
            if (Session::exists('home')) {
                echo Session::flash('home');
            }
            ?>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->







<?php include_once '../body/footer.php'; ?>