<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 4/13/2019
 * Time: 6:34 AM
 */

class Tests extends Controller
{

    public function adduser(){

        $rs = new RestApi();

        $requiredfieldnames = ['firstname', 'lastname', 'email', 'password'];

        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $password = isset($_POST['email']) ? $_POST['email'] : '';


        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Giving Response if every condition is met
        $rs->returnResponse($_POST);



    }


}