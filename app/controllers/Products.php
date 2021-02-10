<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/15/2019
 * Time: 8:26 AM
 */

class Products extends Controller
{
      public function listall(){

          $rs = new RestApi();

          // Verify Apikey
          $rs->getApikey();

          //Getting Authorization token
          $token = $rs->getBearerToken();

          //Verifying Token
          $rs->verifyToken($token);

          //Calling pagination class
          $pag = Pagination::paginate();
          $page = $pag['page'];
          $limit = $pag['limit'];

          //Getting the actual Api method
          $productdata = Product::getProductData($page, $limit);


          //Get Product Count
          $productcount = Product::getProductCount();


          $prodata = [];

          foreach($productdata as $pro){

              $productname = $pro->productname;
              $productid = $pro->productid;
              $catid  = $pro->catid;
              $vid = $pro->vid;
              $quantity = $pro->quantity;
              $datesupplied = $pro->datesupplied;
              $saleprice = $pro->saleprice;
              $costprice = $pro->costprice;
              $description = $pro->description;
              $code = $pro->productcode;


              $vendorname = '';
              $categoryname = '';


              // Get Vendor Data

              $vencount = Vendor::getVendorCountById($vid);
              if($vencount > 0){
                  $ven = new Vendor($vid);
                  $vendorname = isset($ven->recordObject->vendorname) ? $ven->recordObject->vendorname : '' ;
              }
              $catcount = Categories::getCategoryCountbyID($catid);
              if($catcount > 0){
                  // Get Category Data
                  $cat = new Categories($catid);
                  $categoryname = isset($cat->recordObject->category) ?  $cat->recordObject->category : '';
              }




              $prodata[] = ['productname'=>$productname, 'quantity'=>$quantity, 'datesupplied'=>$datesupplied,
                  'vendor'=>$vendorname, 'category'=>$categoryname, 'productid'=>$productid,
                  'vendorid'=>$vid, 'categoryid'=>$catid, 'saleprice'=>$saleprice, 'costprice'=>$costprice,
                  'description'=>$description, 'code'=>$code];
          }

          $data = ['products'=>$prodata, 'totalcount'=>$productcount];

          $rs->returnResponse($data);
      }

    public function details($productid = null)
    {
        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);


        //Check if product ID is null
        if($productid == null){
            $rs->throwErrror('PRO_02', PRO_02, 'Product ID' );
        }

        //Check if product ID is valid
        $procount = Product::getProductCountById($productid);
        if($procount == 0){
            $rs->throwErrror('PRO_01', PRO_01, 'Product ID' );
        }

        //Getting the actual Api method

        $pro = new Product($productid);
        $productname = $pro->recordObject->productname;
        $datesupplied = $pro->recordObject->datesupplied;
        $quantity = $pro->recordObject->quantity;
        $catid  = $pro->recordObject->catid;
        $vid = $pro->recordObject->vid;
        $description = $pro->recordObject->description;
        $saleprice = $pro->recordObject->saleprice;
        $costprice = $pro->recordObject->costprice;
        $productcode = $pro->recordObject->productcode;

        // Get Vendor Data
        $ven = new Vendor($vid);
        $vendorname = $ven->recordObject->vendorname;

        // Get Category Data
        $cat = new Categories($catid);
        $categoryname = $cat->recordObject->category;

        $prodata = ['productname'=>$productname, 'quantity'=>$quantity, 'datesupplied'=>$datesupplied,
            'vendor'=>$vendorname, 'category'=>$categoryname, 'productid'=>$productid,
            'vendorid'=>$vid, 'categoryid'=>$catid, 'saleprice'=>$saleprice, 'costprice'=>$costprice,
            'description'=>$description, 'code'=>$productcode];

        $rs->returnResponse($prodata);

    }



    public function user($userid = null)
    {
        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);


        //Checking if user ID is null;
        if($userid == null){
            $rs->throwErrror('USR_O8', USR_08, 'userid');
        }

        //Check if user Id Exists;
        $usercount = User::getUserCountbyUserID($userid);
        if($usercount == 0) {
            $rs->throwErrror('USR_O7', USR_07, 'userid');
        }

        //Getting the actual Api method

        $productdata = Product::getProductByUserID($userid);

        $prodata = [];

        foreach($productdata as $pro){

            $productname = $pro->productname;
            $productid = $pro->productid;
            $catid  = $pro->catid;
            $vid = $pro->vid;
            $quantity = $pro->quantity;
            $datesupplied = $pro->datesupplied;
            $saleprice = $pro->saleprice;
            $costprice = $pro->costprice;
            $description = $pro->description;
            $code = $pro->productcode;


            $vendorname = '';
            $categoryname = '';


            // Get Vendor Data

            $vencount = Vendor::getVendorCountById($vid);
            if($vencount > 0){
                $ven = new Vendor($vid);
                $vendorname = isset($ven->recordObject->vendorname) ? $ven->recordObject->vendorname : '' ;
            }
            $catcount = Categories::getCategoryCountbyID($catid);
            if($catcount > 0){
                // Get Category Data
                $cat = new Categories($catid);
                $categoryname = isset($cat->recordObject->category) ?  $cat->recordObject->category : '';
            }




            $prodata[] = ['productname'=>$productname, 'quantity'=>$quantity, 'datesupplied'=>$datesupplied,
                'vendor'=>$vendorname, 'category'=>$categoryname, 'productid'=>$productid,
                'vendorid'=>$vid, 'categoryid'=>$catid, 'saleprice'=>$saleprice, 'costprice'=>$costprice,
                'description'=>$description, 'code'=>$code];
        }

        $data = ['products'=>$prodata];

        $rs->returnResponse($data);

    }

    public function code($productcode = null)
    {
        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);


        //Check if product ID is null
        if($productcode == null){
            $rs->throwErrror('PRO_02', PRO_02, 'Product Code' );
        }

        //Check if product ID is valid
        $procount = Product::getProductCodeCountById($productcode);
        if($procount == 0){
            $rs->throwErrror('PRO_05', PRO_05, 'Product Code' );
        }

        //Getting the actual Api method

        $pro = Product::getProductByCode($productcode);
        $productname = $pro->productname;
        $datesupplied = $pro->datesupplied;
        $quantity = $pro->quantity;
        $catid  = $pro->catid;
        $vid = $pro->vid;
        $description = $pro->description;
        $saleprice = $pro->saleprice;
        $costprice = $pro->costprice;
        $productcode = $pro->productcode;
        $productid = $pro->productid;

        // Get Vendor Data
        $ven = new Vendor($vid);
        $vendorname = $ven->recordObject->vendorname;

        // Get Category Data
        $cat = new Categories($catid);
        $categoryname = $cat->recordObject->category;

        $prodata = ['productname'=>$productname, 'quantity'=>$quantity, 'datesupplied'=>$datesupplied,
            'vendor'=>$vendorname, 'category'=>$categoryname, 'productid'=>$productid,
            'vendorid'=>$vid, 'categoryid'=>$catid, 'saleprice'=>$saleprice, 'costprice'=>$costprice,
            'description'=>$description, 'code'=>$productcode];

        $rs->returnResponse($prodata);

    }


    public function companyproducts($companyid = null){

        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Calling pagination class
        $pag = Pagination::paginate();
        $page = $pag['page'];
        $limit = $pag['limit'];

        //Checking if companyod is null;
        if($companyid == null){
            $rs->throwErrror('CM_O1', CM_01, 'company ID');
        }
        //Check if Company Id Exists;
        $usercount = Company::checkCompanyexists($companyid);
        if($usercount == 0) {
            $rs->throwErrror('CM_02', CM_02, 'company ID');
        }


        //Getting the actual Api method
        $productdata = Product::getCompanyProductData($companyid, $page, $limit);


        //Get Product Count
        $productcount = Product:: getCompanyProductCount($companyid);


        $prodata = [];

        foreach($productdata as $pro){

            $productname = $pro->productname;
            $productid = $pro->productid;
            $catid  = $pro->catid;
            $vid = $pro->vid;
            $quantity = $pro->quantity;
            $datesupplied = $pro->datesupplied;
            $saleprice = $pro->saleprice;
            $costprice = $pro->costprice;
            $description = $pro->description;
            $productcode = $pro->productcode;

            $vendorname = '';
            $categoryname = '';


            // Get Vendor Data

            $vencount = Vendor::getVendorCountById($vid);
            if($vencount > 0){
                $ven = new Vendor($vid);
                $vendorname = isset($ven->recordObject->vendorname) ? $ven->recordObject->vendorname : '' ;
            }
            $catcount = Categories::getCategoryCountbyID($catid);
            if($catcount > 0){
                // Get Category Data
                $cat = new Categories($catid);
                $categoryname = isset($cat->recordObject->category) ?  $cat->recordObject->category : '';
            }




            $prodata[] = ['productname'=>$productname, 'quantity'=>$quantity, 'datesupplied'=>$datesupplied,
                'vendor'=>$vendorname, 'category'=>$categoryname, 'productid'=>$productid,
                'vendorid'=>$vid, 'categoryid'=>$catid, 'saleprice'=>$saleprice, 'costprice'=>$costprice,
                'description'=>$description, 'code'=>$productcode];
        }

        $data = ['products'=>$prodata, 'totalcount'=>$productcount];

        $rs->returnResponse($data);
    }


    public function  delete($productid = null){

        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        $method = $_SERVER['REQUEST_METHOD'];

        if($method !== 'DELETE') {
            $rs->throwErrror('REQUEST_METHOD_NOT_VALID', 'Request method not allowed', 'Request Method');
        }

        //Check if product ID is null
        if($productid == null){
            $rs->throwErrror('PRO_02', PRO_02, 'Product ID' );
        }

        //Check if product ID is valid
        $procount = Product::getProductCountById($productid);
        if($procount == 0){
            $rs->throwErrror('PRO_01', PRO_01, 'Product ID' );
        }

        //Getting the actual Api method

        $us = new Product($productid);
        $us->deleteFromDB();


        //Delete company products id any
        Product::deleteCompanyProducts($productid);

        $data= ['message'=>'Product successfully deleted', 'ProductID'=>$productid];
        $rs->returnResponse($data);
    }



    public function history($productid){

        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);


        //Getting the actual Api method
        $productdata = Producthistory::getHistoryById($productid);

        $prodata = [];
        $vendorname = '';
        $categoryname = '';

        foreach($productdata as $pro){


            $productid = $pro->productid;
            $quantity = $pro->quantity;
            $userid = $pro->userid;
            $datehistory =  $pro->historydate;
            $historyid =  $pro->hid;


            $pr = new Product($productid);
            $vid = $pr->recordObject->vid;
            $catid = $pr->recordObject->catid;
            $productname = $pr->recordObject->productname;

            $vencount = Vendor::getVendorCountById($vid);
            if($vencount > 0){
                $ven = new Vendor($vid);
                $vendorname = isset($ven->recordObject->vendorname) ? $ven->recordObject->vendorname : '' ;
            }
            $catcount = Categories::getCategoryCountbyID($catid);
            if($catcount > 0){
                // Get Category Data
                $cat = new Categories($catid);
                $categoryname = isset($cat->recordObject->category) ?  $cat->recordObject->category : '';
            }

            $prodata[] = ['productname'=>$productname, 'quantity'=>$quantity, 'historydate'=>$datehistory,
                'vendor'=>$vendorname, 'category'=>$categoryname, 'productid'=>$productid,
                'vendorid'=>$vid, 'categoryid'=>$catid, 'hid'=>$historyid];
        }

        $data = ['historydata'=>$prodata];

        $rs->returnResponse($data);
    }

    public function category($categoryid=null){

        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Calling pagination class
        $pag = Pagination::paginate();
        $page = $pag['page'];
        $limit = $pag['limit'];

        //Getting the actual Api method



        //Getting the actual Api method
        $productdata = Product::getProductsByCategoryId($categoryid, $page, $limit);
        $productcount = Product::getProductsByCategoryIdCount($categoryid);

        $prodata = [];
        $vendorname = '';
        $categoryname = '';

        foreach($productdata as $pro){

            $productid = $pro->productid;
            $quantity = $pro->quantity;
            $userid = $pro->userid;
            $productname = $pro->productname;
            $vid = $pro->vid;
            $catid = $pro->catid;
            $datesupplied = $pro->datesupplied;
            $productcode = $pro->productcode;

            $vencount = Vendor::getVendorCountById($vid);
            if($vencount > 0){
                $ven = new Vendor($vid);
                $vendorname = isset($ven->recordObject->vendorname) ? $ven->recordObject->vendorname : '' ;
            }
            $catcount = Categories::getCategoryCountbyID($catid);
            if($catcount > 0){
                // Get Category Data
                $cat = new Categories($catid);
                $categoryname = isset($cat->recordObject->category) ?  $cat->recordObject->category : '';
            }

            $prodata[] = ['productname'=>$productname, 'quantity'=>$quantity,
                'vendor'=>$vendorname, 'category'=>$categoryname, 'productid'=>$productid,
                'vendorid'=>$vid, 'categoryid'=>$catid, 'datesupplied'=>$datesupplied, 'productcode'=>$productcode];
        }

        $data = ['products'=>$prodata, 'totalcount'=>$productcount];

        $rs->returnResponse($data);
    }

    public function categorybyuser($categoryid=null, $userid = null){

        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Calling pagination class
        $pag = Pagination::paginate();
        $page = $pag['page'];
        $limit = $pag['limit'];


        //Getting the actual Api method
        $productdata = Product::getProductsByCategoryIdByUser($categoryid,$userid, $page, $limit);
        $productcount = Product::getProductsByCategoryIdByUserCount($categoryid, $userid);

        $prodata = [];
        $vendorname = '';
        $categoryname = '';

        foreach($productdata as $pro){

            $productid = $pro->productid;
            $quantity = $pro->quantity;
            $userid = $pro->userid;
            $productname = $pro->productname;
            $vid = $pro->vid;
            $catid = $pro->catid;
            $datesupplied = $pro->datesupplied;
            $productcode = $pro->productcode;

            $vencount = Vendor::getVendorCountById($vid);
            if($vencount > 0){
                $ven = new Vendor($vid);
                $vendorname = isset($ven->recordObject->vendorname) ? $ven->recordObject->vendorname : '' ;
            }
            $catcount = Categories::getCategoryCountbyID($catid);
            if($catcount > 0){
                // Get Category Data
                $cat = new Categories($catid);
                $categoryname = isset($cat->recordObject->category) ?  $cat->recordObject->category : '';
            }

            $prodata[] = ['productname'=>$productname, 'quantity'=>$quantity,
                'vendor'=>$vendorname, 'category'=>$categoryname, 'productid'=>$productid,
                'vendorid'=>$vid, 'categoryid'=>$catid, 'datesupplied'=>$datesupplied,
                'productcode'=>$productcode];
        }

        $data = ['products'=>$prodata, 'totalcount'=>$productcount];

        $rs->returnResponse($data);
    }

    public function categorybycompany($categoryid =null, $companyid = null){

        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);
        //Calling pagination class
        $pag = Pagination::paginate();
        $page = $pag['page'];
        $limit = $pag['limit'];

        //Getting the actual Api method
        $productdata = Product::getProductsByCategoryIdByCompany($categoryid,$companyid, $page, $limit);
        $productcount = Product::getProductsByCategoryIdByCompanyCount($categoryid,$companyid);

        $prodata = [];
        $vendorname = '';
        $categoryname = '';

        foreach($productdata as $pro){

            $productid = $pro->productid;
            $quantity = $pro->quantity;
            $userid = $pro->userid;
            $productname = $pro->productname;
            $vid = $pro->vid;
            $catid = $pro->catid;
            $datesupplied = $pro->datesupplied;
            $productcode = $pro->productcode;

            $vencount = Vendor::getVendorCountById($vid);
            if($vencount > 0){
                $ven = new Vendor($vid);
                $vendorname = isset($ven->recordObject->vendorname) ? $ven->recordObject->vendorname : '' ;
            }
            $catcount = Categories::getCategoryCountbyID($catid);
            if($catcount > 0){
                // Get Category Data
                $cat = new Categories($catid);
                $categoryname = isset($cat->recordObject->category) ?  $cat->recordObject->category : '';
            }

            $prodata[] = ['productname'=>$productname, 'quantity'=>$quantity,
                'vendor'=>$vendorname, 'category'=>$categoryname, 'productid'=>$productid,
                'vendorid'=>$vid, 'categoryid'=>$catid, 'datesupplied'=>$datesupplied,
                'productcode'=>$productcode];
        }



        $data = ['products'=>$prodata, 'totalcount'=>$productcount];

        $rs->returnResponse($data);
    }




}