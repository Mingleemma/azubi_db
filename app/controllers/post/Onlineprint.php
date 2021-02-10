<?php
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class Onlineprint extends PostController
{

    public function index(){
        $handler = fopen('php://input',  'r');
        $data  = stream_get_contents($handler);
        $data = json_decode($data);

        $invoicedata = $data->invoicedata;
        $discountpercent = $data->discountpercent;
        $finalamount = $data->finalamount;
        $name = $data->name;
        $invoicecode = $data->invoicecode;
        $totalamt = $data->totalamt;
        $balance = $data->balance;
        $amountpaid = $data->amountpaid;

        try {
            // Enter the share name for your USB printer here
            $connector = new WindowsPrintConnector("PrinceUSBPrinter");
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
            $printer -> text("Receipt No:  ".$invoicecode."\n");
            $printer -> text("Receipt Date:  ".date('Y-m-d')."\n");
            $printer -> text("\n");
            foreach($invoicedata as $get){

                $printer -> text("Product: ".$get->product."\n");
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

    public function refund()
    {
        $handler = fopen('php://input', 'r');
        $data = stream_get_contents($handler);
        $data = json_decode($data);

        $refunddata = $data->refunddata;
        $name = $data->name;
        $invoicecode = $data->invoicecode;
        $totalrefund = $data->totalrefund;

        try {
            // Enter the share name for your USB printer here
            $connector = new WindowsPrintConnector("PrinceUSBPrinter");
            $printer = new Printer($connector);
            $image = EscposImage::load(PUBLIC_PATH . '/logo.png', false);
            $printer->bitImage($image);
            $printer->setTextSize(2, 2);
            $printer->setEmphasis(true);
            $printer->text("REFUND RECEIPT \n");
            $printer->setTextSize(1, 1);
            $printer->setEmphasis(true);
            $printer->text("Cashier: " . strtoupper($name) . "\n");
            $printer->text("\n");
            $printer->setTextSize(1, 1);
            $printer->setEmphasis(false);
            $printer->text("Receipt No:  " . $invoicecode . "\n");
            $printer->text("Receipt Date:  " . date('Y-m-d') . "\n");
            $printer->text("\n");
            foreach ($refunddata as $get) {
                $printer->text("Product: " . $get->product . "\n");
                $printer->text("Qty: " . $get->quantity . "\n");
                $printer->text("Unit Price: " . $get->amount . "\n");
                $printer->text("Amount: " . $get->amount * $get->quantity . "\n");
                $printer->text("\n");
            }

            $printer->text("\n");
            $printer->text("Total Refund: " . number_format($totalrefund, 2) . "\n");

            $printer->setEmphasis(false);
            $printer->text("\n");
            $printer->text("\n");
            $printer->text("Powered by NM Aluminium. Tel: 0302959686\n");
            $printer->text("\n");
            $printer->text("\n");
            $printer->cut();
            /* Close printer */
            $printer->close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }


}