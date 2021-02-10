<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/14/2019
 * Time: 12:57 PM
 */

class Companyaccounts extends PostController
{
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
        $count  =  Company::getCompanyCountByEmail($email);
        if($count > 0){
            $rs->throwErrror('USR_04', USR_04, 'email' );
        }

        $newCompany = new Company();
        $newCompanyObject =& $newCompany->recordObject;
        $newCompanyObject->companyname = $name;
        $newCompanyObject->email = $email;
        $newCompanyObject->telephone = $telephone;
        $newCompanyObject->date_created = date('Y-m-d');
        $newCompanyObject->street = $street;
        $newCompanyObject->city = $city;
        $newCompanyObject->country = $country;
        $newCompanyObject->postalcode = $zipcode;

        if($newCompany->store()){

            $cmid = $newCompany->recordObject->cmid;

             $data = ['message'=>'Company seccessfully created', 'companyid'=>$cmid];
             $rs->returnResponse($data);

        }

    }


    public function update($cmid = null){

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

        //Checking if user ID is null;
        if($cmid  == null){
            $rs->throwErrror('CM_O1', CM_01, 'company ID');
        }


        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        $newCompany = new Company($cmid);
        $newCompanyObject =& $newCompany->recordObject;
        $newCompanyObject->companyname = $name;
        $newCompanyObject->email = $email;
        $newCompanyObject->telephone = $telephone;
        $newCompanyObject->date_created = date('Y-m-d');
        $newCompanyObject->street = $street;
        $newCompanyObject->city = $city;
        $newCompanyObject->country = $country;
        $newCompanyObject->postalcode = $zipcode;

        if($newCompany->store()){

            $cmid = $newCompany->recordObject;

            $data = ['message'=>'Company seccessfully created', 'companydata'=>$cmid];
            $rs->returnResponse($data);

        }

    }




}