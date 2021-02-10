<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

    <div class="clearfix"></div>
    <div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title">Loan Management</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">RL Micro Ventures</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Loans</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">

                <form method="post">
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Loan Amount</label>
                        <div class="col-lg-8">
                            <input name="amount" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Start Date</label>
                        <div class="col-lg-8">
                            <input name="paymentdate" id="paymentdate"  class="form-control alldates" type="text"  required>
                            <input name="bid"  class="form-control alldates" type="hidden"
                                   value="<?php echo $data['customerdata']->bid  ?>" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Duration</label>
                        <div class="col-lg-8">
                            <select name="method" class="form-control">
                                <option value =''>Duration in Months</option>
                                <?php  for($m = 1; $m<=24; $m++){   ?>
                                <option value="<?php echo $m ?>"><?php  echo $m.  ' month(s)'   ?></option>
                                <?php }    ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Repayment Structure</label>
                        <div class="col-lg-8">
                           <select name="method" class="form-control">
                               <option value =''>Select Repayment Structure</option>
                               <option>Flat</option>
                               <option>Reducing Balance</option>
                               <option>Annuity</option>
                           </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label"></label>
                        <div class="col-lg-8">
                            <input type="reset"   class="btn btn-secondary" value="Cancel">
                            <input name="addpayment" type="submit" class="btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-7">
                <div class="card">

                        <table class="table table-striped"
                               style="font-size: 12px"
                               width="100%" >
                            <tr>
                                <td width="30%">Account Name:</td>
                                <td width="70%"> </td>
                            </tr>

                            <tr>
                                <td>Account Type:</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Principal Amount:</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Method</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Start Date</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>End Date</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Duration</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Amount Paid</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Amount Outstanding</td>
                                <td></td>
                            </tr>



                        </table>

                    </div>

            </div>

        </div>
    </div>


<?php  require ("includes/footer.php"); ?>