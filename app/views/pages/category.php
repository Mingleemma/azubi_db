<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<style>

    .table-responsive {
       display: block;
    }

</style>

    <div class="clearfix"></div>
    <div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-12">
                <h4 class="page-title">CATEGORY</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javaScript:void();">Inventory</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product Category</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">



                <form method="post">

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label">Category Name </label>

                        <div class="col-lg-8">
                            <input type="text" name="category" class="form-control"  />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label form-control-label"></label>
                        <div class="col-lg-8">
                            <input type="reset"   class="btn btn-secondary" value="Cancel">
                            <input name="addcategory" type="submit" class="btn btn-primary" value="Add Category">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-7">
                <?php if(isset($data['alert'])) { ?>

                    <div class="<?php echo $data['class'] ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <div class="alert-icon">
                            <i class="icon-info"></i>
                        </div>
                        <div class="alert-message">
                            <span><strong>Info!</strong> <?php  echo $data['message']    ?></span>
                        </div>
                    </div>
                <?php  }  ?>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped apptables display " width="100%" >
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category</th>
                                <th scope="col">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  foreach ($data['catdata'] as $key=>$get):   ?>
                                <tr>
                                    <td><?php  echo $key+1 ?></td>
                                    <td><?php echo $get->category  ?></td>
                                    <td><a href="#" class="deletecategory" catid="<?php echo $get->catid ?>">Delete</a></td>
                                </tr>
                            <?php  endforeach;  ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
        </div>


<?php  require ("includes/footer.php"); ?>