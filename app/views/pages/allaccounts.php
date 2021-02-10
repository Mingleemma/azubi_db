<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .divToPrint, .divToPrint * {
            visibility: visible;
        }

    }
</style>


<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">


        <div class="row">
            <div class="col-lg-12">

            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                       Account Management
                        <a href="/account/accountspdf" class="btn btn-primary pull-right">Print Accounts</a>
                    </div>
                    <div class="table-responsive" id="ajaxcontainer">
                        <div class="divToPrint">
                        <table class="table table-bordered table-condensed align-items-center table-striped" style="font-size: 12px">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Account No:</th>
                                <th>Account Type </th>
                            </tr>
                            </thead>
                            <?php foreach ($data as $get):   ?>
                                <tr>
                                    <td><?php echo $get->accountname ?></td>
                                    <td><?php echo $get->accountnumber ?></td>
                                    <td><?php echo $get->accounttype ?></td>

                                </tr>
                            <?php  endforeach;  ?>

                        </table>
                        </div>
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
