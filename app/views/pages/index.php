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
                                    <h4 class="text-info"><?php echo $data['productcount']  ?></h4>
                                    <span>Total Products</span>
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
                                    <h4 class="text-danger"><?php echo $data['outofstock']  ?></h4>
                                    <span>Total Out of Stock</span>
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
                                    <h4 class="text-success"><?php echo number_format($data['totalpayments'],2)  ?></h4>
                                    <span>Total Sales</span>
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
                                    <h4 class="text-warning"><?php echo number_format($data['totalpaymentstoday'],2)  ?></h4>
                                    <span>Today's Sales</span>
                                </div>
                                <div class="align-self-center w-circle-icon rounded bg-warning shadow-warning">
                                    <i class="icon-diamond text-white"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row">
                        <div class="col-8">
                         Products Purchase Today
                        </div>
                        <div class="col-4">
                            <a href="/pages/advancedstock"> Advanced Search</a>
                        </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-success table-striped">
                            <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Qty in Stock </th>
                                <th>Qty Sold</th>
                            </tr>
                            </thead>
                            <?php foreach ($data['products'] as $get):
                                $pro = new Product($get->productid);
                                $invoicedate = date('Y-m-d');
                                ?>
                                <tr>
                                    <td><?php echo $pro->recordObject->productname ?></td>
                                    <td><?php echo  Categories::getCategoryById($pro->recordObject->catid ); ?></td>
                                    <td><?php echo $pro->recordObject->quantity  ?></td>
                                    <td><?php  echo Invoices::gettotalsold($invoicedate, $get->productid) ?></td>
                                </tr>
                            <?php  endforeach;  ?>



                        </table>
                    </div>
                </div>
            </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            Out of Stock Products
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-danger table-striped">
                                <thead>
                                <tr style="font-weight: bold">
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Quantity </th>
                                    <th>Cost Price</th>

                                </tr>
                                </thead>
                                <?php foreach ($data['outofstockdata'] as $get):   ?>
                                    <tr>
                                        <td><?php echo $get->productname ?></td>
                                        <td><?php echo  Categories::getCategoryById($get->catid); ?></td>
                                        <td><?php echo $get->quantity ?></td>
                                        <td><?php echo $get->costprice ?></td>
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
