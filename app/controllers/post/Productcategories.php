<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/15/2019
 * Time: 6:51 AM
 */

class Productcategories extends PostController
{
     public function add($userid = null){

         $rs = new RestApi();

         $requiredfieldnames = ['category'];

         $category  = isset($_POST['category']) ? trim($_POST['category']) : '';


         //Checking if user ID is null;
         if($userid == null){
             $rs->throwErrror('USR_O8', USR_08, 'userid');
         }

         //Checking valid user ID
         $usercount = User::getUserCountbyUserID($userid);
         if($usercount == 0){
             $rs->throwErrror('USR_07', USR_07, 'userid');
         }

         $postfields = (array_keys($_POST));

         //Validating the fieldnames in the method
         $rs->validateFieldNames($requiredfieldnames, $postfields);

         // Verify Apikey
         $rs->getApikey();

         //Getting Authorization token
         $token = $rs->getBearerToken();

         //Verifying Token
         $rs->verifyToken($token);

         //APi Functionality

         $ct  = new Categories();
         $ct->recordObject->category = $category;
         $ct->recordObject->userid = $userid;
         $ct->recordObject->dateadded = date('Y-m-d');
         if($ct->store()){
             $catid =  $ct->recordObject->catid;
             $data = ['message'=> 'Product category successfully added', 'categoryid'=>$catid];
             $rs->returnResponse($data);
         }

     }

    public function update($catid = null){

        $rs = new RestApi();

        $requiredfieldnames = ['category'];

        $category  = isset($_POST['category']) ? trim($_POST['category']) : '';


        //Checking if category ID is null;
        if($catid == null){
            $rs->throwErrror('CAT_01', CAT_01, 'category ID');
        }

        //Checking if category ID exists;
        $count = Categories::getCategoryCountbyID($catid);
        if($count == 0){
            $rs->throwErrror('CAT_02', CAT_02, 'category ID');
        }

        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //APi Functionality

        $ct  = new Categories($catid);
        $ct->recordObject->category = $category;
        if($ct->store()){
            $catdata =  $ct->recordObject;
            $data = ['message'=> 'Product category successfully added', 'categorydata'=>$catdata];
            $rs->returnResponse($data);
        }

    }
}