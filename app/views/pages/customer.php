<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title">Customer Management</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">RL Micro Ventures</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Customers</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">

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
                            <input name="lastname"  class="form-control" type="text" required >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Date of Birth</label>
                        <div class="col-lg-8">
                            <input name="dateofbirth" id="dateofbirth"  class="form-control" type="text" required >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Telephone</label>
                        <div class="col-lg-8">
                            <input name="telephone"  class="form-control" type="text" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Email</label>
                        <div class="col-lg-8">
                            <input name="email"  class="form-control" type="email">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Gender</label>
                        <div class="col-lg-8">
                            <select class="form-control" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label"></label>
                        <div class="col-lg-8">
                            <input type="reset"   class="btn btn-secondary" value="Cancel">
                            <input name="addcustomer" type="submit" class="btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#pending" data-toggle="pill" class="nav-link active"> <span class="hidden-xs">Pending Customers</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#approved" data-toggle="pill" class="nav-link"> <span class="hidden-xs">Apprroved Customers</span></a>
                            </li>

                        </ul>
                        <div class="tab-content p-3">
                            <div class="tab-pane active" id="pending">
                                <table class="table table-bordered table-striped apptables table-responsive" width="100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th >Telephone</th>
                                        <th ><i class="fa fa-pencil"></i></th>
                                        <th ><i class="fa fa-trash-o"></i></th>
                                        <th ><i class="fa fa-check"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php  foreach ($data['pendingcustomers'] as $key=>$get):   ?>
                                        <tr>
                                            <th scope="row"><?php echo $key + 1  ?></th>
                                            <td width="20%"><a style="" href="<?php echo URLROOT.'/pages/customerprofile/'.$get->bid  ?>"><?php  echo $get->fullname ?></a></td>
                                            <td><?php  echo $get->telephone ?></td>

                                            <td><i class="fa fa-pencil"></i></td>
                                            <td><a href="#" bid='<?php echo $get->bid  ?>'  class="deletecustomer"><i class="fa fa-trash-o"></i></a></td>
                                            <td><input type="checkbox" class='approvecustomer' bid='<?php echo $get->bid  ?>' /></td>
                                        </tr>
                                    <?php  endforeach  ?>
                                    </tbody>
                                </table>
                            </div>

                                <div class="tab-pane" id="approved">
                                    <table class="table table-bordered table-striped apptables" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th >Telephones</th>
                                            <th ><i class="fa fa-pencil"></i></th>
                                            <th ><i class="fa fa-trash-o"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php  foreach ($data['approvedcustomers'] as $key=>$get):   ?>
                                            <tr>
                                                <th scope="row"><?php echo $key + 1  ?></th>
                                                <td width="20%"><a style="" href="<?php echo URLROOT.'/pages/customerprofile/'.$get->bid  ?>"><?php  echo $get->fullname ?></a></td>
                                                <td><?php  echo $get->telephone ?></td>

                                                <td><i class="fa fa-pencil"></i></td>
                                                <td><a href="#" bid='<?php echo $get->bid  ?>'  class="deletecustomer"><i class="fa fa-trash-o"></i></a></td>
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
