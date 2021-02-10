<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 8/5/2019
 * Time: 7:44 AM
 */

class Errors extends Controller
{
    public function index(){
     $this->view('pages/errorpage');
     exit;
    }

    public function error404(){
        $this->view('pages/404');
        exit;
    }
}