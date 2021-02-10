<?php
class Pages extends PostController {

    public function index(){

        if(isset($_POST['login'])){

            $email = $_POST['email'];
            $password = $_POST['password'];

            $usercount = User:: checkUserCredentials($email, $password);

            if($usercount > 0){
                $info = User::userinfo($email);
                $userid = $info->uid;
                $_SESSION['userid'] = $userid;
                header('Location:' . URLROOT . '/pages/dashboard');
            }else{
                $message = ['message'=>'Incorrect email or password'];
                $this->view('pages/login', $message);
                exit;
            }
        }else{
            $this->view('pages/login');
            exit;
        }

    }

    public function categories(){

        $category = $_POST['category'];
        $cat  =  new Categories();
        $cat->recordObject->category = $category;
        $cat->recordObject->userid = $_SESSION['userid'];
        if($cat->store()){
            $catdata = Categories::listAll();
            $data = ['catdata' => $catdata, 'response' => 'Category successfully addded',
                     'class' => 'alert alert-success'];
            $this->view('pages/category', $data);
        }

    }

        public function advancedstock(){
            new RoleGuard('Report');
            if(isset($_POST['searchstock'])) {
                $from =  date('Y-m-d', strtotime($_POST['from']));
                $to = date('Y-m-d', strtotime($_POST['to']));
                $today = date('Y-m-d');
                $allproducts = Invoices::getpurchaseoRange($from,  $to);
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
                    'outofstockdata' => $outofstockdata, 'paymentstoday' => $paymentstoday, 'from'=>$from,
                    'to'=>$to
                ];
                $this->view('pages/advancedstock', $data);
            }

    }

    public function products(){

        $productname = isset($_POST['productname']) ? trim($_POST['productname']) : '';
        $categoryid = isset($_POST['categoryid']) ? trim($_POST['categoryid']) : '';
        $vendor = isset($_POST['vendor']) ? trim($_POST['vendor']) : '';
        $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $costprice = isset($_POST['costprice']) ? trim($_POST['costprice']) : '';
        $saleprice = isset($_POST['saleprice']) ? trim($_POST['saleprice']) : '';
        $packprice =  isset($_POST['packprice']) ? trim($_POST['packprice']) : '';
        $packquantity =  isset($_POST['packquantity']) ? trim($_POST['packquantity']) : '';
        $outofstocklimit =  isset($_POST['outofstocklimit']) ? trim($_POST['outofstocklimit']) : '';

        $catvalues = explode(':',$categoryid);
        $catid = $catvalues[0];
        $category = $catvalues[1];

        $originalquantity = $packquantity * $quantity;

        $pro = new Product();
        $prodata =& $pro->recordObject;
        $prodata->productname = $productname;
        $prodata->vendor = $vendor;
        $prodata->catid = $catid;
        $prodata->quantity = $quantity;
        $prodata->description = $description;
        $prodata->packprice = $packprice;
        $prodata->originalquantity = $originalquantity;
        $prodata->costprice = $costprice;
        $prodata->saleprice = $saleprice;
        $prodata->pieces = $packquantity;
        $prodata->stocklimit = $outofstocklimit;
        $prodata->datesupplied = date('Y-m-d');
        $prodata->userid = 1;

        if($pro->store()){
            $catdata =  Categories::listAll();
            $productdata = Product::listAll();
            $data = [ 'catdata'=>$catdata,  'productdata' => $productdata];
            $this->view('pages/product', $data );
        }
    }

    public function editproduct(){

        if(isset($_POST['restock'])){

            new RoleGuard('Re-stock Product');

            $productid = $_POST['productid'];
            $rsquantity = $_POST['rsquantity'];
            $ph = new Producthistory();
            $ph->recordObject->productid = $productid;
            $ph->recordObject->quantity = $rsquantity;
            $ph->recordObject->description = 'Added Stock';
            $ph->recordObject->historydate = date('Y-m-d');
            $ph->recordObject->userid = $_SESSION['userid'];
            if ($ph->store()) {
                $pro = new Product($productid);
                $pdata = $pro->recordObject;
                $oldqty = $pdata->quantity;
                $oldpieces = $pdata->pieces;
                $newquantity = $rsquantity + $oldqty;
                $originalquantity =   $newquantity  * $oldpieces;

                //Update Product new quantity
                $pro->recordObject->quantity = $newquantity;
                $pro->recordObject->originalquantity = $originalquantity;

                if ($pro->store()) {
                    $catdata = Categories::listAll();
                    $historydata = Producthistory::getHistoryById($productid);
                    $productdata = $pro->recordObject;
                    $data = ['productdata' => $productdata, 'catdata' => $catdata, 'historydata' => $historydata];
                    $this->view('pages/editproduct', $data);
                    exit;
                }
            }
        }

        if(isset($_POST['deletestock'])){

            new RoleGuard('Remove Product');

            $productid = $_POST['productid'];
            $rsquantity = $_POST['rsquantity'];
            $ph = new Producthistory();
            $ph->recordObject->productid = $productid;
            $ph->recordObject->quantity = $rsquantity;
            $ph->recordObject->description = 'Removed Stock';
            $ph->recordObject->historydate = date('Y-m-d');
            $ph->recordObject->userid = $_SESSION['userid'];
            if ($ph->store()) {
                $pro = new Product($productid);
                $pdata = $pro->recordObject;
                $oldqty = $pdata->quantity;
                $oldpieces = $pdata->pieces;
                $newquantity =  $oldqty - $rsquantity;
                $originalquantity =   $newquantity  * $oldpieces;

                //Update Product new quantity
                $pro->recordObject->quantity = $newquantity;
                $pro->recordObject->originalquantity = $originalquantity;

                if ($pro->store()) {
                    $catdata = Categories::listAll();
                    $historydata = Producthistory::getHistoryById($productid);
                    $productdata = $pro->recordObject;
                    $data = ['productdata' => $productdata, 'catdata' => $catdata, 'historydata' => $historydata];
                    $this->view('pages/editproduct', $data);
                    exit;
                }
            }
        }

        if(isset($_POST['editproduct'])){
            $productname = isset($_POST['productname']) ? trim($_POST['productname']) : '';
            $categoryid = isset($_POST['categoryid']) ? trim($_POST['categoryid']) : '';
            $vendor = isset($_POST['vendor']) ? trim($_POST['vendor']) : '';
            $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $costprice = isset($_POST['costprice']) ? trim($_POST['costprice']) : '';
            $saleprice = isset($_POST['saleprice']) ? trim($_POST['saleprice']) : '';
            $packprice =  isset($_POST['packprice']) ? trim($_POST['packprice']) : '';
            $packquantity =  isset($_POST['packquantity']) ? trim($_POST['packquantity']) : '';
            $outofstocklimit =  isset($_POST['outofstocklimit']) ? trim($_POST['outofstocklimit']) : '';
            $productid = $_POST['productid'];

            $pro = new Product($productid);
            $prodata =& $pro->recordObject;
            $prodata->productname = $productname;
            $prodata->vendor = $vendor;
            $prodata->catid = $categoryid;
            $prodata->description = $description;
            $prodata->costprice = $costprice;
            $prodata->saleprice = $saleprice;
            $prodata->packprice = $packprice;
            $prodata->stocklimit = $outofstocklimit;
            if($pro->store()){
                $catdata = Categories::listAll();
                $historydata = Producthistory::getHistoryById($productid);
                $productdata = $pro->recordObject;
                $data = ['productdata' => $productdata, 'catdata' => $catdata, 'historydata' => $historydata];
                $this->view('pages/editproduct', $data);
                exit;
            }


        }
    }

    public function users(){

        if(isset($_POST['adduser'])){

            $usercount = User::getUserCountByEmail($_POST['email']);
            if($usercount == 0){
                $userdata = new User();
                $datarow =&  $userdata->recordObject;
                $datarow->telephone = $_POST['telephone'];
                $datarow->email = $_POST['email'];
                $datarow->lastname = $_POST['lastname'];
                $datarow->firstname =  $_POST['firstname'];
                $datarow->role =  $_POST['role'];
                $datarow->password = User::passwordMD5($_POST['password']);
                $datarow->datecreated = date('Y-m-d');
                if($userdata->store()) {
                    $uid = $userdata->recordObject->uid;
                    //$this->insertuserrole($uid, $_POST['role']);
                    $users = User::listAll();
                    $data = ['users' => $users, 'response' => 'User successfully addded',
                        'class' => 'aler alert-success'];
                    $this->view('pages/users', $data);
                }
            }else{
                $users = User::listAll();
                $data = ['users'=>$users, 'response'=>'Error adding User. Email may exist already',
                          'class'=>'alert alert-danger' ];
                $this->view( 'pages/users', $data);
            }
        }
    }


    public function edituser(){
        new Guard();
        //new RoleGuard('Add User Roles');
        if(isset($_POST['updateuser'])){

            $userid = $_POST['userid'];
            $userdata  = new User($userid);
            $userdata  = $userdata->recordObject;
            $roledata  = Roles::getGroupedRoles();
            $userrolesdata = User::getRolesByuid($userid );

            if($_POST['password'] != $_POST['confirmpassword']) {
                $udata = ['userdata'=>$userdata, 'roledata'=>$roledata, 'message'=>'Both Password must match',
                          'alert'=> 'alert alert-danger', 'userrolesdata'=>$userrolesdata ];
                $this->view('users/edituser', $udata);
                exit;
            }

            $us  = new User($userid);
            $us->recordObject->username = $_POST['email'];
            $us->recordObject->password = md5($_POST['password']);
            //$us->recordObject->role = $_POST['role'];
            $us->recordObject->firstname = $_POST['firstname'];
            $us->recordObject->lastname = $_POST['lastname'];
            $us->recordObject->telephone = $_POST['telephone'];
            $us->store();
            $roledata  = Roles::getGroupedRoles();
            $userrolesdata = User::getRolesByuid($userid);
            $udata = ['userdata'=>$userdata, 'message'=>'User passord successfully set',
                      'alert'=> 'alert alert-success', 'roledata'=>$roledata, 'userroledata'=>$userrolesdata];
            $this->view('pages/edituser',  $udata);
            exit;
        }

        if(isset($_POST['addroles'])){
            //Insert User roles
            $userid = $_POST['userid'];
            $role = $_POST['role'];
            foreach($role as $roles){
                $rowcount = User::getRoleCount($userid, $roles);
                if($rowcount == 0) {
                    User::insertUserRoles($userid, $roles);
                }
            }

            $roledata  = Roles::getGroupedRoles();
            $userrolesdata = User::getRolesByuid($userid);

            $userdata  = new User($userid);
            $userdata  = $userdata->recordObject;

            $udata = ['userdata'=>$userdata, 'message'=>'Roles Successfully Added',
                'alert'=> 'alert alert-success', 'roledata'=>$roledata, 'userroledata'=>$userrolesdata];
            $this->view('pages/edituser',  $udata);
            exit;
        }


    }





    private function insertuserrole($uid, $roleid){
        User::insertUserRoles($uid, $roleid);
    }




}
