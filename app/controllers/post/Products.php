<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/15/2019
 * Time: 7:55 AM
 */

class Products extends PostController
{

    public function  add(){

        $rs = new RestApi();

        $requiredfieldnames = ['name','categoryid', 'vendorid', 'quantity', 'description',
                                'costprice', 'saleprice', 'code', 'userid'];

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $categoryid = isset($_POST['categoryid']) ? trim($_POST['categoryid']) : '';
        $vendorid = isset($_POST['vendorid']) ? trim($_POST['vendorid']) : '';
        $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $costprice = isset($_POST['costprice']) ? trim($_POST['costprice']) : '';
        $saleprice = isset($_POST['saleprice']) ? trim($_POST['saleprice']) : '';
        $code = isset($_POST['code']) ? trim($_POST['code']) : '';
        $userid = isset($_POST['userid']) ? trim($_POST['userid']) : '';

        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Verify Vendor ID
        $vencount  =  Vendor::getVendorCountById($vendorid);
        if($vencount == 0){
            $rs->throwErrror('VN_03', VN_03, 'Vendor ID' );
        }

        //Verify Category ID
        $procount = Categories::getCategoryCountbyID($categoryid);
        if($procount == 0){
            $rs->throwErrror('CAT_02', CAT_02, 'category ID');
        }

        $pro = new Product();
        $prodata =& $pro->recordObject;
        $prodata->productname = $name;
        $prodata->vid = $vendorid;
        $prodata->catid = $categoryid;
        $prodata->quantity = $quantity;
        $prodata->description = $description;
        $prodata->costprice = $costprice;
        $prodata->saleprice = $saleprice;
        $prodata->productcode = $code;
        $prodata->datesupplied = date('Y-m-d');
        $prodata->userid = $userid;
        if($pro->store()){
             $productid = $pro->recordObject->productid;
             $usercount = User::companyUserCountByUid($userid);
             if($usercount > 0){
                 $cid = User::getCompanyIdFromCompanyUsers($userid);
                 Product::insertCompanyProducts($cid, $productid);

             }
            $data = ['message'=>'Product seccessfully  added', 'productid'=>$productid ];
            $rs->returnResponse($data);

        }

    }

    public function  update($productid = null){

        $rs = new RestApi();

        $requiredfieldnames = ['name','categoryid', 'vendorid', 'quantity', 'description', 'costprice',
                                'saleprice', 'code', 'userid'];

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $categoryid = isset($_POST['categoryid']) ? trim($_POST['categoryid']) : '';
        $vendorid = isset($_POST['vendorid']) ? trim($_POST['vendorid']) : '';
        $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $costprice = isset($_POST['costprice']) ? trim($_POST['costprice']) : '';
        $saleprice = isset($_POST['saleprice']) ? trim($_POST['saleprice']) : '';
        $code = isset($_POST['code']) ? trim($_POST['code']) : '';
        $userid = isset($_POST['userid']) ? trim($_POST['userid']) : '';

        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

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

        //Verify Vendor ID
        $vencount  =  Vendor::getVendorCountById($vendorid);
        if($vencount == 0){
            $rs->throwErrror('VN_03', VN_03, 'Vendor ID' );
        }

        //Verify Category ID
        $procount = Categories::getCategoryCountbyID($categoryid);
        if($procount == 0){
            $rs->throwErrror('CAT_02', CAT_02, 'category ID');
        }

        $pro = new Product($productid);
        $prodata =& $pro->recordObject;
        $prodata->productname = $name;
        $prodata->vid = $vendorid;
        $prodata->catid = $categoryid;
        $prodata->quantity = $quantity;
        $prodata->description = $description;
        $prodata->datesupplied = date('Y-m-d');
        $prodata->costprice = $costprice;
        $prodata->saleprice = $saleprice;
        $prodata->productcode = $code;
        $prodata->userid = $userid;
        if($pro->store()){
            $prodata = $pro->recordObject;
            $data = ['message'=>'Product successfuly updated', 'productdata'=>$prodata ];
            $rs->returnResponse($data);

        }
    }


    public function updatequantity(){

        $rs = new RestApi();

        $requiredfieldnames = ['productid', 'userid', 'quantity'];


        $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
        $productid = isset($_POST['productid']) ? trim($_POST['productid']) : '';
        $userid = isset($_POST['userid']) ? trim($_POST['userid']) : '';

        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        $pro = new Producthistory();
        $prodata =& $pro->recordObject;
        $prodata->productid = $productid;
        $prodata->quantity = $quantity;
        $prodata->historydate = date('Y-m-d');
        $prodata->userid = $userid;
        if($pro->store()){

            $data = ['message'=>'Product qunatity  seccessfully  added', 'productid'=>$productid ];
            $rs->returnResponse($data);

        }

    }



}