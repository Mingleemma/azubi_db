<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 4/13/2019
 * Time: 7:08 AM
 */

use \Firebase\JWT\JWT;

class JwtToken extends RestApi
{


    public function generateToken($apikey_id){

        $timecreated = time();
        $expiry = time() + (43200);
        $payload = [
            'iat'=> $timecreated,
            'iss'=> URLROOT,
            'exp'=> $expiry,
            'apikey_id'=> $apikey_id
        ];
        try {

            $token = JWT::encode($payload, USER_KEY);
            $data = ['accessToken' => $token, 'expires_in'=>'24h'];
            return $data;
        }catch (Exception $e){
            $this->throwErrror(AUT_02,  AUT_02, 'token' );
        }

    }






}