<?php


class Invoices extends tableDataObject
{
   const TABLENAME = 'invoices';

    public static function getInvoiceBYCode($code){
        global $connectedDb;
        $query = "select * from invoices where  invoicecode = '$code'  ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }

    public static function getpurchasestoday(){
        global $connectedDb;
        $today = date('Y-m-d');
        $query = "select * from invoices where  invoicedate = '$today' group by productid  ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }

    public static function getpurchaseoRange($from,  $to){
        global $connectedDb;
        $today = date('Y-m-d');
        $query = "select * from invoices where  (invoicedate between '$from' and '$to') group by productid  ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }

    public static function gettotalsold($invoicedate, $productid){
        global $connectedDb;
        $query = "SELECT sum(quantity)  AS qty   FROM invoices WHERE invoicedate = '$invoicedate' 
                 and productid =$productid ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function gettotalsoldbyRange($from,  $to , $productid){
        global $connectedDb;
        $query = "SELECT sum(quantity)  AS qty   FROM invoices WHERE (invoicedate between '$from' and '$to')
                 and productid = $productid ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function deleteInvoiceByCode($code){
        global $connectedDb;
        $query = "Delete from invoices where  invoicecode = '$code'  ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }

    public static function getInvoiceByProductId($productid){
        global $connectedDb;
        $query = "SELECT * from invoices  WHERE productid =$productid ";
        $connectedDb->prepare($query);
        return $connectedDb->singleRecord();
    }


}