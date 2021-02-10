<?php


class Refund extends  tableDataObject
{
    const TABLENAME = 'refund';

    public static function getRefundDetails($code){
        global $connectedDb;
        $query = "select * from refund where  invoicecode = '$code' ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }

    public static function getRefundDetailsToday($code){
        global $connectedDb;
        $today = date('Y-m-d');
        $query = "select * from refund where  invoicecode = '$code' and refunddate = '$today' ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }

    public static function getRundByCode($code){
        global $connectedDb;
        $query = "select  SUM(totalamount) AS total from refund where  invoicecode = '$code' and status = 1 ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function updateRefundstatus($code){
        global $connectedDb;
        $query = "UPDATE refund set status = 0 where invoicecode = '$code' and  status = 1 ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }


    public static function getTotalRefundToday(){
        $today = date('Y-m-d');
        global $connectedDb;
        $query = "select sum(totalamount) as total from refund where refunddate = '$today'";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function getTotalByInvoiceRefundToday(){
        $today = date('Y-m-d');
        global $connectedDb;
        $query = "select sum(totalamount) as total from refund where refunddate = '$today'
                  and invoicedate <> '$today' ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }
}