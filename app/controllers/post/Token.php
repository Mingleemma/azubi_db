<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 6/20/2019
 * Time: 11:17 AM
 */

class Token extends PostController
{
     public function index(){

         $jwt = new JwtToken();
         $rs  =  new RestApi();

         $handler = fopen('php://input',  'r');
         $data  = stream_get_contents($handler);
         $data = json_decode($data);

         $apikey = $data->apikey;

         $count = Apikey::getApiCount($apikey);

         if($count > 0 ){
             $tokenresposnse = $jwt->generateToken($apikey);
             $rs->returnResponse($tokenresposnse);

         }else{
             $rs->throwErrror('AUT_03', AUT_03, 'apikey');
         }
     }
}