<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../../css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="../../css/default.css" rel="stylesheet" type="text/css"  />
        <link href="../../css/component.css" rel="stylesheet" type="text/css"  />
        <script src="../../js/modernizr.custom.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <style>
        header > .navbar .nav > li > a > .label {
            border-radius: 50%;
            font-size: 10px;
            font-weight: normal;
            height: 15px;
            line-height: 1em;
            padding: 2px;
            position: absolute;
            right: 2px;
            text-align: center;
            top: 7px;
            width: 15px;
        }
    </style>

    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.html">Ticketpot</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse navbar-left" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="/music" class="ui-btn-active" data-transition="slide" rel="external">折扣服务</a></li>
                            <li><a href="/book" >建议带  GPS</a></li>
                            <li><a href="/movie" >活动</a></li>
                            <li><a href="/perform" >专辑</a></li>
                            <li><a href="/customer">客服中心</a></li>

                        </ul>


                    </div><!-- /.navbar-collapse -->
                    <div class="nav navbar-right navbar-header">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope"></i>
                                    <span class="label label-success">4</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 4 messages</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li><!-- start message -->
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="../../img/avatar3.png" class="img-circle" alt="User Image"/>
                                                    </div>
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li><!-- end message -->
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="../../img/avatar2.png" class="img-circle" alt="user image"/>
                                                    </div>
                                                    <h4>
                                                        AdminLTE Design Team
                                                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="../../img/avatar.png" class="img-circle" alt="user image"/>
                                                    </div>
                                                    <h4>
                                                        Developers
                                                        <small><i class="fa fa-clock-o"></i> Today</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="../../img/avatar2.png" class="img-circle" alt="user image"/>
                                                    </div>
                                                    <h4>
                                                        Sales Department
                                                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="../../img/avatar.png" class="img-circle" alt="user image"/>
                                                    </div>
                                                    <h4>
                                                        Reviewers
                                                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                </ul>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-warning"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users warning"></i> 5 new members joined
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#">
                                                    <i class="ion ion-ios7-cart success"></i> 25 sales made
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="ion ion-ios7-person danger"></i> You changed your username
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                            <!-- Tasks: style can be found in dropdown.less -->
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-tasks"></i>
                                    <span class="label label-danger">9</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 9 tasks</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Design some buttons
                                                        <small class="pull-right">20%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">20% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li><!-- end task item -->
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Create a nice theme
                                                        <small class="pull-right">40%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">40% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li><!-- end task item -->
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Some task I need to do
                                                        <small class="pull-right">60%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">60% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li><!-- end task item -->
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Make beautiful transitions
                                                        <small class="pull-right">80%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">80% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li><!-- end task item -->
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="#">View all tasks</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-user"></i>
                                    <span>Jane Doe <i class="caret"></i></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header bg-light-blue">
                                        <img src="../../img/avatar3.png" class="img-circle" alt="User Image" />
                                        <p>
                                            Jane Doe - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Followers</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Sales</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Friends</a>
                                        </div>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div><!-- /.container-fluid -->

            </nav>
        </header>


        <!-- Main content -->

        <div class="content">

            <div class="container box">

                <div class='box-body'>
                    <div class="container-fluid">


                        <div class="row-fluid">
                            <ul class="grid cs-style-3">
                                <li>
                                    <figure>
                                        <img src="img/lawyer.jpg" alt="img04">
                                        <figcaption>
                                            <h3>Settings</h3>
                                            <span>Jacob Cummings</span>
                                            <a href="http://dribbble.com/shots/1116685-Settings">Take a look</a>
                                        </figcaption>
                                    </figure>
                                </li>
                            </ul>
                        </div>




                        <div class="row-fluid">
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <div class="grid cs-style-3">
                                    <figure>
                                        <img class="img-responsive thumbnail" src="img/lawyer.jpg" alt="" />
                                        <figcaption>
                                            <h2>热点问题</h2>
                                            <span>有什么新的韩国</span>
                                            <a href="/news">Take a look</a>
                                        </figcaption>
                                    </figure>
                                </div>



                            </div>

                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <a href="/rent" rel="external">
                                    <img class="img-responsive thumbnail" src="img/cellrental.jpg" alt=""  />
                                    <h2>手机租赁服务</h2>
                                    <p>韩国手机租赁</p>
                                </a>
                            </div>

                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <a href="/sim" rel="external">
                                    <img class="img-responsive thumbnail"  src="img/Usim.jpg" alt=""  />
                                    <h2>SIM 卡</h2>
                                    <p>韩国SIM卡</p>
                                </a>
                            </div>

                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <a href="/news" rel="external">
                                    <img class="img-responsive thumbnail" src="img/even.jpg" alt=""  />
                                    <h2>活动</h2>
                                    <p>旅行和医疗旅游的信息来源</p>
                                </a>
                            </div>

                        </div>
                        <div class="row-fluid">
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <a href="/music" >
                                    <img class="img-responsive thumbnail" src="img/sale.jpg" alt=""  />
                                    <h2 class="ui-li-heading">医疗折扣活动</h2>
                                    <p class="ui-li-desc">医疗特别优惠信息</p>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <a href="/rent" rel="external">
                                    <img class="img-responsive thumbnail" src="img/cellrental.jpg" alt=""  />
                                    <h2 class="ui-li-heading">手机租赁服务</h2>
                                    <p class="ui-li-desc">韩国手机租赁</p>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <a href="/sim" rel="external">
                                    <img class="img-responsive thumbnail"  src="img/Usim.jpg" alt=""  />
                                    <h2 class="ui-li-heading">SIM 卡</h2>
                                    <p class="ui-li-desc">韩国SIM卡</p>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <a href="/news" rel="external">
                                    <img class="img-responsive thumbnail" src="img/even.jpg" alt=""  />
                                    <h2 class="ui-li-heading">活动</h2>
                                    <p class="ui-li-desc">旅行和医疗旅游的信息来源</p>
                                </a>
                            </div>

                        </div>


                    </div>
                </div>
            </div>


        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        <script src="../../js/jquery-1.7.2.js"></script>
        <!-- Bootstrap -->
        <script src="../../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../../js/AdminLTE/app.js" type="text/javascript"></script>
        <script src="../../js/toucheffects.js"></script>
    </body>
</html>