<?php

// unpack our $data array
foreach($data as $name => $value){
    $$name = $value;
}

?>

<!DOCTYPE html>
<html lang="en">

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo SITENAME  ?></title>

	<!-- Vendor Global stylesheets  -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo URLROOT ?>/vendor/kamihouse/icomoon_free_version/css/icomoon.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo URLROOT ?>/vendor/fortawesome/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT ?>/vendor/drmonty/datatables-responsive/css/dataTables.responsive.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT ?>/vendor/sciactive/pnotify/dist/pnotify.css"/>
    <!-- /vendor global stylesheets -->

    <!-- Custom CSS files to be developed and maintained  -->
    <link href="<?php echo URLROOT ?>/ldb/css/pages.css" rel="stylesheet" type="text/css">
    <link href="<?php echo URLROOT ?>/ldb/css/animate.min.css" rel="stylesheet" type="text/css">
    <!-- /custom CSS files to be developed and maintained  -->

    <!-- Vendor JS files -->
    <script type="text/javascript" src="<?php echo URLROOT ?>/vendor/components/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/vendor/components/jqueryui/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/vendor/grimmlink/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/vendor/rohnstock/pickadate/js/picker.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/vendor/rohnstock/pickadate/js/picker.date.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/vendor/sciactive/pnotify/dist/pnotify.js"></script>

    <script type="text/javascript" src="<?php echo URLROOT ?>/vendor/datatables/datatables/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/vendor/drmonty/datatables-responsive/js/dataTables.responsive.js"></script>
    <!-- /vendor JS files -->

    <!-- plugins that have not yet been added to https://packagist.org/  -->
    <script type="text/javascript" src="<?php echo URLROOT ?>/ldb/js/uniform.min.js"></script>

    <!-- core js plugin files -->
    <script type="text/javascript" src="<?php echo URLROOT ?>/ldb/js/app.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/ldb/js/wizards/wizard.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/ldb/js/fab.min.js"></script>
    <!-- /plugins  -->


    <?php
    if (isset($basehref)){
        echo "<base href='$basehref'>";
    }
    ?>

</head>





