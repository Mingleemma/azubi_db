<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title">Payments</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">RL Micro Ventures</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payments</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">

                <form method="post">
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Amount</label>
                        <div class="col-lg-8">
                            <input name="amount" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Date of Payment</label>
                        <div class="col-lg-8">
                            <input name="paymentdate" id="paymentdate"  class="form-control alldates" type="text"  required>
                            <input name="bid"  class="form-control alldates" type="hidden"
                                   value="<?php echo $data['customerdata']->bid  ?>" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Account </label>
                        <div class="col-lg-8">
                           <select class="form-control" name="accountnumber" required>
                               <?php foreach ($data['accountsdata'] as $get):   ?>
                                <option value="<?php  echo $get->accountnumber ?>"><?php  echo $get->accounttype. ' - '. $get->accountnumber ?></option>
                               <?php endforeach;  ?>
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
                    <div class="card-body">
                        <table class="table table-striped apptables display table-responsive" width="100%" >
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Amount </th>
                                <th scope="col">Account</th>
                                <th scope="col">Date Paid</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php  foreach ($data['paymentdata'] as $key=>$get):   ?>
                                <tr>
                                    <td ><?php  echo $key+1 ?></td>
                                    <td ><?php echo $data['customerdata']->fullname  ?></td>
                                    <td><?php  echo $get->amount ?></td>
                                    <td><?php  echo $get->accountnumber ?></td>
                                    <td><?php  echo $get->dateofpayment ?></td>
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