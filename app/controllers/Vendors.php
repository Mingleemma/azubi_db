<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/15/2019
 * Time: 7:46 AM
 */

class Vendors extends Controller
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
        $vendordata = Vendor::getVendordata($page, $limit);

        //Get Vendor Count
        $vendorcount = Vendor::getVendorCount();

        $data = ['vendors'=>$vendordata,  'totalcount'=> $vendorcount ];

        $rs->returnResponse($data);

    }


    public function details($vid = null)
    {
        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Checking if  vendor ID is null;
        if($vid  == null){
            $rs->throwErrror('VN_O2', VN_02, 'vendor ID');
        }

        //Verify if vendor ID is valid
        $count  =  Vendor::getVendorCountById($vid);
        if($count == 0){
            $rs->throwErrror('VN_03', VN_03, 'Vendor ID');
        }

        //Getting the actual Api method
        $us = new Vendor($vid);
        $vendordata = $us->recordObject;

        $rs->returnResponse($vendordata);

    }


    public function  delete($vid = null){

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


        //Checking if  vendor ID is null;
        if($vid  == null){
            $rs->throwErrror('VN_O2', VN_02, 'vendor ID');
        }

        //Verify if vendor ID is valid
        $count  =  Vendor::getVendorCountById($vid);
        if($count == 0){
            $rs->throwErrror('VN_03', VN_03, 'Vendor ID');
        }

        //Getting the actual Api method

        $us = new Vendor($vid);
        $us->deleteFromDB();

        $data= ['message'=>'Vendor successfully deleted', 'VendorID'=>$vid];
        $rs->returnResponse($data);
    }

}