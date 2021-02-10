<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 6/6/2019
 * Time: 4:11 PM
 */

class Api{

    // This is a curl get function to be reused for all curl get request
    public  static function curlGetRequest($url, $token, $authorization, $return_array = true){

        //try catch block here
        try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            if($authorization == true){
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array('Accept:application/json',
                        'api-version: 2015-03-31',
                        'Authorization:'.$token)
                );
            }


            $response = curl_exec($ch);

            if (!$response){
                throw new frameworkError('API request Error');
            }
            else{
                $check = isValidXML($response);
                if($check == 'Valid'){
                    return $response;
                }else{
                    $response = preg_replace('/[^(\x20-\x7F)]*/','',$response);
                    $output = json_decode($response,$return_array);
                    return $output;
                }

            }


        }
        catch (frameworkError $fe){
            // echo $fe->getMessage();
        }


    }


// This is a curl post function to be reused for all curl post request
    public static function curlPatchRequest($url, $data, $authorization, $token, $requestheader){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if($authorization == true){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $requestheader);
        }
        return $response = curl_exec($ch);

    }



}