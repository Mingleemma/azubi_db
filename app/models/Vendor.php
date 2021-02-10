<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/15/2019
 * Time: 7:28 AM
 */

class Vendor extends tableDataObject
{
   const TABLENAME = 'vendors';

    public static function getVendorCountByEmail($email){
        global $connectedDb;
        $query = "select count(*) as emailcount  from vendors where email  = '$email'  ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function getVendorCountById($vid){
        global $connectedDb;
        $query = "select count(*) as ct  from vendors where vid  = $vid  ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function getVendorCount(){
        global $connectedDb;
        $query = "select count(*) as ct  from vendors ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function getVendordata($page, $limit){
        global $connectedDb;
        $query = "select * from vendors limit $page, $limit ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }



}