<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.shapedtheme.com/kotha-pro-html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Apr 2019 08:46:58 GMT -->
<head>
    <!-- Document Settings -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- Page Title -->
    <title>Kotha Pro - The Most Powerful Blog Theme</title>
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,700i%7cOswald:300,400,500,600,700%7cPlayfair+Display:400,400i,700,700i"
        rel="stylesheet">


    <!-- Styles -->
    <link rel="stylesheet" href="/assets/front/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/front/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/front/css/slick-theme.css">
    <link rel="stylesheet" href="/assets/front/css/slick.css">
    <link rel="stylesheet" href="/assets/front/style.css">

    <!-- HTML5 shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/assets/front/js/html5shiv.js"></script>
    <script src="/assets/front/js/respond.js"></script>
    <![endif]-->
</head>
<body>
<header class="kotha-menu marketing-menu">
    <nav class="navbar  navbar-default">
        <div class="container">
            <div class="menu-content">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#myNavbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="top-social-icons list-inline pull-right">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li class="top-search">
                            <a href="#" class="sactive">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav text-uppercase pull-left">
                        <li>
                            <a href="/" class="dropdown-toggle"
                               role="button"
                               aria-haspopup="true" aria-expanded="false">Home</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"  role="button"
                               aria-haspopup="true" aria-expanded="false">Categories</a>
                            <ul class="dropdown-menu">
                                <?php foreach ($categories as $post):?>
                                    <li><a href="/category/<? echo $post['title']?>"><? echo $post['title']?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li><a href="#">About me</a></li>
                        <li><a href="#">Contact</a></li>
                       <? $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
                          $auth = new \Delight\Auth\Auth($db);
                       if ($auth->hasRole(\Delight\Auth\Role::SUPER_ADMIN)): ?>
                            <li><a href="/admin">Admin Panel</a></li>
                       <?endif; ?>

                        <? if ($auth->isLoggedIn()): ?>
                            <li><a style="color: #da521e;" href="/logout">Logout</a></li>
                        <? else: ?>
                            <li><a style="color: #da521e;" href="/registration">Registration</a></li>
                            <li><a style="color: #da521e;" href="/login">Login</a></li>
                        <?endif; ?>

                    </ul>
                </div>
                <div class="show-search">
                    <form role="search" method="get" id="searchform" action="#">
                        <input type="text" placeholder="Search and hit enter..." name="s" id="s">
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div class="kotha-logo text-center">
        <h1><a href="/"><img src="/assets/front/images/kotha-logo.png" alt="kothPro"></a></h1>
    </div>
</header>
