<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 3/28/2018
 * Time: 13:24
 *
 * @param $classname
 *
 * @return array
 * @throws ReflectionException
 */

function listmethods($classname){
    $methods = get_class_methods($classname);
    sort($methods);
    $reflector = new ReflectionClass($classname);
    return array("reflector" => $reflector, "methods" => $methods);
}


function redirectToBusinessForms($count){
	if($count == 0){
		$location = URLROOT.'/backoffice/registrations/businessregistration';
		header('Location:'. $location );
		exit;
	}
}

function guard($uid = null){

	echo $uid = $this->loggedInUser->recordObject->uid;

	// if(!isset($uid)){
	// 	$location = URLROOT.'/front/pages/login';
	// 	header('Location:'. $location );
	// 	exit;
	// }
}