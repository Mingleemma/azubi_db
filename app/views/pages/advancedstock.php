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
                            <td><button type="submit" name="searchstock" style="color:#fff" class="btn btn-sm btn-warning pull-right">
                                    <i class = 'fa fa-search'></i> Search </button></td>


                        </tr>
                    </table>
                </form>

                <br/>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header border-0">
                                Products Purchase History
                            </div>

                            <div class="table-responsive">

                                <?php if(isset($data['from'])) :    ?>
                                <table class="table table-sm table-success table-striped">
                                    <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Qty in Stock </th>
                                        <th>Qty Sold</th>
                                    </tr>
                                    </thead>
                                    <?php foreach ($data['products'] as $get) {
                                        $productcount = Product::getProductCountById($get->productid);
                                        if ($productcount > 0) {

                                            $pro = new Product($get->productid);
                                            $invoicedate = date('Y-m-d');
                                            $from = $data['from'];
                                            $to = $data['to'];
                                            ?>
                                            <tr>
                                                <td><?php echo $pro->recordObject->productname ?></td>
                                                <td><?php echo Categories::getCategoryById($pro->recordObject->catid); ?></td>
                                                <td><?php echo $pro->recordObject->quantity ?></td>
                                                <td><?php echo Invoices::gettotalsoldbyRange($from, $to, $get->productid) ?></td>
                                            </tr>
                                        <?php }
                                    }
                                    ?>
                                </table>
                                <?php  endif;  ?>

                                <?php if(!isset($data['from'])) :    ?>
                                <table class="table table-sm table-dark table-striped">
                                    <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Qty in Stock </th>
                                        <th>Qty Sold</th>
                                    </tr>
                                    </thead>
                                    <?php foreach ($data['products'] as $get){
                                          $productcount = Product::getProductCountById($get->productid);
                                          if($productcount > 0){

                                        $pro = new Product($get->productid);
                                        $invoicedate = date('Y-m-d');
                                        $from  = $data['from'];
                                        $to = $data['to'];
                                        ?>
                                        <tr>
                                            <td><?php echo $pro->recordObject->productname ?></td>
                                            <td><?php echo  Categories::getCategoryById($pro->recordObject->catid ); ?></td>
                                            <td><?php echo $pro->recordObject->quantity  ?></td>
                                            <td><?php  echo Invoices::gettotalsold($invoicedate, $get->productid) ?></td>
                                        </tr>
                                    <?php }
                                    }
                                    ?>
                                </table>
                                <?php endif;  ?>
                            </div>
                        </div>
                    </div>


                </div><!--End Row-->
            </div>
        </div><!--End Row-->



        <!--End Dashboard Content-->

    </div>
    <!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->


<!--End Back To Top Button-->

<?php  require ("includes/footer.php"); ?>

