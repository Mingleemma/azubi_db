<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/15/2019
 * Time: 7:06 AM
 */

class Productcategories extends Controller
{
     public function listall(){

         $url = parse_url($_SERVER['REQUEST_URI']);

         if(isset($url['query'])) {
             parse_str($url['query'], $parameters);

             $page = isset($parameters['page']) ? $parameters['page'] : 1;
             $page = $page -1;
             $limit = isset($parameters['limit']) ? $parameters['limit'] : 20  ;
         }else{
             $page = 0;
             $limit = 20;
         }

         $rs = new RestApi();

         // Verify Apikey
         $rs->getApikey();

         //Getting Authorization token
         $token = $rs->getBearerToken();

         //Verifying Token
         $rs->verifyToken($token);

         //APi Functionality

         //Calling pagination class
         $pag = Pagination::paginate();
         $page = $pag['page'];
         $limit = $pag['limit'];
         $catdata = Categories::getCategoryData($page, $limit);


         $categorydata = [];
         foreach($catdata  as $get){
             $category = $get->category;
             $catid = $get->catid;

             $productcount = Product::getProductCategoryCount($catid);
             $categorydata [] = ['category'=>$category, 'catid'=>$catid, 'count'=>$productcount ];
         }

         $datacount = Categories::getCategoryCount();

         $data = ['categorydata'=>$categorydata, 'totalcount'=>$datacount];
         $rs->returnResponse($data);
     }


     public function details($catid = null){

         $rs = new RestApi();

         //Checking if category ID is null;
         if($catid == null){
             $rs->throwErrror('CAT_01', CAT_01, 'category ID');
         }

         //Checking if category ID exists;
         $count = Categories::getCategoryCountbyID($catid);
         if($count == 0){
             $rs->throwErrror('CAT_02', CAT_02, 'category ID');
         }


         // Verify Apikey
         $rs->getApikey();

         //Getting Authorization token
         $token = $rs->getBearerToken();

         //Verifying Token
         $rs->verifyToken($token);

         //APi Functionality

         $catdata = new Categories($catid);
         $data = $catdata->recordObject;
         $rs->returnResponse($data);
     }

    public function  delete($catid = null){

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


        //Checking if category ID is null;
        if($catid == null){
            $rs->throwErrror('CAT_01', CAT_01, 'category ID');
        }

        //Checking if category ID exists;
        $count = Categories::getCategoryCountbyID($catid);
        if($count == 0){
            $rs->throwErrror('CAT_02', CAT_02, 'category ID');
        }


        //Getting the actual Api method

        $us = new Categories($catid);
        $us->deleteFromDB();

        $data= ['message'=>'Caegory  successfully deleted', 'CategoryID'=>$catid];
        $rs->returnResponse($data);
    }





}