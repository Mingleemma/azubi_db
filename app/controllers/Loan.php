<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 1/14/2020
 * Time: 1:56 PM
 */

class Loan extends Controller
{


    public  function index(){

        //new Guard($this->loggedInUser,['Regular']);
        $today  = date('Y-m-d');
        $basicdata = Basicinformation::listAll();
        $customercount = Basicinformation::customercount();
        $usercount =  count(User::listAll());
        $totalpayments = Payments::getTotalPayments();
        $paymentstoday = Payments::getTotalpaymentsBydate($today);
        $allpayments =   Payments::getAllpaymentsbyToday();
        $loanaccount  = Accounts::getACountbyType('Loan Account');


        $data = ['basicdata'=>$basicdata, 'customercount'=>$customercount,
            'usercount'=>$usercount, 'totalpayments'=>$totalpayments,
            'paymentstoday'=>$paymentstoday, 'loanaccounts'=>$loanaccount];
        $this->view( 'pages/loans', $data);


    }

    public function management($bid){

        $ba  = new Basicinformation($bid);
        $customerdata = $ba->recordObject;
        $loandata = Loandata::getLoanByCustomerID($bid);

        $data = ['customerdata'=>$customerdata, 'loandata'=>$loandata];
        $this->view( 'pages/loandetails', $data);
    }
}