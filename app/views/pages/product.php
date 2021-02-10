<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title">Product Management</h4>
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
                        <label class="col-lg-4 col-form-label form-control-label">Product Name</label>
                        <div class="col-lg-8">
                            <input name="productname" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Quantity</label>
                        <div class="col-lg-8">
                            <input name="quantity"  class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Category</label>
                        <div class="col-lg-8">
                            <select class="form-control" name="categoryid" id="categoryid" required>
                                <option value="">Select a category</option>
                                <?php  foreach($data['catdata'] as $get):   ?>
                                <option value="<?php echo $get->catid . ':' .$get->category   ?>" catname="<?php echo $get->category   ?>"><?php echo $get->category   ?></option>
                                <?php endforeach;   ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Out Stock Limit</label>
                        <div class="col-lg-8">
                            <input name="outofstocklimit"  class="form-control" type="text" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Vendor</label>
                        <div class="col-lg-8">
                            <input name="vendor"  class="form-control" type="text" />
                        </div>
                    </div>


                    <div class="form-group row" >
                        <label class="col-lg-4 col-form-label form-control-label">No. of pieces</label>
                        <div class="col-lg-8">
                            <input name="packquantity" id="packquantity" class="form-control" type="text"  value=1>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Price Per piece</label>
                        <div class="col-lg-8">
                            <input name="saleprice"  class="form-control" type="text" value=1 required>
                        </div>
                    </div>

                    <div class="form-group row" >
                        <label class="col-lg-4 col-form-label form-control-label">Bulk Price</label>
                        <div class="col-lg-8">
                            <input name="packprice" id="packprice" class="form-control" type="text" >
                        </div>
                    </div>




                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Cost Price</label>
                        <div class="col-lg-8">
                            <input name="costprice"  class="form-control" type="text" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label"></label>
                        <div class="col-lg-8">
                            <input type="reset"   class="btn btn-secondary" value="Cancel">
                            <input name="adduser" type="submit" class="btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm table-striped table-responsive apptables">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Limit</th>
                                <th scope="col">Sale Price</th>
                                <th scope="col"><i class="fa fa-pencil"></i></th>
<!--                                <th scope="col"><i class="fa fa-trash-o"></i></th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php  foreach ($data['productdata'] as $key=>$get):   ?>
                                <tr>
                                    <th scope="row"><?php echo $key + 1  ?></th>
                                    <td><a href="<?php echo URLROOT.'/pages/editproduct/'.$get->productid  ?>"><?php  echo $get->productname ?></a></td>
                                    <td><?php  echo Categories::getCategoryById($get->catid);  ?></td>
                                    <td><?php  echo $get->quantity ?></td>
                                    <td><?php  echo $get->stocklimit ?></td>
                                    <td><?php  echo $get->saleprice ?></td>

                                    <td><a href="<?php echo URLROOT.'/pages/editproduct/'.$get->productid  ?>"><i class="fa fa-pencil"></i></a></td>
<!--                                    <td><a href="#" class="deletevproduct" productid="--><?php // echo $get->productid   ?><!--"><i class="fa fa-trash-o"></i></a></td>-->
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
