<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

    <style>

        .table-responsive {
            display: block;
        }

    </style>

    <div class="clearfix"></div>
    <div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title">USER MANAGEMENT</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Configure Users</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">

                <form name ="register" method = 'post'>
                    <table class='table table-bordered' width=800px>
                        <tr>
                            <td>Name</td>
                            <td><h3><?php echo $data['userdata']->firstname. ' '.$data['userdata']->lastname  ?></h3></td>
                        </tr>

                        <tr>
                            <td>Telephone</td>
                            <td><?php echo $data['userdata']->telephone ?></td>
                        </tr>

                        <tr>
                            <td>Email</td>
                            <td><?php echo $data['userdata']->email ?></td>
                        </tr>

                        <tr>
                            <td>Password</td>
                            <td><input id="password" type="password" name="password" placeholder="Password"
                                       class="form-control" required/></td>
                        </tr>

                        <tr>
                            <td>Confirm Password</td>
                            <td><input id="password" type="password" name="confirmpassword" placeholder="Confirm Password"
                                       class="form-control" required />

                                <input id="email" type="hidden" name="email" placeholder="Confirm Password"
                                       class="form-control" value="<?php echo $data['userdata']->email ?>" />

                                <input id="email" type="hidden" name="firstname" placeholder="Confirm Password"
                                       class="form-control" value="<?php echo $data['userdata']->firstname ?>" />

                                <input id="email" type="hidden" name="lastname" placeholder="Confirm Password"
                                       class="form-control" value="<?php echo $data['userdata']->lastname ?>" />
                                <input id="email" type="hidden" name="telephone" placeholder="Confirm Password"
                                       class="form-control" value="<?php echo $data['userdata']->telephone ?>" />
                                <input type="hidden" name="userid" value="<?php echo $data['userdata']->uid ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type='submit' class="btn btn-success loginuser" name='updateuser'>Submit</button>
                            </td>
                        </tr>


                    </table>
                </form>

            </div>
            <div class="col-lg-7">
                <form method="post">
                    <table>
                        <tr>
                            <td>Add User Role</td>
                            <td>
                                <select multiple class='form-control userroles' name='role[]' required >
                                    <?php  foreach ($data['roledata'] as $role){ ?>
                                        <optgroup label="<?php echo $role->module ?>">
                                            <?php
                                            $aroledata = Roles::getroleBymodule($role->module);
                                            foreach($aroledata as $dat){
                                                ?>
                                                <option><?php echo $dat->role ?></option>
                                            <?php }  ?>
                                        </optgroup>
                                    <?php } ?>

                                </select></td>
                            <td>
                                <input type="hidden" name="userid" value="<?php echo $data['userdata']->uid ?>" />
                                <button type='submit' class="btn btn-success btn-sm" name='addroles'>Add Role</button>
                            </td>
                        </tr>

                    </table>
                </form>

                <table class="table table-bordered">
                    <tr>
                        <td colspan="2"><h3>Existing User Roles</h3></td>
                    </tr>
                    <?php foreach($data['userroledata'] as $role):   ?>
                        <tr>
                            <td><?php  echo $role->role  ?></td>
                            <td><a href="#" class="deleteuserrole"
                                   userid="<?php  echo $role->uid  ?>"
                                   role="<?php  echo $role->role  ?>"
                                >Delete</a></td>
                        </tr>
                    <?php  endforeach;  ?>

                </table>
            </div>

        </div>
    </div>


<?php  require ("includes/footer.php"); ?>