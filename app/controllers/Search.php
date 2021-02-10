<?php


class Search extends Controller
{
   public function index(){
       new RoleGuard('Search Invoice');
       $this->view('pages/search');
   }


}