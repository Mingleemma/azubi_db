<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/15/2019
 * Time: 7:30 AM
 */

class Vendors extends PostController {

    public function add(){

        $rs = new RestApi();

        $requiredfieldnames = ['name','email', 'telephone', 'city', 'street', 'country', 'zipcode'];

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
        $city = isset($_POST['city']) ? trim($_POST['city']) : '';
        $country = isset($_POST['country']) ? trim($_POST['country']) : '';
        $street = isset($_POST['street']) ? trim($_POST['street']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $zipcode = isset($_POST['zipcode']) ? trim($_POST['zipcode']) : '';


        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Verify if email exits
        $count  =  Vendor::getVendorCountByEmail($email);
        if($count > 0){
            $rs->throwErrror('VN_01', VN_01, 'email' );
        }

        $newCompany = new Vendor();
        $newCompanyObject =& $newCompany->recordObject;
        $newCompanyObject->vendorname = $name;
        $newCompanyObject->email = $email;
        $newCompanyObject->telephone = $telephone;
        $newCompanyObject->date_created = date('Y-m-d');
        $newCompanyObject->street = $street;
        $newCompanyObject->city = $city;
        $newCompanyObject->country = $country;
        $newCompanyObject->postalcode = $zipcode;

        if($newCompany->store()){
            $vid = $newCompany->recordObject->vid;
            $data = ['message'=>' seccessfully created', 'vendorid'=>$vid];
            $rs->returnResponse($data);
        }

    }

    public function update($vid = null){

        $rs = new RestApi();

        $requiredfieldnames = ['name','email', 'telephone', 'city', 'street', 'country', 'zipcode'];

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
        $city = isset($_POST['city']) ? trim($_POST['city']) : '';
        $country = isset($_POST['country']) ? trim($_POST['country']) : '';
        $street = isset($_POST['street']) ? trim($_POST['street']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $zipcode = isset($_POST['zipcode']) ? trim($_POST['zipcode']) : '';


        $postfields = (array_keys($_POST));

        //Checking if category ID is null;
        if($vid == null){
            $rs->throwErrror('VN_02', VN_02, 'Vendor ID');
        }

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Verify if vendor ID is valid
        $count  =  Vendor::getVendorCountById($vid);
        if($count == 0){
            $rs->throwErrror('VN_03', VN_03, 'Vendor ID' );
        }

        $newCompany = new Vendor($vid);
        $newCompanyObject =& $newCompany->recordObject;
        $newCompanyObject->vendorname = $name;
        $newCompanyObject->email = $email;
        $newCompanyObject->telephone = $telephone;
        $newCompanyObject->date_created = date('Y-m-d');
        $newCompanyObject->street = $street;
        $newCompanyObject->city = $city;
        $newCompanyObject->country = $country;
        $newCompanyObject->postalcode = $zipcode;

        if($newCompany->store()){
            $vendordata = $newCompany->recordObject;
            $data = ['message'=>' seccessfully created', 'vendordata'=>$vendordata];
            $rs->returnResponse($data);
        }

    }



}