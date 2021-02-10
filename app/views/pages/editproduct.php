<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title"><?php  echo $data['productdata']->productname  ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add a New Product</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">

                <form method="post">
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Product</label>
                        <div class="col-lg-8">
                            <input name="productname" class="form-control" type="text"
                                   value="<?php  echo $data['productdata']->productname  ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Quantity</label>
                        <div class="col-lg-8">
                            <input name="quantity"  class="form-control" type="text" readonly
                                   value="<?php  echo $data['productdata']->quantity  ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Stock Limit</label>
                        <div class="col-lg-8">
                            <input name="outofstocklimit"  class="form-control" type="text"
                                   value="<?php  echo $data['productdata']->stocklimit ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Category</label>
                        <div class="col-lg-8">
                            <select class="form-control" name="categoryid" readonly >
                                <option value="<?php echo $data['productdata']->catid  ?>">
                                    <?php  echo Categories::getCategoryById($data['productdata']->catid) ?></option>
                                <option value="">Select a category</option>
                                <?php  foreach($data['catdata'] as $get):   ?>
                                    <option value="<?php echo $get->catid ?>"><?php echo $get->category   ?></option>
                                <?php endforeach;   ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Vendor</label>
                        <div class="col-lg-8">
                            <input name="vendor"  value="<?php echo $data['productdata']->vendor ?>" class="form-control" type="text" >
                        </div>
                    </div>

                    <div class="form-group row" >
                        <label class="col-lg-4 col-form-label form-control-label">No. of pieces</label>
                        <div class="col-lg-8">
                            <input name="packquantity" id="packquantity" class="form-control" type="text"
                                   value="<?php echo $data['productdata']->pieces ?>" readonly
                            >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Price Per piece</label>
                        <div class="col-lg-8">
                            <input name="saleprice"  class="form-control" type="text" required
                                   value="<?php echo $data['productdata']->saleprice ?>"
                            />
                        </div>
                    </div>

                    <div class="form-group row" >
                        <label class="col-lg-4 col-form-label form-control-label">Bulk Price</label>
                        <div class="col-lg-8">
                            <input name="packprice" id="packprice" class="form-control" type="text"
                                   value="<?php echo $data['productdata']->packprice ?>"
                            >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Cost Price</label>
                        <div class="col-lg-8">
                            <input name="costprice"  value="<?php echo $data['productdata']->costprice ?>" class="form-control" type="text" required>
                        </div>
                    </div>




                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label"></label>
                        <div class="col-lg-8">
                            <input name='productid' type="hidden" value="<?php  echo $data['productdata']->productid  ?>" />
                            <input type="reset"   class="btn btn-secondary" value="Cancel">
                            <input name="editproduct" type="submit" class="btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <form method="post">
                        <table>
                            <tr>
                                <td colspan="2"><h3>RE-STOCK PRODUCT</h3></td>
                            </tr>
                            <tr>
                                <td><input name='rsquantity' class="form-control" type="text"  placeholder="Enter Quantity" required/>
                                    <input name='productid' class="form-control" type="hidden" value="<?php  echo $data['productdata']->productid  ?>" />
                                </td>
                                <td><input name="restock" type="submit" class="btn btn-primary" value="re-stock"></td>
                                <td><input name="deletestock" type="submit" class="btn btn-danger" value="Remove stock"></td>
                            </tr>
                        </table>
                        </form>
                        <br/>

                        <span style="font-size: 14px; font-weight:700">Product History Logs</span>

                        <table class="table table-bordered table-striped">
                            <tr>
                                <td>Quantity</td>
                                <td>Description</td>
                                <td>Date Changed</td>
                            </tr>
                            <?php foreach($data['historydata'] as $get):  ?>
                            <tr>
                                <td><?php echo $get->quantity    ?></td>
                                <td><?php echo $get->description   ?></td>
                                <td><?php echo $get->historydate;    ?></td>
                            </tr>
                            <?php  endforeach;  ?>


                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <?php  require ("includes/footer.php"); ?>
