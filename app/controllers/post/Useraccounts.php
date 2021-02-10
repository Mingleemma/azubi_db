<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/7/2019
 * Time: 3:01 PM
 */

class Useraccounts extends PostController
{

    public function create(){

        $rs = new RestApi();

        $requiredfieldnames = ['firstname', 'lastname', 'email', 'role'];

        $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
        $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $role = isset($_POST['role']) ? trim($_POST['role']) : '';


        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Check if email exista
        $emailcount  = User::getUserCountByEmail($email);
        if($emailcount > 0){
            $rs->throwErrror('USR_04', USR_04, 'email' );
        }

        $rolecount  = User::roleCount($role);
        if($rolecount == 0){
            $rs->throwErrror('USR_06', USR_06, 'role' );
        }


        //Get roleid from roles table
        $roleid = User::getroleIdbyRole($role);


        //Actual Job of  this API Call
        //Inserting into the user table
        $us = new User();
        $usdata =& $us->recordObject;
        $usdata->email = $email;
        $usdata->password = 'NULL';
        $usdata->firstname = $firstname;
        $usdata->lastname = $lastname;
        if($us->store()){
            $uid = $us->recordObject->uid;
            //Inserting Roles
            $this->insertuserrole($uid, $roleid);
            User::userStatus($uid, 1);

            //Sending Email
            $link = FRONTURL.'/resetpassword/'.$uid;
            $content = 'Your account has been created. Click on the link below to create your password';
            $ls = $this->emailmessage($firstname, $email, 'Account Creation', $link, $content);

            $data = ['message'=>'User successfully created', 'userid'=>$uid];

            //Returning success response when user is created successfully
            $rs->returnResponse($data);

        }

    }


    public function updateuser($userid = null){

        $rs = new RestApi();

        $requiredfieldnames = ['firstname', 'lastname', 'email'];

        $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
        $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        //$userid = isset($_POST['userid']) ? trim($_POST['userid']) : '';

        //Checking if user ID is null;
        if($userid == null){
            $rs->throwErrror('USR_O8', USR_08, 'userid');
        }

        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);


        //Actual Job of  this API Call
        //Updating  the user table
        $us = new User($userid);
        $usdata =& $us->recordObject;
        $usdata->email = $email;
        $usdata->firstname = $firstname;
        $usdata->lastname = $lastname;
        if($us->store()){

            $userdata = $us->recordObject;

            $data = ['message'=>'User data successfully updated', 'userdata'=>$userdata];
            //Returning success response when user is created successfully
            $rs->returnResponse($data);

        }

    }


    public function addcredentials(){

        $rs = new RestApi();

        $requiredfieldnames = ['userid', 'password'];

        $userid = isset($_POST['userid']) ? trim($_POST['userid']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Verify User ID
        $usercount = User::getUserCountbyUserID($userid);
        if($usercount == 0){
            $rs->throwErrror('USR_07', USR_07, 'userid');
        }


        //Getting Authorization token
        //$token = $rs->getBearerToken();

        //Verifying Token
        //$rs->verifyToken($token);


        // Api Functionality

        $us = new User($userid);
        $us->recordObject->password = md5($password);
        if($us->store()){

            //Update password reset link
            User::updateUserStatus($userid, 2);
            $data = ['message'=>'Password succesfully updated', 'userid'=>$userid];
            $rs->returnResponse($data);

        }




    }



    public function forgotpassword(){

        $rs = new RestApi();

        $requiredfieldnames = ['email'];
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';

        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);
        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Check if email exists
        $emailcount  = User::getUserCountByEmail($email);
        if($emailcount == 0){
            $rs->throwErrror('USR_04', USR_04, 'email' );
        }

        //Get User ID
        $userid = User::userIdByEmail($email);

        // Api Functionality
        // 1- Update password reset link
        // 2 - Send an email with the new link


        //Updating password linh
        User::updateUserStatus($userid, 1);

        $us = new User();
        $firstname = $us->recordObject->firstname;

        //Sending Email
        $link = FRONTURL.'/resetpassword/'.$userid;
        $content = 'Your account has been created. Click on the link below to create your password';
        $this->emailmessage($firstname, $email, 'Account Creation', $link, $content);

        $data = ['message'=>'User successfully created', 'userid'=>$userid];

        $rs->returnResponse($data);

    }


    public function resendpasswordlink(){
        $rs = new RestApi();

        $requiredfieldnames = ['email'];

        $email = isset($_POST['email']) ? trim($_POST['email']) : '';

        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Check if email exista
        $emailcount  = User::getUserCountByEmail($email);
        if($emailcount == 0){
            $rs->throwErrror('USR_04', USR_04, 'email' );
        }

        $userid = User::userIdByEmail($email);

        //Updating password link
        User::updateUserStatus($userid, 1);

        $us = new User();
        $firstname = $us->recordObject->firstname;

        //Sending Email
        $link = FRONTURL.'/resetpassword/'.$userid;
        $content = 'Your password reset request has been granted. Click on the link below to reset your password';
        $this->emailmessage($firstname, $email, 'Account Creation', $link, $content);

        $data = ['message'=>'Email successfully sent', 'userid'=>$userid];

        $rs->returnResponse($data);


    }


    public function addcompanyuser($cmid){

        $rs = new RestApi();

        $requiredfieldnames = ['firstname', 'lastname', 'email', 'role', ];

        $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
        $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $role = isset($_POST['role']) ? trim($_POST['role']) : '';

        //Checking if user ID is null;
        if($cmid  == null){
            $rs->throwErrror('CM_O1', CM_01, 'company ID');
        }

        $postfields = (array_keys($_POST));

        //Validating the fieldnames in the method
        $rs->validateFieldNames($requiredfieldnames, $postfields);

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Check if email exista
        $emailcount  = User::getUserCountByEmail($email);
        if($emailcount > 0){
            $rs->throwErrror('USR_04', USR_04, 'email' );
        }

        $rolecount  = User::roleCount($role);
        if($rolecount == 0){
            $rs->throwErrror('USR_06', USR_06, 'role' );
        }


        //Get roleid from roles table
        $roleid = User::getroleIdbyRole($role);


        //Actual Job of  this API Call
        //Inserting into the user table
        $us = new User();
        $usdata =& $us->recordObject;
        $usdata->email = $email;
        $usdata->password = 'NULL';
        $usdata->firstname = $firstname;
        $usdata->lastname = $lastname;
        if($us->store()){
            $uid = $us->recordObject->uid;
            //Inserting Roles
            $this->insertuserrole($uid, $roleid);

            //Insert Company Users
            User::insertCustomerUser($uid, $cmid);

            //Setting password status
            User::userStatus($uid, 1);

            //Sending Email
            $link = FRONTURL.'/resetpassword/'.$uid;
            $content = 'Your account has been created. Click on the link below to create your password';
            $ls = $this->emailmessage($firstname, $email, 'Account Creation', $link, $content);

            $data = ['message'=>'User successfully created', 'userid'=>$uid];

            //Returning success response when user is created successfully
            $rs->returnResponse($data);

        }

    }


    private function insertuserrole($uid, $roleid){
      User::insertUserRoles($uid, $roleid);
    }


    private function emailmessage($firstname, $email, $subject, $link, $content){

        $message  = "<div align='left' style='width: 500px; border:1px solid #3AC47D; padding: 10px; font-family:Verdana; font-size:12px '>";
        $message .="<div align='center'><span style='font-size:20px; font-weight:bold'>$subject</span><br/><span>$email</span><hr/><br/></div>";
        $message .= "<span>Dear $firstname, </span><br/>";
        $message .= "<span >$content</span><br/>";
        $message .= "<span>From: ROGG </span><hr/><br/>";
        $message .= "<div align='center'><a style='text-decoration: none' href=$link><div style='background:#3AC47D; color:#fff; border-radius: 50px; ; width: 160px; padding:10px'><span style='font-weight: 700; font-size: 15px'>Reset Password</span></div></a></div>";
        $message .= "</div>";

        $response = sendEmail(SENDER_EMAIL, $email, $subject, $message, COMPANYNAME);

        return $response;
    }

}