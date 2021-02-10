<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>
<style>
    tr, td{
        padding: 2px;
    }
</style>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title">Invoicing</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">Refund </a></li>
                    <li class="breadcrumb-item active" aria-current="page">Refund Invoice</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <div style="padding-left: 20px">Search Invoice to Refund
                    <hr/>
                </div>
                <form method="post">
                    <table>
                        <tr>
                            <td width="80%">
                                <input class="form-control" placeholder="Enter Invoice / Receipt Number" name="invoicecode" id="invoicecode"/>
                            </td>
                            <td><button type="submit" href='#' name="searchinvoice" style="color:#fff" class="btn  btn-warning pull-left">
                                    <i class = 'fa fa-search'></i> Search Invoice</button></td>

                        </tr>
                    </table>
                </form>
                <br/>
                <div>
                    <?php if(isset($data['invoiceitems']) && count($data['invoiceitems'])> 0  ){ ?>
                    <form method="post">
                        <table class="table table-bordered table-condensed table-sm" style="font-size: 12px">
                            <tr style="font-weight: 700">
                                <td><input type="hidden" /></td>
                                <td>Product </td>
                                <td>Description </td>
                                <td>Price</td>
                                <td>Quantity</td>
                                <td>Refund Qty</td>

                            <tr>
                                <?php foreach ($data['invoiceitems'] as $get){
                                $productcount = Product::getProductCountById($get->productid);
                                if($productcount > 0){
                                $pro = new Product($get->productid);
                                ?>
                            <tr>
                                <td><input type="hidden" name="invoiceid[]" value="<?php echo $get->invoiceid ?>"/></td>
                                <td><?php echo $pro->recordObject->productname ?></td>
                                <td><?php echo $get->type ?></td>
                                <td><?php echo $get->amount ?></td>
                                <td><?php echo $get->quantity ?></td>
                                <td><input type="text" name="refundqty[]"/></td>
                            </tr>
                            <tr>
                                <?php
                                   }
                                };
                                ?>
                            <tr>
                                <td colspan="4"><button name="processrefund" type="submit" class="btn btn-danger pull-left btn-sm"><i class="fa fa-shopping-cart"></i>  Process Refund </button></td>
                            <tr>
                        </table>

                        <?php  }  ?>
                    </form>
                </div>

                <?php if(isset($data['message'])) { ?>
                    <div class="card" style="margin-top: 50px">
                        <div class="card-body">
                           <?php  echo $data['message'];  ?>
                        </div>
                    </div>
                <?php  }  ?>


            </div>
            <div class="col-lg-7">
               <table class="table table-bordered table-sm apptables" style="font-size: 12px">
                   <thead>
                   <tr>
                       <td>Code</td>
                       <td>Product</td>
                       <td>Quantity</td>
                       <td>Refund Amt</td>
                       <td>Inv Amt</td>
                       <td>Date</td>
                   </tr>
                   </thead>
                   <?php  foreach($data['refunddata'] as $get){
                   $productcount = Product::getProductCountById($get->productid);
                        if($productcount > 0) {
                            $p = new Product($get->productid);
                            $finalpaydata = Payments::getPaymentsbyCode($get->invoicecode);
                            $pay = isset($finalpaydata->finalamount) ? $finalpaydata->finalamount : 0;
                            ?>
                            <tr>
                                <td><?php echo $get->invoicecode ?></td>
                                <td><?php echo $p->recordObject->productname ?></td>
                                <td><?php echo $get->quantity ?></td>
                                <td><?php echo($get->amount * $get->quantity) ?></td>
                                <td><?php echo $pay ?></td>
                                <td><?php echo $get->refunddate ?></td>

                            </tr>
                            <?php
                        }

                        }  ?>

               </table>
            </div>

        </div>
    </div>


    <?php  require ("includes/footer.php"); ?>
