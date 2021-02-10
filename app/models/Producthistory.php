<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 12/16/2019
 * Time: 11:06 AM
 */

class Producthistory extends  tableDataObject
{
     const TABLENAME  = 'producthistory';

    public static function getHistoryById($productid){
        global $connectedDb;
        $query = "select *   from producthistory where productid = $productid ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();

    }
}