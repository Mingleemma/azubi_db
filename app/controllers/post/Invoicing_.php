<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class Invoicing extends PostController
{

    public function index(){
        $from = date('Y-m-d', strtotime($_POST['from']));
        $to =   date('Y-m-d', strtotime($_POST['to']));;

        $paymentsearchdata = Payments::listAllPaymentstbyRange($from, $to);
        $data = ['paymentsearchdata'=>$paymentsearchdata];
        $this->view('pages/invoices', $data);
    }

    public function refund(){

        if(isset($_POST['processrefund'])){
            $invoiceid = $_POST['invoiceid'];
            $refundqty = $_POST['refundqty'];

            $total = 0;
            $discountamount = 0;
            $totaldiscount = 0;

            foreach($invoiceid  as  $key=>$invid){

                $refundquantity = $refundqty[$key];
                $data[] = ['rqty'=>$refundquantity, 'invid'=> $invid];
                if($refundquantity != '') {
                    $in = new Invoices($invid);

                    $productid = $in->recordObject->productid;
                    $invoicecode = $in->recordObject->invoicecode;
                    $invoicecdate = $in->recordObject->invoicedate;
                    $invqty = $in->recordObject->quantity;
                    $invoiceamount = $in->recordObject->amount;
                    $type = $in->recordObject->type;
                    // Payment information
                    $paydata = Payments::getPaymentsbyCode($invoicecode);
                    $discount = $paydata->discountpercent == 0 ? 0 : $paydata->discountpercent / 100;
                    $finalpayment = $paydata->finalamount;
                    $newquantity = $invqty - $refundquantity;
                    // $invoiceamount = $newquantity == 0 ? 0 :  $in->recordObject->amount;


                    //Checking if i item is a profile and calculating discount back
                    $pro = new Product($productid);
                    $catid = $pro->recordObject->catid;

                    $ca = new Categories($catid);
                    $category = $ca->recordObject->category;

                    if($category == 'Profiles'){
                        $discountamt = $discount  * $invoiceamount;
                        $discountamount = $discountamt * $refundquantity;
                        $totaldiscount = $discountamount + $totaldiscount;
                    }

                    $newamount = $invoiceamount + ($discount * $invoiceamount);
                    $total = $total + ($newamount * $refundquantity);
                    //Update new quantity
                    $in->recordObject->quantity = $newquantity;
                    $in->recordObject->refund = 1;
                    $in->store();

                    //Store refund History
                    $refundquantity = $refundquantity == '' ? 0 : $refundquantity;
                    $this->storeRefund($invid, $invoiceamount, $productid, $refundquantity,
                        $totaldiscount, $invoicecode, $finalpayment);
                    //product changes
                    $this->refundproductchanges($productid, $refundquantity, $type);
                }
            }

            //Update payments;
            $this->paymentchanges($invoicecode, $total, $totaldiscount);
            $invoicedata =  Invoices::getInvoiceBYCode($invoicecode);
            $refunddata = Refund::listAll();

            $historydata = Refund::getRefundDetails($invoicecode);

            $data = ['refunddata' => $refunddata, 'historydata'=>$historydata,
                'message'=>'Refund done Successfully'];
            $this->view('pages/refund', $data);
            exit;
        }

        if(isset($_POST['searchinvoice'])) {
            $invoicecode = trim($_POST['invoicecode']);
            $invoicedata = Invoices::getInvoiceBYCode($invoicecode);
            $refunddata = Refund::listAll();
            $data = ['invoiceitems' => $invoicedata, 'refunddata' => $refunddata];
            $this->view('pages/refund', $data);
            exit;
        }

    }

    private function totalamount($invoiceid){
        $total = 0;
        foreach($invoiceid as  $invid){
            $in  = new Invoices($invid);
            $amount = $in->recordObject->amount ;
            $quantity  = $in->recordObject->quantity ;
            $invamount = $quantity * $amount;
            $total = $total + $invamount;
        }

        return $total;
    }

    private function storeRefund($invoiceid, $amount, $productid, $quantity, $discount, $invoicecode, $paid){

        $rf = new Refund();
        $rf->recordObject->invoiceid = $invoiceid;
        $rf->recordObject->amount = $amount;
        $rf->recordObject->productid = $productid;
        $rf->recordObject->quantity = $quantity;
        $rf->recordObject->discount = $discount;
        $rf->recordObject->refunddate = date('Y-m-d');
        $rf->recordObject->invoicecode = $invoicecode;
        $rf->recordObject->paid = $paid;
        $rf->store();

    }

    private function paymentchanges($invoicecode, $total, $discount = null){
        $pro = Payments::getPaymentsbyCode($invoicecode);
        $payid = $pro->payid;

        $pay = new Payments($payid);
        $oldtotalamount = $pay->recordObject->amount;
        $oldfinalamount = $pay->recordObject->finalamount;
        $olddiscount  = $pay->recordObject->discount;

        $test = ['oldtotal'=> $oldtotalamount, 'oldfinal'=>$oldfinalamount, 'olddiscount'=>$olddiscount,
            'total'=> $total, 'discount'=> $discount];

        $newdiscount =   $olddiscount - $discount;
        $totalamount =   $oldtotalamount - $total;
        $finalamount =   $totalamount + $newdiscount;

        if($totalamount  <= 0){
            $totalamount = 0;
            $finalamount = 0;
            // $newdiscount = 0;
        }

        if($total == 0){
            $totalamount = 0;
            $finalamount = 0;
            $newdiscount = 0;
        }

        $pay->recordObject->amount = $totalamount + $newdiscount;
        $pay->recordObject->finalamount =  $finalamount + $newdiscount;
        $pay->recordObject->discount =  $newdiscount;
        $pay->store();
    }

    private function  productchanges($productid, $invqty, $type = null){
        $pro = new Product($productid);
        $oldquantity = $pro->recordObject->quantity;
        $oldoriginalqty = $pro->recordObject->originalquantity;
        $pieces =  $pro->recordObject->pieces;

        $newqty = $this->newquantity($type, $oldquantity, $invqty, $pieces, $productid);
        $neworigqty = $this->neworiginalquantity($type, $oldoriginalqty, $invqty, $pieces, $productid);

        //Update Quantity
        $pro->recordObject->quantity = $newqty;
        $pro->recordObject->originalquantity = $neworigqty;
        $pro->store();
    }

    private function  refundproductchanges($productid, $invqty, $type = null){
        $pro = new Product($productid);
        $oldquantity = $pro->recordObject->quantity;
        $oldoriginalqty = $pro->recordObject->originalquantity;
        $pieces =  $pro->recordObject->pieces;

        $newqty = $this->refundnewquantity($type, $oldquantity, $invqty, $pieces, $productid);
        $neworigqty = $this->refundneworiginalquantity($type, $oldoriginalqty, $invqty, $pieces, $productid);

        //Update Quantity
        $pro->recordObject->quantity = $newqty;
        $pro->recordObject->originalquantity = $neworigqty;
        $pro->store();
    }


    public function searchproduct(){
        $term =$_GET['term'];
        $prodata = Product::getProductByName($term);
        $productdata=[];
        foreach($prodata as $get){
            $productname = $get->productname;
            $productid = $get->productid;
            $productdata[] = array("productid"=>$productid,"productname"=>$productname);
        }
        echo json_encode($productdata);
    }

    public function create(){
        // ini_set('display_errors', false);
        if(isset($_POST['addcart'])) {
            $productid = $_POST['productid'];
            $cat = new Cartitems();
            $cat->recordObject->productid = $productid;
            $cat->recordObject->cartcode = $_SESSION['invoicecode'];
            if ($cat->store()) {
                $cartdata = Cartitems::getProductsBYCode($_SESSION['invoicecode']);
                $products = Product::listAll();
                $data = ['cartdata' => $cartdata, 'products'=>$products];
                $this->view('pages/createinvoice', $data);
                exit;
            }
        }

        if(isset($_POST['processcart'])) {
            $quantity = $_POST['quantity'];
            $productid = $_POST['productid'];
            $saleprice = $_POST['saleprice'];
            $type = $_POST['type'];
            $numberofpieces = $_POST['numberofpieces'];
            $pieceprice = $_POST['pieceprice'];
            // print_r($pieceprice);


            foreach($quantity as $key=>$qty){
                $id =  $productid[$key];
                $amount = $saleprice[$key];
                $ptype = $type[$key];
                $priceperpiece = $pieceprice[$key];
                $numpieces = $numberofpieces[$key];
                $amounttopay = 0;
                if($ptype == 'Full'){
                    $amounttopay = $amount;
                }elseif($ptype == 'Pieces'){
                    $amounttopay =  $priceperpiece;
                }
                $inv = new Invoices();
                $inv->recordObject->productid = $id;
                $inv->recordObject->quantity = $qty;
                $inv->recordObject->type = $ptype;
                $inv->recordObject->amount = $amounttopay;
                $inv->recordObject->invoicedate = date('Y-m-d');
                $inv->recordObject->invoicecode = $_SESSION['invoicecode'];
                $inv->recordObject->userid = $_SESSION['userid'];
                $inv->store();
            }
            $invociedata = Invoices::getInvoiceBYCode($_SESSION['invoicecode']);
            $products = Product::listAll();
            $data = ['invoicedata'=>$invociedata, 'products'=>$products];
            $this->view('pages/createinvoice', $data);

        }

        if(isset($_POST['processinvoice'])){

            $quantity = $_POST['quantity'];
            $productid = $_POST['productid'];
            $discount = $_POST['discount'];
            $total =  $_POST['total'];
            $optiontype = $_POST['optiontype'];
            $balance = $_POST['balance'];
            $amountpaid = $_POST['amountpaid'];
            $discountpercent = $discount == 0 ?  0 : ($discount / 100 ) * $total;
            $finalamount = $total - $discountpercent;
            $discountamount = $_POST['discountamount'];

            foreach($quantity as $key=>$qty) {
                $id = $productid[$key];
                $ptype = trim($optiontype[$key]);

                $pro = new Product($id);
                $oldquantity = $pro->recordObject->quantity;
                $pieces  = $pro->recordObject->pieces;
                $oldoriginalqty = $pro->recordObject->originalquantity;

                //Product updates
                $prodata[] = ['quantity'=>$oldquantity,  'productid' => $id, 'type'=>$ptype,
                    'originalquantity'=>$oldoriginalqty, 'newquantity'=>$qty, 'pieces'=>$pieces];
                $this->newquantity($ptype, $oldquantity, $qty, $pieces, $id);
                $this->neworiginalquantity($ptype, $oldoriginalqty, $qty, $pieces, $id);

            }

            //Inserting Payments;
            $this->payments($total, $finalamount,  $discountpercent, $discount);

            // Print Receipt
            $this->printReceipt($discountamount,  $finalamount, $balance,$amountpaid);

            unset($_SESSION['invoicecode']);

            header('Location:'.URLROOT.'/invoicing/create');
            // exit;
        }

        if(isset($_POST['cancelinvoice'])){

            $invoicecode = $_SESSION['invoicecode'];
            Invoices::deleteInvoiceByCode($invoicecode);
            unset($_SESSION['invoicecode']);

            header('Location:'.URLROOT.'/invoicing/create');
            exit;
        }
    }

    private function payments($amount, $finalamount, $discount, $discountpercent){
        //insert into  payments
        $pa = new Payments();
        $pa->recordObject->paydate = date('Y-m-d');
        $pa->recordObject->invoicecode =  $_SESSION['invoicecode'];
        $pa->recordObject->amount = $amount;
        $pa->recordObject->finalamount = $finalamount;
        $pa->recordObject->discount = $discount;
        $pa->recordObject->discountpercent = $discountpercent;
        $pa->recordObject->userid = $_SESSION['userid'];
        $pa->store();
    }


    public function printReceipt($discountpercent, $total, $balance = null, $amountpaid = null){

        $user = new User($_SESSION['userid']);
        $name = $user->recordObject->firstname;

        $invociedata = Invoices::getInvoiceBYCode($_SESSION['invoicecode']);

        try {
            // Enter the share name for your USB printer here
            $connector = new WindowsPrintConnector("POS-80-Series");
            $printer = new Printer($connector);
            $image = EscposImage::load(PUBLIC_PATH.'/logo.png', false);
            $printer -> bitImage($image);
            $printer -> setTextSize(2,2);
            $printer -> setEmphasis(true);
            $printer->text("OFFICIAL RECEIPT\n");
            $printer -> setTextSize(1,1);
            $printer -> setEmphasis(true);
            $printer->text("Cashier: " .strtoupper($name). "\n");
            $printer -> text("\n");
            $printer -> setTextSize(1, 1);
            $printer -> setEmphasis(false);
            $printer -> text("Receipt No:  ".$_SESSION['invoicecode']."\n");
            $printer -> text("Receipt Date:  ".date('Y-m-d')."\n");
            $printer -> text("\n");
            foreach($invociedata as $get){
                $pro = new Product($get->productid);
                $name = $pro->recordObject->productname;
                $printer -> text("Product: ".$name."\n");
                $printer -> text("Qty: ".$get->quantity." - ".$get->type. "\n");
                $printer -> text("Unit Price: ".$get->amount."\n");
                $printer -> text("Total Price: ".$get->amount * $get->quantity."\n");
                $printer -> text("\n");
            }
            $totalamt = $discountpercent + $total;
            $printer -> text("\n");
            $printer -> text("Total Amount: ".$totalamt."\n");
            $printer -> text("Discount: ".$discountpercent."\n");
            $printer -> text("Amount Received: ".$amountpaid."\n");
            $printer -> text("Change Given: ".$balance."\n");
            $printer -> setTextSize(2,1);
            $printer -> setEmphasis(true);
            $printer -> text("Total Paid: ".$total."\n");
            $printer -> setTextSize(1,1);

            $printer -> setEmphasis(false);
            $printer -> text("\n");
            $printer -> text("\n");
            $printer -> text("Powered by NM Aluminium. Tel: 0302959686\n");
            $printer -> text("\n");
            $printer -> text("\n");
            $printer -> cut();
            /* Close printer */
            $printer -> close();
        } catch(Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }

    private function newquantity($type, $oldquantity, $qty, $pieces, $productid = null){
        if($type == 'Full'){
            $newquantity = $oldquantity - $qty;
        }elseif($type == 'Pieces'){
            $newquantity = $oldquantity - ($qty/$pieces);
        }

        $p = new Product($productid);
        $p->recordObject->quantity = $newquantity;
        $p->store();

    }

    private function neworiginalquantity($type, $oldoriginalqty, $qty, $pieces, $productid = null){
        if($type === 'Full'){
            $neworiginalqty = $oldoriginalqty - ($qty * $pieces);
        }elseif($type === 'Pieces'){
            $neworiginalqty = $oldoriginalqty - $qty;
        }

        $p = new Product($productid);
        $p->recordObject->originalquantity = $neworiginalqty;
        $p->store();
    }

    private function refundnewquantity($type, $oldquantity, $qty, $pieces, $productid = null){
        if($type == 'Full'){
            $newquantity = $oldquantity + $qty;
        }elseif($type == 'Pieces'){
            $newquantity = $oldquantity + ($qty/$pieces);
        }

        $p = new Product($productid);
        $p->recordObject->quantity = $newquantity;
        $p->store();

    }

    private function refundneworiginalquantity($type, $oldoriginalqty, $qty, $pieces, $productid = null){
        if($type === 'Full'){
            $neworiginalqty = $oldoriginalqty + ($qty * $pieces);
        }elseif($type === 'Pieces'){
            $neworiginalqty = $oldoriginalqty + $qty;
        }

        $p = new Product($productid);
        $p->recordObject->originalquantity = $neworiginalqty;
        $p->store();
    }
}