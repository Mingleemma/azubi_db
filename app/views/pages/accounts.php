<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

    <div class="clearfix"></div>
    <div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title">ACCOUNTS</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">RL Micro Ventures</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Accounts</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">



                <form method="post">

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Account Type </label>
                        <input type="hidden" name="bid" value ='<?php  echo $data['customerdata']->bid;   ?>'>
                        <div class="col-lg-8">
                            <select class="form-control" name="accounttype" required>

                                <option value="">Select Account Type</option>
                                <option>Loan Account</option>
                                <option>Sus Account</option>
                                <option>Savings  Account</option>
                                <option>Current Account</option>
                                <option>Cash Collateral</option>


                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label"></label>
                        <div class="col-lg-8">
                            <input type="reset"   class="btn btn-secondary" value="Cancel">
                            <input name="addpayment" type="submit" class="btn btn-primary" value="Create Account">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-7">
                <?php if(isset($data['alert'])) { ?>

                    <div class="<?php echo $data['alert'] ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <div class="alert-icon">
                            <i class="icon-info"></i>
                        </div>
                        <div class="alert-message">
                            <span><strong>Info!</strong> <?php  echo $data['message']    ?></span>
                        </div>
                    </div>
                <?php  }  ?>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped apptables display table-responsive" width="100%" >
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Account Name</th>
                                <th scope="col">Account Type </th>
                                <th scope="col">Account #</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  foreach ($data['accountsdata'] as $key=>$get):   ?>
                                <tr>
                                    <td><?php  echo $key+1 ?></td>
                                    <td><?php echo $get->accountname  ?></td>
                                    <td><?php  echo $get->accounttype ?></td>
                                    <td><?php  echo $get->accountnumber ?></td>
                                </tr>
                            <?php  endforeach;  ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>


<?php  require ("includes/footer.php"); ?>