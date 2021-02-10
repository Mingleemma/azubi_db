<?php


class Search extends PostController
{
     public function  index(){

         $invoicecode = $_POST['invoicecode'];
         $invoicedata = Invoices::getInvoiceBYCode($invoicecode);
         $paymentdata = Payments::getPaymentsbyCode($invoicecode);
         $data = ['invoiceitems'=>$invoicedata,  'paymentdata'=>$paymentdata];
         $this->view('pages/search', $data);
     }
}