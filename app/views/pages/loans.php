<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">



        <div class="card bg-transparent mt-3 shadow-none border border-light">
            <div class="card-content">
                <div class="row row-group m-0">
                    <div class="col-12 col-lg-6 col-xl-3 border-light">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left">
                                    <h4 class="text-info"><?php  echo $data['usercount']  ?></h4>
                                    <span>Loans Accounts</span>
                                </div>
                                <div class="align-self-center w-circle-icon rounded bg-info shadow-info">
                                    <i class="icon-basket-loaded text-white"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-3 border-light">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left">
                                    <h4 class="text-danger"><?php echo $data['customercount']   ?></h4>
                                    <span>Total Loans</span>
                                </div>
                                <div class="align-self-center w-circle-icon rounded bg-danger shadow-danger">
                                    <i class="icon-wallet text-white"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-3 border-light">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left">
                                    <h4 class="text-success"><?php echo number_format($data['totalpayments'], 2) ?></h4>
                                    <span>Total Collected</span>
                                </div>
                                <div class="align-self-center w-circle-icon rounded bg-success shadow-success">
                                    <i class="icon-pie-chart text-white"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-3 border-light">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left">
                                    <h4 class="text-warning"><?php  echo  number_format($data['paymentstoday'],2)  ?></h4>
                                    <span>Total Outstanding</span>
                                </div>
                                <div class="align-self-center w-circle-icon rounded bg-warning shadow-warning">
                                    <i class="icon-user text-white"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-lg-12">
                <div class="cards">
                    <div class="card-header border-0">
                        Summary of all Loan Accounts and Configuration
                        <div class="card-action">
                            <div class="dropdown">
                                <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                                    <i class="icon-options"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void();">Action</a>
                                    <a class="dropdown-item" href="javascript:void();">Another action</a>
                                    <a class="dropdown-item" href="javascript:void();">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void();">Separated link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <br/>
                        <table class="table align-items-center apptables table-flush">
                            <thead>
                            <tr>
                                <th>Accoout Name</th>
                                <th>Account No:</th>
                                <th>Accunt Type </th>
                                <th>Configure</th>

                            </tr>
                            </thead>
                            <?php foreach ($data['loanaccounts'] as $get):   ?>
                                <tr>
                                    <td><?php echo $get->accountname ?></td>
                                    <td><?php echo $get->accountnumber ?></td>
                                    <td><?php echo $get->accounttype ?></td>
                                    <td><a href="<?php echo URLROOT.'/loan/management/'.$get->bid  ?>">
                                            Configure</a></td>
                                </tr>
                            <?php  endforeach;  ?>



                        </table>
                    </div>
                </div>
            </div>
        </div><!--End Row-->



        <!--End Dashboard Content-->

    </div>
    <!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->


<!--End Back To Top Button-->

<?php  require ("includes/footer.php"); ?>
