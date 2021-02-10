<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 4/12/2019
 * Time: 1:41 PM
 */

use \Firebase\JWT\JWT;

class RestApi
{

    public function  __construct()
    {

    }


    public function validateRequestMethod($apimethod){
        $serverRequest = $_SERVER['REQUEST_METHOD'];

        if($serverRequest != $apimethod){
            $this->throwErrror('METH_01', 'Request Method Not allowed', '');
        }

    }


    public function validateRequestParameters($fieldname, $value, $datatype, $required = true){

        if($required == true && empty($value) == true){
            $this->throwErrror( 'REQUIRED', REQUIRED ,  $fieldname);
        }

        switch ($datatype){
            CASE BOOLEAN:
                if(!is_bool($value)){
                    $this->throwErrror('MUST_BOOLEAN', MUST_BOOLEAN, $fieldname);
                }
                break;
            CASE INT:
                if(!is_numeric($value)){
                    $this->throwErrror('MUST_NUMERIC', MUST_NUMERIC, $fieldname);
                }
                break;
            CASE STRING:
                if(!is_string($value)){
                    $this->throwErrror('MUST_STRING', MUST_STRING, $fieldname);
                }
                break;

            default:
                $this->throwErrror('REQUIRED', REQUIRED ,  $fieldname);
                break;
        }

        return $value;
    }

    public function validateFieldNames($requirefieldnames, $fieldarray){

        foreach($requirefieldnames as $field){
            if(!in_array($field, $fieldarray)){
                $this->throwErrror(INCORRECT_FIELD_NAME, "Incorrect field names passed", implode($fieldarray, ','));
            }
        }
    }

    public function throwErrror($code, $message, $field){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('content-type: application/json');
        $errormsg  = ['error'=>["status"=>400, 'code'=>$code,  'message'=>$message, 'field'=>$field ]];
        echo json_encode($errormsg);
        exit;
    }



    public function returnResponse($data, $code=null){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('content-type: application/json');
        $responsemsg  = ['status'=>200, 'data'=>$data];
        echo json_encode($responsemsg);
    }




    // Get Authorization Token
    public function getAuthorizationHeader(){
        $headers = null;
        $apikey = null;

        if (isset($_SERVER['HTTP_APIKEY'])) {
           $apikey = trim($_SERVER['HTTP_APIKEY']);
        }else{
            $apikey = null;
        }

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();

            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return ['bearer'=> $headers, 'apikey'=>$apikey ];
    }


    // Get access token from header
    public function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        $apikey = $headers['apikey'];

        //Checking if api key exists
        $count = Apikey::getApiCount($apikey);
        if($count == 0 ){
            $this->throwErrror('AUT_03', AUT_03, 'apikey');
        }

        // HEADER: Get the access token from the header
        if (!empty($headers['bearer'])) {
            if (preg_match('/Bearer\s(\S+)/', $headers['bearer'], $matches)) {
                return  $matches[1];
            }
        }


        header('content-type: application/json');
        $errormsg  = ['error'=>["status"=>AUTHORIZATION_HEADER_NOT_FOUND,  'message'=>'Access Token Not Found']];
        echo json_encode($errormsg);
        exit;
    }

    public function getApikey() {
        $headers = $this->getAuthorizationHeader();
        $apikey = $headers['apikey'];

        //Checking if api key exists
        $count = Apikey::getApiCount($apikey);
        if($count == 0 ){
            $this->throwErrror('AUT_03', AUT_03, 'apikey');
        }

        return $apikey;
    }


    public function verifyToken($token){

        try{
            $payload  = JWT::decode($token, USER_KEY, ['HS256']);

            if(isset($payload->apikey_id)){
                return $payload;
            }else{
               $this->throwErrror(INVALID_AUTH_TOKEN, 'Invalid Authorization token', 'token');
            }
        }catch(Exception $e){
            $this->throwErrror(JWT_PROCESSING_ERROR,  $e->getMessage(), 'token' );
        }

    }


}