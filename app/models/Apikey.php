<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 6/20/2019
 * Time: 11:21 AM
 */

class Apikey extends tableDataObject
{
    const  TABLENAME = 'apikeys';

    public static function getApiCount($apikey){
        global $connectedDb;
        $getdata = "SELECT count(*) as count from apikeys where apikey  = '$apikey' ";
        $connectedDb->prepare($getdata);
        return $connectedDb->fetchColumn();
    }



    public static function randomString($length = 8) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }


}