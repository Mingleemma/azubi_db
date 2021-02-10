<?php

class Registrations extends Controller{

	public function businessregistration(){

		$uid = $this->loggedInUser->recordObject->uid;

		$this->view('pages/businessregistration', $uid);
	}

	public function businessdetails ($busid){

		//$this->view('')
		
	}

}


?>