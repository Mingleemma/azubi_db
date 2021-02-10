<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<div class="clearfix"></div>


<div class="content-wrapper">

    <div id="viewmodal" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 900px" role="document">

            <div class="modal-content"  style="width:700px" >
                <div class="modal-body" id="ajaxcontainer">

                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Close</button> -->

                </div>

            </div>
        </div>
    </div>


    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title">Customer Profile</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">RL Micro Ventures</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Customers Profile</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="profile-card-3">
                    <div class="card">
                        <div class="user-fullimage">
                            <img src="<?php  echo 'https://microfinance.getinnotized.com/uploads/'.$data['image']  ?>" alt="user avatar" class="card-img-top">
                            <div class="details">
                                <h5 class="mb-1 text-white ml-3"><?php echo $data['customerdata']->fullname   ?></h5>

                            </div>
                        </div>
                        <div class="card-body text-center">
                            <p></p>
                            <div class="row">
                                <div class="col p-2">
                                    <h5 class="mb-0 line-height-5"></h5>
                                    <small class="mb-0 font-weight-bold">Loan Amount</small>
                                </div>
                                <div class="col p-2">
                                    <h5 class="mb-0 line-height-5"><?php  echo $data['totalpayments']  ?></h5>
                                    <small class="mb-0 font-weight-bold">Total Paid</small>
                                </div>
                                <div class="col p-2">
                                    <h5 class="mb-0 line-height-5"></h5>
                                    <small class="mb-0 font-weight-bold">Total Oustanding</small>
                                </div>
                            </div>


                            <hr>
                            <a href="<?php  echo URLROOT.'/pages/payments/'.$data['customerdata']->bid ?>"
                               class="btn btn-primary shadow-primary btn-sm btn-round waves-effect waves-light m-1">Make Payments</a>
                            <a href="" class="btn btn-outline-primary btn-sm btn-round waves-effect waves-light m-1">Profile</a>
                            <a  href="<?php  echo URLROOT.'/pages/accounts/'.$data['customerdata']->bid ?>"  class="btn btn-outline-primary btn-sm btn-round waves-effect waves-light m-1">Accounts</a>
                        </div>

                        <div class="user-fullimage">
                            <img src="<?php  echo 'https://microfinance.getinnotized.com/uploads/'.$data['idimage']  ?>" alt="user avatar" class="card-img-top">

                        </div>
                        <div class="card-body text-center">
                            <p></p>
                            <div class="row">

                                <table class="table table-bordered">
                                    <tr>
                                        <td align="left">ID Type:</td>
                                        <td  align="left"><?php echo $data['idtype'] ?></td>
                                    </tr>
                                    <tr>
                                        <td  align="left">ID Number:</td>
                                        <td  align="left"><?php echo $data['idnumber'] ?></td>
                                    </tr>
                                    <tr>
                                        <td  align="left">Date of Issue: </td>
                                        <td  align="left"><?php echo $data['dateofissue'] ?></td>
                                    </tr>

                                    <tr>
                                        <td  align="left" >Date of Expiry:  </td>
                                        <td  align="left"><?php echo $data['expirydate'] ?></td>
                                    </tr>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active"><i class="icon-user"></i> <span class="hidden-xs">Profile</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#messages" data-toggle="pill" class="nav-link"><i class="icon-envelope-open"></i> <span class="hidden-xs">Payments</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link"><i class="icon-note"></i> <span class="hidden-xs">Edit Profile</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#accounts" data-toggle="pill" class="nav-link"><i class="icon-note"></i> <span class="hidden-xs">Accounts</span></a>
                            </li>
                        </ul>
                        <div class="tab-content p-3">
                            <div class="tab-pane active" id="profile">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="mt-2 mb-3"><span class="fa fa-clock-o ion-clock float-right"></span> Customer Profile</h5>
                                        <table class="table table-hover table-striped">
                                            <tbody>


                                            <tr>
                                                <td>Fullname</td>
                                                <td><strong><?php echo $data['customerdata']->fullname ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Firstname</td>
                                                <td><strong><?php echo $data['customerdata']->firstname ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Lastname</td>
                                                <td><strong><?php echo $data['customerdata']->lastname ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Telephone</td>
                                                <td><strong><?php echo $data['customerdata']->telephone ?></strong></td>
                                            </tr>

                                            <tr>
                                                <td>Date of Birth</td>
                                                <td><strong><?php echo $data['customerdata']->dateofbirth ?></strong></td>
                                            </tr>

                                            <tr>
                                                <td>Gender</td>
                                                <td><strong><?php echo $data['customerdata']->gender ?></strong></td>
                                            </tr>


                                            <tr>
                                                <td>Religion</td>
                                                <td><strong><?php echo $data['customerdata']->religion ?></strong></td>
                                            </tr>


                                            <tr>
                                                <td>Nationalty</td>
                                                <td><strong><?php echo $data['customerdata']->nationality ?></strong></td>
                                            </tr>

                                            <tr>
                                                <td>Residential Adddress</td>
                                                <td><strong><?php echo $data['customerdata']->city. " ".
                                                            $data['customerdata']->street. ' '.$data['customerdata']->street ?></strong></td>
                                            </tr>

                                            <tr>
                                                <td>Nearest landmark</td>
                                                <td><strong><?php echo $data['customerdata']->landmark  ?></strong></td>
                                            </tr>

                                            <tr>
                                                <td>Previous Address</td>
                                                <td><strong><?php echo $data['customerdata']->previousaddress ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Occupation</td>
                                                <td><strong><?php echo $data['customerdata']->occupation ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Position</td>
                                                <td><strong><?php echo $data['customerdata']->position ?></strong></td>
                                            </tr>

                                            <tr>
                                                <td>Employer</td>
                                                <td><strong><?php echo $data['customerdata']->employer ?></strong></td>
                                            </tr>

                                            <tr>
                                                <td>Marital Status</td>
                                                <td><strong><?php echo $data['customerdata']->maritalstatus ?></strong></td>
                                            </tr>

                                            <tr>
                                                <td>Spouse name</td>
                                                <td><strong><?php echo $data['customerdata']->spousename?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Spouse Contact</td>
                                                <td><strong><?php echo $data['customerdata']->spousetelephone ?></strong></td>
                                            </tr>

                                            <tr>
                                                <td>Spouse Occupation</td>
                                                <td><strong><?php echo $data['customerdata']->spouseoccupation?></strong></td>
                                            </tr>

                                            <tr>
                                                <td>Spouse Nationality </td>
                                                <td><strong><?php echo $data['customerdata']->spousenationality ?></strong></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" id="messages">

                                <table class="table table-striped apptables">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Amount </th>
                                        <th scope="col">Date Paid</th>
                                        <th scope="col"><i class="fa fa-pencil"></i></th>
                                        <th scope="col"><i class="fa fa-trash-o"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php  foreach ($data['payments'] as $key=>$get):   ?>
                                        <tr>
                                            <td><?php  echo $key+1 ?></td>
                                            <th scope="row"><?php echo $data['customerdata']->fullname  ?></th>
                                            <td><?php  echo $get->amount ?></td>
                                            <td><?php  echo $get->dateofpayment ?></td>
                                            <td><i class="fa fa-pencil"></i></td>
                                            <td><a href="#" class ='deletepayment'
                                                   bid = '<?php echo $data['customerdata']->bid  ?>'
                                                   payid='<?php  echo $get->payid ?>'><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                    <?php  endforeach  ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="edit">
                                <form>


                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">First name</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" value="<?php echo $data['customerdata']->firstname ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Last name</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" value="<?php echo $data['customerdata']->lastname ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Telephone</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" value="<?php echo $data['customerdata']->telephone ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Email</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" value="<?php echo $data['customerdata']->email ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Id Number</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="email" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label"></label>
                                        <div class="col-lg-9">
                                            <input type="reset" class="btn btn-secondary" value="Cancel">
                                            <input type="button" class="btn btn-primary" value="Save Changes">
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane" id="accounts">

                                <table class="table table-bordered">
                                    <tr>
                                        <td>Account Type</td>
                                        <td>Account Number</td>
                                    </tr>
                                    <?php  foreach($data['accountdata'] as $get):   ?>
                                    <tr>
                                        <td><a href="#" account="<?php  echo $get->accountnumber   ?>"
                                               accounttype="<?php  echo $get->accounttype   ?>"
                                             class='accountview' ><?php  echo $get->accounttype    ?></a></td>
                                        <td><?php  echo $get->accountnumber   ?></td>
                                    </tr>
                                    <?php   endforeach;  ?>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <?php  require ("includes/footer.php"); ?>
