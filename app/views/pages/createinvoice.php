<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>
<style>
    tr, td {
        padding: 2px;
    }
    .optWrapper{
        width: 600px !important;

    }

    .SumoSelect>.optWrapper{
        position: relative !important;
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
                    <li class="breadcrumb-item"><a href="javaScript:void();">Invoices</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create a new Invoice</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div style="padding-left: 20px">Generate Invoice Code: <?php  echo $_SESSION['invoicecode']  ?>
                    <hr/>
                </div>
                <form method="post">
                    <table>
                        <tr>
                            <td width="80%">
                                <select class="form-control prod" name="productid" id="productid" required style="width: 600px;">
                                    <option value="">Select Product</option>
                                    <?php foreach($data['products'] as $get):   ?>
                                        <option value="<?php  echo $get->productid  ?>"><?php  echo $get->productname  ?></option>
                                    <?php  endforeach;   ?>
                                </select>
                            </td>
                            <td><button type="submit" href='#' name="addcart" style="color:#fff" class="btn  btn-warning pull-left">
                                    <i class = 'fa fa-plus'></i> Add Product </button></td>

                        </tr>
                    </table>
                </form>
                <br/>
                <div>
                    <?php if(isset($data['cartdata']) && count($data['cartdata'])> 0  ){
                        ?>
                       <form method="post">
                        <table class="table table-bordered table-condensed table-sm" style="font-size: 12px">
                            <tr style="font-weight: 700">
                                <td>Product </td>
                                <td>No. of Pieces</td>
                                <td>Price Per Piece</td>
                                <td>Bulk Price</td>
                                <td>Type</td>
                                <td>Quantity</td>
                                <td>Delete</td>
                            <tr>
                                <?php foreach ($data['cartdata'] as $get){
                                $pro =  new Product($get->productid);
                                ?>
                            <tr>
                                <td><?php  echo $pro->recordObject->productname  ?></td>
                                <td><?php  echo $pro->recordObject->pieces  ?></td>
                                <td><?php  echo $pro->recordObject->saleprice  ?></td>
                                <td><?php  echo $pro->recordObject->packprice  ?></td>
                                <td><select name="type[]">
                                        <option>Full</option>
                                        <option>Pieces</option>
                                    </select>
                                </td>
                                <td><input type="text" name="quantity[]" />
                                <input type="hidden" name="productid[]" value="<?php echo $get->productid;  ?>" />
                                    <input type="hidden" name="saleprice[]" value="<?php echo  $pro->recordObject->packprice   ?>" />
                                    <input type="hidden" name="numberofpieces[]" value="<?php echo  $pro->recordObject->pieces   ?>" />
                                    <input type="hidden" name="pieceprice[]" value="<?php echo  $pro->recordObject->saleprice  ?>" />
                                </td>
                                <td><a href="#" class="deletecart" cartid="<?php echo $get->catid  ?>">Delete</a></td>
                            </tr>
                            <tr>
                                <?php  };  ?>
                            <tr>
                                <td colspan="5"><button name="processcart" type="submit" class="btn btn-info pull-left btn-sm"><i class="fa fa-shopping-cart"></i>  Process card </button></td>
                            <tr>
                        </table>

                    <?php  }  ?>
                       </form>
                </div>

                <?php if(isset($data['invoicedata'])) { ?>
                    <div class="card" style="margin-top: 50px">
                        <div class="card-body">

                            <form method="post">
                                <table class="table table-bordered table-condensed table-sm" style="font-size: 12px">
                                    <tr style="font-weight: 700">
                                        <td>Product </td>
                                        <td>Type </td>
                                        <td>Quantity </td>
                                        <td>Amount</td>
                                        <td>Total</td>
                                    </tr>

                                        <?php
                                        $total = 0;
                                        foreach ($data['invoicedata'] as $get){
                                        $pro =  new Product($get->productid);
                                        $amt = $get->amount * $get->quantity;
                                        $total = $total + $amt;
                                        ?>
                                    <tr>
                                        <td><?php  echo $pro->recordObject->productname  ?></td>
                                        <td><?php  echo $get->type  ?></td>
                                        <td><?php  echo $get->quantity ?></td>
                                        <td><?php  echo $get->amount  ?></td>
                                        <td><?php  echo $get->amount * $get->quantity  ?>
                                            <input type="hidden" name="quantity[]"  value="<?php echo $get->quantity;?> "/>
                                            <input type="hidden" name="optiontype[]"  value="<?php echo $get->type;?> "/>
                                            <input type="hidden" name="productid[]" value="<?php echo $get->productid;  ?>" />

                                        </td>
                                    </tr>
                                    <?php  }  ?>

                                    <tr>
                                        <td colspan="3"></td>

                                        <td>Total</td>
                                        <td style="font-weight: 700; color: orangered"><?php  echo number_format($total,2);  ?>
                                            <input type="hidden" id="totalamount" name="total" value="<?php echo $total  ?>" />
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>

                                        <td>Discount</td>
                                        <td>
                                            <select class="form-control"  name="discount" id="discountval" invoicecode="<?php  echo  $_SESSION['invoicecode']  ?>">
                                                <option value="0">Select</option>
                                                <?php  for($i =0; $i<=100;  $i++ ){?>
                                                    <option><?php echo $i  ?></option>
                                                <?php  } ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"></td>

                                        <td>Discount Amount</td>
                                        <td> <input  class="form-control" style="font-size: 20px; font-weight: bold; color:blue" type="text" name="discountamount" id="discountamount" value="0" readonly /></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"></td>

                                        <td>Total After Discount</td>
                                        <td> <input class="form-control" style="font-size: 20px; font-weight: bold" type="text"
                                                    name="afterdiscount" id="afterdiscount"   readonly
                                                    value = '<?php echo number_format($total,2)  ?>' /></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"></td>

                                        <td>Amount Paid</td>
                                        <td> <input  class="form-control" style="font-size: 20px; font-weight: bold" type="text" name="amountpaid" id="amountpaid"
                                             /></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"></td>

                                        <td>Balancs:</td>
                                        <td> <input  class="form-control" style="font-size: 20px; font-weight: bold" type="text" name="balance" id="balance"  readonly/></td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">
                                            <button name="cancelinvoice" type="submit"
                                                    class="btn btn-danger pull-left btn-sm">
                                                <i class="fa fa-trash"></i>  Cancel Invoice </button>

                                            <button name="processinvoice" type="submit"
                                                                class="btn btn-success pull-right btn-sm">
                                                <i class="fa fa-print"></i>  Print Invoice </button></td>
                                    </tr>
                                </table>



                        </div>
                    </div>
                <?php  }  ?>

            </div>
            <div class="col-lg-5">

            </div>

        </div>
    </div>


    <?php  require ("includes/footer.php"); ?>
