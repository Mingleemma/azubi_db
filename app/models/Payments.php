<?php


class Payments extends tableDataObject
{

    const TABLENAME  = 'payments';

    public static function getTotalPayments(){
        global $connectedDb;
        $month = date('Y-m');
        $query = "select sum(finalamount) as total from payments where paydate like '%$month%'";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function getPaymentsbyCode($code){
        global $connectedDb;
        $query = "select * from   payments where invoicecode = '$code' ";
        $connectedDb->prepare($query);
        return $connectedDb->singleRecord();
    }

    public static function getTotalPaymentstoday(){
        global $connectedDb;
        $today = date('Y-m-d');
        $query = "select sum(finalamount) as total from payments where paydate = '$today' ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function listAllPaymentstoday(){
        global $connectedDb;
        $today = date('Y-m-d');
        $query = "select * from payments where paydate = '$today' ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }


    public static function listAllPaymentstbyRange($from, $to){
        global $connectedDb;
        $query = "select * from payments where paydate between '$from' and '$to' ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }

    public static function totalsales($from, $to){
        global $connectedDb;
        $query = "select sum(finalamount) as total  from payments where paydate between '$from' and '$to' ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

}