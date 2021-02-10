<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class Invoicing extends PostController
{

    public function index(){
        new RoleGuard('Report');
        $from = date('Y-m-d', strtotime($_POST['from']));
        $to =   date('Y-m-d', strtotime($_POST['to']));;

        $paymentsearchdata = Payments::listAllPaymentstbyRange($from, $to);
        $totalsales = Payments::totalsales($from, $to);
        $data = ['paymentsearchdata'=>$paymentsearchdata, 'totalsales'=>$totalsales];
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
                    $invqty = $in->recordObject->quantity;
                    $invoiceamount = $in->recordObject->amount;
                    $invoicedate = $in->recordObject->invoicedate;
                    $type = $in->recordObject->type;

                    // Payment information
                    $paydata = Payments::getPaymentsbyCode($invoicecode);
                    $discount = $paydata->discountpercent == 0 ? 0 : $paydata->discountpercent / 100;
                    $finalpayment = $paydata->finalamount;
                    $newquantity = $invqty - $refundquantity;

                    //Checking if i item is a profile and calculating discount back
                    $pro = new Product($productid);
                    $catid = $pro->recordObject->catid;

                    $ca = new Categories($catid);
                    $category = $ca->recordObject->category;
                    if($category == 'Profiles'){
                        $discountamt = $discount  * $invoiceamount;
                        $discountamount = $discountamt * $refundquantity;
                        $totaldiscount = $discountamount + $totaldiscount;
                        $refundamount = $invoiceamount -  $discountamt;
                    }else{
                        $discountamt = 0;
                        $discountamount = $discountamt * $refundquantity;
                        $totaldiscount = $discountamount + $totaldiscount;
                        $refundamount = $invoiceamount -  $discountamt;
                    }

                    $newamount = $invoiceamount + ($discount * $invoiceamount);
                    $total = $total + ($newamount * $refundquantity);

                    //Update new quantity
                    $in->recordObject->quantity = $newquantity;
                    $in->recordObject->refund = 1;
                    $in->store();

                    //Store refund History
                    $refundquantity = $refundquantity == '' ? 0 : $refundquantity;

                    $this->storeRefund($invid, $refundamount, $productid, $refundquantity,
                        $discountamt, $invoicecode, $finalpayment, $invoicedate);

                    $newrefunddata[] = ['refunddate'=>$invoicedate, 'quantity'=>$refundquantity,
                                     'productid'=>$productid, 'invoicecode'=>$invoicecode, 'amount'=>$refundamount];
                    //product changes
                    $this->refundproductchanges($productid, $refundquantity, $type);
                }
            }

            $totalrefund = $this->returntotalrefund($invoicecode);

            //Update payments;
            $this->paymentrefund($invoicecode, $totalrefund);

            //History  and refund Data
            $refunddata = Refund::listAll();
            $historydata = Refund::getRefundDetails($invoicecode);

            //update refund status  to zero;
            Refund::updateRefundstatus($invoicecode);

            $message = 'Refund done successfully<br/>'. 'Total to refund: GHC '. $totalrefund;

            //print refund
            $this->printRefund($newrefunddata, $totalrefund, $invoicecode);

            $data = ['refunddata' => $refunddata, 'historydata'=>$historydata,
                'message'=>$message ];
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

    private function discountcalculation($category, $discount, $invoiceamount, $refundquantity, $quantity){
        if($category == 'Profiles'){
            $existingdiscount = $discount * $invoiceamount * $quantity;
            $discountamt = $discount * $invoiceamount * $refundquantity;
            $actualrefundamount = $invoiceamount * $refundquantity;
            $actualamount = $invoiceamount * $quantity - ($discount * $invoiceamount * $quantity);
            $quantityleft = $quantity - $refundquantity;

            $totalwithdiscount =  ($invoiceamount * $quantity) - ($invoiceamount * $refundquantity);

            $backpay = $invoiceamount * $quantity - ($actualrefundamount);
            $finalamount =  $quantityleft * $invoiceamount - ($discount * ($quantityleft * $invoiceamount) );
            $discountleft = $existingdiscount - $discountamt;

            $data = ['totalwithoutdiscount'=>$totalwithdiscount, 'backpay'=> $backpay,  'finaldiscount'=>$discountleft, 'finalamount'=>$finalamount ];
            print_r($data);
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

    private function storeRefund($invoiceid, $amount, $productid, $quantity, $discount,
                                 $invoicecode, $paid, $invoicedate){

        $rf = new Refund();
        $rf->recordObject->invoiceid = $invoiceid;
        $rf->recordObject->amount = $amount;
        $rf->recordObject->productid = $productid;
        $rf->recordObject->quantity = $quantity;
        $rf->recordObject->discount = $discount;
        $rf->recordObject->refunddate = date('Y-m-d');
        $rf->recordObject->invoicecode = $invoicecode;
        $rf->recordObject->totalamount = $amount * $quantity;
        $rf->recordObject->invoicedate = $invoicedate;
        $rf->recordObject->status = 1;
        $rf->recordObject->paid = $paid;
        $rf->store();
    }

    private function returntotalrefund($invoicecode){
        $totalrefund = Refund::getRundByCode($invoicecode);
        return $totalrefund;
    }

    private function paymentrefund($invoicecode, $totalrefund){
        $pro = Payments::getPaymentsbyCode($invoicecode);
        $payid = $pro->payid;
        $pay = new Payments($payid);
        $oldtotalamount = $pay->recordObject->amount;
        $oldfinalamount = $pay->recordObject->finalamount;
        $totalamount = $oldtotalamount  - $totalrefund;
        $finalamount = $oldfinalamount  - $totalrefund;
        $discount = $totalamount - $finalamount;
        //Save changes
        $pay->recordObject->amount = $totalamount;
        $pay->recordObject->finalamount = $finalamount;
        $pay->recordObject->discount = $discount;
        $pay->store();
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

        if($discount != '' ){
            $pay->recordObject->finalamount =  $finalamount - $discount;
        }else{
            $pay->recordObject->finalamount =  $finalamount + $newdiscount;
        }
        $pay->recordObject->amount = $totalamount + $newdiscount;

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
            $pro = new Product($productid);
            $originalqty = $pro->recordObject->quantity;
            if($originalqty<=0) {
                echo "<script>alert('Product out of sctock')</script>";
                $cartdata = Cartitems::getProductsBYCode($_SESSION['invoicecode']);
                $products = Product::listAll();
                $data = ['cartdata' => $cartdata, 'products' => $products];
                $this->view('pages/createinvoice', $data);
            }else {

                $cat = new Cartitems();
                $cat->recordObject->productid = $productid;
                $cat->recordObject->cartcode = $_SESSION['invoicecode'];
                if ($cat->store()) {
                    $cartdata = Cartitems::getProductsBYCode($_SESSION['invoicecode']);
                    $products = Product::listAll();
                    $data = ['cartdata' => $cartdata, 'products' => $products];
                    $this->view('pages/createinvoice', $data);
                    exit;
                }
            }
        }

        if(isset($_POST['processcart'])) {
            $quantity = $_POST['quantity'];
            $productid = $_POST['productid'];
            $saleprice = $_POST['saleprice'];
            $type = $_POST['type'];
            $numberofpieces = $_POST['numberofpieces'];
            $pieceprice = $_POST['pieceprice'];
            $products = Product::listAll();
            $data = ['products' => $products];
            foreach($quantity as $key=>$qty){
                $id =  $productid[$key];
                $amount = $saleprice[$key];
                $ptype = $type[$key];
                $priceperpiece = $pieceprice[$key];
                $numpieces = $numberofpieces[$key];
                $sysquantity = $quantity[$key];

                $amounttopay = 0;

                $pn = new Product($id);
                $dbquantity = $pn->recordObject->quantity;
                if($sysquantity > $dbquantity){
                    echo "<script>alert('Stock Available Not Enough')</script>";
                    Cartitems::deleteCartByCode($_SESSION['invoicecode']);
                    $this->view('pages/createinvoice', $data);
                    exit;
                }


                if($ptype == 'Full'){
                    $amounttopay = $amount;
                }elseif($ptype == 'Pieces'){
                    $amounttopay =  $priceperpiece;
                }
                if($_SESSION['invoicecode'] !== '') {
                    $inv = new Invoices();
                    $inv->recordObject->productid = $id;
                    $inv->recordObject->quantity = $qty;
                    $inv->recordObject->type = $ptype;
                    $inv->recordObject->amount = $amounttopay;
                    $inv->recordObject->invoicedate = date('Y-m-d');
                    $inv->recordObject->invoicecode = $_SESSION['invoicecode'];
                    $inv->recordObject->userid = $_SESSION['userid'];
                    $inv->store();
                }else{
                    echo "<script>alert('Error processing invoice. Please try again')</script>";
                    exit;
                }
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

            if($_SESSION['invoicecode'] !== '') {
                foreach ($quantity as $key => $qty) {
                    $id = $productid[$key];
                    $ptype = trim($optiontype[$key]);

                    $pro = new Product($id);
                    $oldquantity = $pro->recordObject->quantity;
                    $pieces = $pro->recordObject->pieces;
                    $oldoriginalqty = $pro->recordObject->originalquantity;

                    //Product updates
                    $prodata[] = ['quantity' => $oldquantity, 'productid' => $id, 'type' => $ptype,
                        'originalquantity' => $oldoriginalqty, 'newquantity' => $qty, 'pieces' => $pieces];
                    $this->newquantity($ptype, $oldquantity, $qty, $pieces, $id);
                    $this->neworiginalquantity($ptype, $oldoriginalqty, $qty, $pieces, $id);

                }

                //Inserting Payments;
                $this->payments($total, $finalamount, $discountamount, $discount);

                // Print Receipt
                //$this->printReceipt($discountamount, $finalamount, $balance, $amountpaid);
                $this->onlineprint($discountpercent, $_SESSION['userid'], $_SESSION['invoicecode'],  $balance, $amountpaid);

                unset($_SESSION['invoicecode']);

                header('Location:' . URLROOT . '/invoicing/create');
            }else{
                echo "<script>alert('Error processing invoice. Please try again')</script>";
                exit;
            }
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
        $pa->recordObject->finalamount = $amount - $discount;
        $pa->recordObject->discount = $discount;
        $pa->recordObject->discountpercent = $discountpercent;
        $pa->recordObject->userid = $_SESSION['userid'];
        $pa->store();
    }


    public function onlineprint($discountpercent, $userid, $invoicecode,  $balance = null, $amountpaid = null){
        $curl = curl_init();
        $user = new User($userid);
        $name = $user->recordObject->firstname;

        $invoicedata = Invoices::getInvoiceBYCode($invoicecode);
        $gettotalpayments =  Payments::getPaymentsbyCode($invoicecode);
        $finalamount = $gettotalpayments->finalamount;
        $totalamtonivoice = $gettotalpayments->amount;
        $totalamt = $discountpercent + $finalamount;

        $idata = [];
        foreach ($invoicedata as $get){
            $amount = $get->amount;
            $quantity = $get->quantity;
            $type = $get->type;
            $productid = $get->productid;
            $pro = new Product($productid);
            $productname = $pro->recordObject->productname;
            $idata[]  = ['amount'=>$amount, 'product'=>$productname,
                          'quantity'=>$quantity, 'type'=>$type];


        }

        $data = json_encode(['invoicedata'=>$idata, 'discountpercent'=>$discountpercent,
                'finalamount'=>$finalamount, 'name'=>$name, 'invoicecode'=>$invoicecode,
                 'totalamt'=>$totalamt, 'balance'=>$balance, 'amountpaid'=>$amountpaid]);

        curl_setopt_array($curl, array(
            CURLOPT_URL => NGROK_URL.'/print/onlineprint.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$data,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        //echo $response;

    }

  public function printRefund($refunddata,$totalrefund, $invoicecode)
  {
      $curl = curl_init();
      $user = new User($_SESSION['userid']);
      $name = $user->recordObject->firstname;
      $rdata = [];
      foreach($refunddata as $get){
          $refunddate = $get['refunddate'];
          $productid = $get['productid'];
          $quantity = $get['quantity'];
          $amt = $get['amount'];
          $pro = new Product($productid);
          $productname = $pro->recordObject->productname;
          $rdata[]  = ['refunddate'=>$refunddate, 'product'=>$productname,
                       'quantity'=>$quantity, 'amount'=>$amt];
      }

      $data = json_encode(['refunddata'=>$rdata, 'name'=>$name, 'invoicecode'=>$invoicecode,
                            'totalrefund'=>$totalrefund]);

      curl_setopt_array($curl, array(
          CURLOPT_URL => NGROK_URL.'/print/refundprint.php',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>$data,
          CURLOPT_HTTPHEADER => array(
              "Accept: application/json",
              "Content-Type: application/json"
          ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
  }




    public function printReceipt($discountpercent, $total, $balance = null, $amountpaid = null){

        $user = new User($_SESSION['userid']);
        $name = $user->recordObject->firstname;

        $invociedata = Invoices::getInvoiceBYCode($_SESSION['invoicecode']);
        $gettotalpayments =  Payments::getPaymentsbyCode($_SESSION['invoicecode']);
        $finalamount = $gettotalpayments->finalamount;
        $totalamtonivoice = $gettotalpayments->amount;

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
            $totalamt = $discountpercent + $finalamount;
            $printer -> text("\n");
            $printer -> text("Total Amount: ".number_format($totalamt , 2)."\n");
            $printer -> text("Discount: ".number_format($discountpercent ,2)."\n");
            $printer -> text("Amount Received: ".number_format($amountpaid, 2)."\n");
            $printer -> text("Change Given: ".floor($balance)."\n");
            $printer -> setTextSize(2,1);
            $printer -> setEmphasis(true);
            $printer -> text("Total Paid: ".$finalamount."\n");
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