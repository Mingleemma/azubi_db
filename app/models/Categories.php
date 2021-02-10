<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/15/2019
 * Time: 6:50 AM
 */

class Categories extends tableDataObject
{
    const TABLENAME  = 'product_categories';

    public static function getCategoryCount(){
        global $connectedDb;
        $query = "select count(*) as ct  from product_categories ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();

    }

    public static function getCategoryData($page,$limit){
        global $connectedDb;
        $query = "select * from product_categories limit $page, $limit ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();

    }

    public static function getCategoryCountbyID($catid){
        global $connectedDb;
        $query = "select count(*) as ct  from product_categories where catid = $catid ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function getCategoryById($catid){
        global $connectedDb;
        $query = "select category  from product_categories where catid = $catid ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

}