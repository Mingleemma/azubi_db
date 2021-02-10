<?php

class Pages extends Controller{


    public function dashboard(){
        new Guard();
        $today  = date('Y-m-d');
        $allproducts = Invoices::getpurchasestoday();
        $productcount = Product::getProductCount();
        $outofstock = Product::getoutofstockcount();
        $totalpayments = Payments::getTotalPayments();
        $totalpaymentstoday = Payments::getTotalPaymentstoday();

        $totalrefundtoday = Refund::getTotalByInvoiceRefundToday();
        $totaltoday = $totalpaymentstoday - $totalrefundtoday;

        $outofstockdata = Product::listoutofstockcount();
        $paymentstoday = Payments::listAllPaymentstoday();
        //$refundtoday  = Payments::listAllPaymentstoday();

        $paymentstodaytotal  = $totalpaymentstoday -  $totalrefundtoday;


        $data = ['products'=>$allproducts,  'productcount'=>$productcount, 'outofstock'=>$outofstock,
                 'totalpayments'=>$totalpayments, 'totalpaymentstoday'=>$paymentstodaytotal,
                 'outofstockdata'=>$outofstockdata, 'paymentstoday'=>$paymentstoday
                 ];

        $this->view( 'pages/index', $data);
    }

    public function advancedstock(){
        new Guard();
        new RoleGuard('Report');
            $today = date('Y-m-d');
            $allproducts = Invoices::getpurchasestoday();
            $productcount = Product::getProductCount();
            $outofstock = Product::getoutofstockcount();
            $totalpayments = Payments::getTotalPayments();
            $totalpaymentstoday = Payments::getTotalPaymentstoday();
            $totalrefundtoday = Refund::getTotalRefundToday();
            $totaltoday = $totalpaymentstoday - $totalrefundtoday;
            $outofstockdata = Product::listoutofstockcount();
            $paymentstoday = Payments::listAllPaymentstoday();

            $data = ['products' => $allproducts, 'productcount' => $productcount, 'outofstock' => $outofstock,
                'totalpayments' => $totalpayments, 'totalpaymentstoday' => $totaltoday,
                'outofstockdata' => $outofstockdata, 'paymentstoday' => $paymentstoday
            ];
            $this->view('pages/advancedstock', $data);
    }


    public function categories(){
        new Guard();
        new RoleGuard('Add Categories');
        $catdata =  Categories::listAll();
        $data = [ 'catdata'=>$catdata ];
        $this->view('pages/category', $data );
    }

    public function products(){
        new Guard();
        new RoleGuard('Add Products');
        $catdata =  Categories::listAll();
        $productdata = Product::listAll();
        $data = [ 'catdata'=>$catdata,  'productdata' => $productdata];
        $this->view('pages/product', $data );
    }

    public function editproduct($productid){

        new Guard();
        new RoleGuard('Edit Products');
        $pro = new Product($productid);
        $productdata = $pro->recordObject;
        $catdata =  Categories::listAll();
        $historydata = Producthistory::getHistoryById($productid);
        $data = ['productdata' => $productdata, 'catdata'=>$catdata, 'historydata'=>$historydata];
        $this->view('pages/editproduct', $data );
    }



    public function users(){
        new Guard();
        new RoleGuard('Create User');
        $users = User::listAll();
        $data = ['users'=>$users];
        $this->view( 'pages/users', $data);
    }



    public function index(){
        $this->view( 'pages/login');
    }


    public function logout(){
        session_unset($_SESSION['userid']);
        header('Location:'.URLROOT.'/pages');
    }

    public function edituser($uid){

        new Guard();
        new RoleGuard('Configure User');
        $userdata  = new User($uid);
        $userdata  = $userdata->recordObject;
        $roledata  = Roles::getGroupedRoles();
        $userrolesdata = User::getRolesByuid($uid);
        $udata = ['userdata'=>$userdata, 'roledata'=>$roledata, 'userroledata'=>$userrolesdata];
        $this->view('pages/edituser', $udata);

    }


}



?>
