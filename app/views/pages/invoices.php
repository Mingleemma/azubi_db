<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">
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



        <div class="row">
            <div class="col-lg-12">
                <form method="post">
                <table>
                    <tr>
                        <td><input class="form-control" placeholder="From" name="from" id="from" readonly/></td>
                        <td><input class="form-control" placeholder="To" name="to" id="to" readonly/></td>
                        <td><button type="submit" name="searchpayment" style="color:#fff" class="btn btn-sm btn-warning pull-right">
                                <i class = 'fa fa-search'></i> Search </button></td>

                        <td width="60%">
                            <a href="/invoicing/refund"  style="color:#fff"
                               class="btn btn-sm btn-danger pull-right">
                                <i class = 'fa fa-folder-open-o'></i> Refund</a>
                            <a href="/invoicing/create"  style="color:#fff"
                                     class="btn btn-sm btn-success pull-right">
                                <i class = 'fa fa-folder-open-o'></i> Create New Invoice </a>

                        </td>
                    </tr>
                </table>
                </form>

                <br/>
            </div>
            <div class="col-lg-12">
                <div class="card" style="padding:10px">
                    <?php if(isset($data['paymentstoday'])) : ?>
                    <table class="table table-striped table-sm apptables" style="font-size: 12px">
                        <thead>
                        <tr style="font-weight: bold">
                            <td>Transaction Code</td>
                            <td>Date</td>
                            <td>Amount</td>
                            <td>Discount</td>
                            <td>Total Amount</td>
                            <td>View</td>
                        </tr>
                        </thead>
                        <?php
                            $total = 0;
                          foreach($data['paymentstoday'] as $get):
                              $total = $get->finalamount + $total;
                            ?>
                         <tr>
                            <td><?php echo $get->invoicecode  ?></td>
                            <td><?php echo $get->paydate  ?></td>
                            <td><?php echo number_format($get->amount,2)  ?></td>
                            <td><?php echo number_format($get->discount,2)  ?></td>
                            <td><?php echo number_format($get->finalamount,2)  ?></td>
                             <td><a href="#" class="viewtransactions" code="<?php echo $get->invoicecode ?>">View</a></td>
                        </tr>
                        <?php endforeach  ?>
                    </table>

                        <div align="center" style="font-size: 20px; font-weight: 700">
                            <?php
                            $totalamt = $total - Refund::getTotalByInvoiceRefundToday();
                            echo "TOTAL SALES:  GHC ". number_format($totalamt,2);  ?>
                        </div>
                    <?php endif  ?>


                    <?php if(isset($data['paymentsearchdata'])) : ?>
                        <table class="table table-striped table-sm apptables" style="font-size: 12px">
                            <thead>
                            <tr style="font-weight: bold">
                                <td>Transaction Code</td>
                                <td>Date</td>
                                <td>Amount</td>
                                <td>Discount</td>
                                <td>Total Amount</td>
                                <td>View</td>
                            </tr>
                            </thead>
                            <?php
                            $total = 0;
                            foreach($data['paymentsearchdata'] as $get):
                                $total = $get->finalamount + $total;
                                ?>
                                <tr>
                                    <td><?php echo $get->invoicecode  ?></td>
                                    <td><?php echo $get->paydate  ?></td>
                                    <td><?php echo number_format($get->amount,2)  ?></td>
                                    <td><?php echo number_format($get->discount,2)  ?></td>
                                    <td><?php echo number_format($get->finalamount,2)  ?></td>
                                    <td><a href="#" class="viewtransactions" code="<?php echo $get->invoicecode ?>">View</a></td>
                                </tr>
                            <?php endforeach  ?>
                        </table>
                        <div align="center" style="font-size: 20px; font-weight: 700">
                            <?php  echo "TOTAL SALES:  GHC ". number_format($total,2);  ?>
                        </div>
                    <?php endif  ?>

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
