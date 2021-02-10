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
                    <li class="breadcrumb-item"><a href="javaScript:void();">Search  </a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search Invoice</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div style="padding-left: 20px">Search Invoice
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

                        <table class="table table-bordered table-condensed table-striped table-sm" style="font-size: 12px">
                            <tr style="font-weight: 700">
                                <td>Product </td>
                                <td>Description </td>
                                <td>Price</td>
                                <td>Quantity</td>
                            </tr>
                                <?php foreach ($data['invoiceitems'] as $get){
                                $pro =  new Product($get->productid);
                                ?>
                            <tr>
                                <td><?php  echo $pro->recordObject->productname  ?></td>
                                <td><?php  echo $pro->recordObject->description  ?></td>
                                <td><?php  echo $get->amount  ?></td>
                                <td><?php  echo $get->quantity  ?></td>
                            </tr>
                                <?php  };  ?>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td><?php  echo $data['paymentdata']->amount  ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td><?php  echo $data['paymentdata']->discount  ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                             <tr>
                                <td>Amount Paid</td>
                                <td><?php echo $data['paymentdata']->finalamount ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>



                        <?php  }  ?>

                </div>



            </div>
            <div class="col-lg-5">

            </div>

        </div>
    </div>


    <?php  require ("includes/footer.php"); ?>

