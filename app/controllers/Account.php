<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 1/15/2020
 * Time: 8:45 AM
 */

class Account extends Controller
{

    public function  index(){
        $allaccounts = Accounts::allAccounts();
        $this->view('pages/allaccounts', $allaccounts);
    }

    public function accountspdf(){
        $allaccounts = Accounts::allAccounts();
        $this->view('reports/accountspdf', $allaccounts);
    }



}