<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITENAME   ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="#7568E0">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/style.default.css" id="theme-stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/custom.css">
    <link rel="shortcut icon" href="<?php echo URLROOT ?>/img/favicon.png">
    <link rel="stylesheet" href="css/font-awesome.min.css">
  
    <link rel="stylesheet" href="css/icons.css">

    <style>
        #content {
            width: 55%;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>


</head>

<body>



    <div class="page login-page">
        <div class="container d-flex align-items-center">
            <div class="form-holder has-shadow">
                <div class="row">
                    <!-- Logo & Information Panel-->
                    <div class="col-lg-6" style="background:#E46F2C">
                        <div id="content">
                            <!--<h1 style="color:#fff">commehr | Marketplace</h1>-->
                            <img src="../img/nlogo.png" alt="Commehr" style="height: 100%; width: 100%;">
                        </div>



                    </div>
                    <!-- Form Panel    -->
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <form  method="post">
                                    <div class="form-group">
                                      <input id="login-username" type="text" name="email" required="" class="input-material">
                                      <label for="login-username" class="label-material">User Name</label>
                                    </div>
                                    <div class="form-group">
                                     <input id="login-password" type="password" name="password" required="" class="input-material">
                                     <label for="login-password" class="label-material">Password</label>
                                    </div><button name="login" type='submit'  class="btn btn-primary">Login</button>
                            
                                </form>
                                <a href="#" class="forgot-pass">Forgot Password?</a>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    <!-- Javascript files-->
    <script src="<?php echo URLROOT ?>/js/jquery.min.js"></script>
    <script src="<?php echo URLROOT ?>/js/tether.min.js"></script>
    <script src="<?php echo URLROOT ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo URLROOT ?>/js/jquery.cookie.js"> </script>
    <script src="<?php echo URLROOT ?>/js/jquery.validate.min.js"></script>
    <script src="<?php echo URLROOT ?>/js/front.js"></script>
</body>

</html>