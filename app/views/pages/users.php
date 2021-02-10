<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title">User Management</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">RL Micro Ventures</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">

                <form method="post">
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">First name</label>
                        <div class="col-lg-8">
                            <input name="firstname" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Last name</label>
                        <div class="col-lg-8">
                            <input name="lastname"  class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Telephone</label>
                        <div class="col-lg-8">
                            <input name="telephone"  class="form-control" type="text" required >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Email</label>
                        <div class="col-lg-8">
                            <input name="email"  class="form-control" type="email" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Role</label>
                        <div class="col-lg-8">
                            <select class="form-control" name="role" required>
                                <option value="">Select a role</option>
                                <option value="1">Adminstrator</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Password</label>
                        <div class="col-lg-8">
                            <input name="password"  class="form-control" type="password" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Confirm</label>
                        <div class="col-lg-8">
                            <input name="cpassword" class="form-control" type="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label"></label>
                        <div class="col-lg-8">
                            <input type="reset"   class="btn btn-secondary" value="Cancel">
                            <input name="adduser" type="submit" class="btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped apptables">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Configure</th>
                                <th scope="col"><i class="fa fa-trash-o"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  foreach ($data['users'] as $key=>$get):   ?>
                            <tr>
                                <th scope="row"><?php echo $key + 1  ?></th>
                                <td><?php  echo $get->firstname.' '.$get->lastname ?></td>
                                <td><?php  echo $get->email ?></td>
                                <td><a href="/pages/edituser/<?php echo $get->uid  ?> ">Configure</a></td>
                                <td><a href="#"  userid="<?php  echo $get->uid  ?>" class="deleteuser"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                            <?php  endforeach  ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <?php  require ("includes/footer.php"); ?>
