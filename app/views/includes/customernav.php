<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Inventory System</title>
    <!--favicon-->
    <link rel="icon" href="<?php echo URLROOT.'/backoffice/'?>/images/favicon.ico" type="image/x-icon">
    <!-- Vector CSS -->
    <link href="<?php echo URLROOT.'/backoffice/'?>/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT.'/backoffice/'?>/plugins/jquery.steps/css/jquery.steps.css">
    <!-- simplebar CSS-->
    <link href="<?php echo URLROOT.'/backoffice/'?>plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
    <link href="<?php echo URLROOT.'/backoffice/'?>/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <!--Touchspin-->
    <link href="<?php echo URLROOT.'/backoffice/'?>/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap core CSS-->
    <link href="<?php echo URLROOT.'/backoffice/'?>/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- animate CSS-->
    <link href="<?php echo URLROOT.'/backoffice/'?>/css/animate.css" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS-->
    <link href="<?php echo URLROOT.'/backoffice/'?>/css/icons.css" rel="stylesheet" type="text/css"/>
    <!-- Sidebar CSS-->
    <link href="<?php echo URLROOT.'/backoffice/'?>/css/sidebar-menu.css" rel="stylesheet"/>
    <link href="<?php echo URLROOT.'/backoffice/'?>/css/sumoselect.min.css" rel="stylesheet">
    <!-- Custom Style-->
    <link rel="stylesheet" type="text/css" id="theme" href="/vendor/components/jqueryui/themes/base/jquery-ui.css"/>
    <link href="<?php echo URLROOT.'/backoffice/'?>/css/app-style.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT ?>/vendor/datatables/datatables/media/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT.'/backoffice/' ?>/css/dataTables/css/rowReorder.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT.'/backoffice/' ?>/css/dataTables/css/responsive.dataTables.min.css"/>

</head>

<body>

<!-- Start wrapper-->
<div id="wrapper">

    <!--Start sidebar-wrapper-->
    <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
        <div class="brand-logo">
            <a href="/pages/dashboard">
                <img src="<?php echo URLROOT.'/backoffice/'?>/images/logo.png" class="logo-icon" alt="logo icon">
                <h5 class="logo-text">Administrator</h5>
            </a>
        </div>
        <ul class="sidebar-menu do-nicescrol">
            <li class="sidebar-header">MAIN NAVIGATION</li>
            <li>
                <a href="<?php echo URLROOT.'/pages/dashboard' ?>" class="waves-effect">
                    <i class="icon-home"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

            </li>

            <li>
                <a href="<?php echo URLROOT.'/pages/users' ?>"  class="waves-effect">
                    <i class="icon-user"></i> <span>User Management</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT.'/pages/categories' ?>" class="waves-effect">
                    <i class="icon-briefcase"></i>
                    <span>Categories</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

            </li>

            <li>
                <a  href="<?php echo URLROOT.'/pages/products' ?>"  class="waves-effect">
                    <i class="fa fa-shopping-cart"></i> <span>Products</span>
                </a>
            </li>

            <li>
                <a  href="<?php echo URLROOT.'/invoicing' ?>"  class="waves-effect">
                    <i class="fa fa-shopping-cart"></i> <span>Sales & Invoicing</span>
                </a>
            </li>

            <li>
                    <a  href="<?php echo URLROOT.'/search' ?>"  class="waves-effect">
                        <i class="fa fa-search"></i> <span>Search Invoice</span>
                    </a>
            </li>

        </ul>

    </div>