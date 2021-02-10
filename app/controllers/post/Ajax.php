<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 1/1/2020
 * Time: 3:25 PM
 */

class Ajax extends PostController
{

    public function payments(){
        $from = date('Y-m-d', strtotime($_POST['from']));
        $to =  date('Y-m-d', strtotime($_POST['to']));
        $paymentdata =  Payments::getAllpaymentsbyDate($from, $to);
        $data = ['allpayments'=>$paymentdata];
        $this->view('pages/ajaxpayments', $data);
    }

    public function deleteuserrole(){
        $userid = $_POST['userid'];
        $role = $_POST['role'];
        Roles::deleteRole($role, $userid);
    }

    public function deletecustomer(){
        $homeservice = new Basicinformation($_POST['bid']);
        $homeservice->deleteFromDB();
    }

    public function deletecart(){
        $cart = new Cartitems($_POST['cartid']);
        $cart->deleteFromDB();
    }

    public function deleteuser(){
        $user= new User($_POST['userid']);
        $user->deleteFromDB();
    }

    public function deletecategory(){
        $cat = new Categories($_POST['catid']);
        $cat->deleteFromDB();
    }

    public function deleteproduct(){
        $pro = new Product($_POST['productid']);
        $pro->deleteFromDB();
    }

    public function approvecustomer(){

        $bid = $_POST['bid'];

        $ba = new Basicinformation($bid);
        $ba->recordObject->status = 1;
        $ba->store();
    }

    public function deletepayment(){
        $homeservice = new Payments($_POST['payid']);
        $homeservice->deleteFromDB();
    }

    public function viewtransactions(){
        $code = $_POST['code'];
        $paydata = Invoices::getInvoiceBYCode($code);
        $data = ['invoicedata'=>$paydata];
        $this->view('pages/viewinvoices', $data);
    }

    public function discountcalculator(){
        $discount = $_POST['discount'];
        $invoicecode = $_SESSION['invoicecode'];
        $invdata = Invoices::getInvoiceBYCode($invoicecode);

        $discountamount = 0;
        $adtotalamount = 0;
        $totalamount = 0;
        $totaldiscountamount = 0;

        foreach($invdata as $get){
            $productid = $get->productid;
            $amount =   $get->amount;
            $quantity  =   $get->quantity;
            $totalamount = ($amount * $quantity) + $totalamount;

            $pro = new Product($productid);
            $catid = $pro->recordObject->catid;

            $ca = new Categories($catid);
            $category = $ca->recordObject->category;

            if($category == 'Profiles'){
                $adtotalamount = ($amount * $quantity) + $adtotalamount;
                $discountamount = (($discount/100) * $adtotalamount);
                $totaldiscountamount = $discountamount + $totaldiscountamount;

            }

        }
        $afterdiscount = ($totalamount -  $discountamount);
        echo json_encode(['afterdiscount'=> round($afterdiscount,2), 'discountamount'=>round($discountamount, 2)]);
    }


}