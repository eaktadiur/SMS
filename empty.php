<?php 
require_once ('lib/DbManager.php');

include 'body/header.php'; 
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Blank page
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Blank page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <?php
        define("DOMAIN", $_SERVER['SERVER_NAME'] . "/");
        define("DOMAIN_PUBLIC", DOMAIN . "public/");
        define("ROOT", __DIR__ . "/");
        define('PROJECT_ROOT', getcwd());
        //echo ROOT. '=='. PROJECT_ROOT;
        echo DOMAIN_PUBLIC;
        ?>























    </section><!-- /.content -->
</aside><!-- /.right-side -->


<?php include './body/footer.php'; ?>