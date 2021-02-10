<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 10/7/2019
 * Time: 4:37 PM
 */

class Useraccounts extends Controller
{
      public function userlist(){

          $rs = new RestApi();

          // Verify Apikey
          $rs->getApikey();

          //Getting Authorization token
          $token = $rs->getBearerToken();

          //Verifying Token
          $rs->verifyToken($token);

          //Getting the actual Api method
          //Calling pagination class
          $pag = Pagination::paginate();

          $page = $pag['page'];
          $limit = $pag['limit'];
          $userdata = User::getUserData($page, $limit);
          $usercount = User::getUserCount();

          $alluserdata = [];

          foreach($userdata as $get){

              $userid  = $get->uid;
              $lastname = $get->lastname;
              $firstname = $get->firstname;
              $email = $get->email;

              $roleid  = User::getrolebyUserId($userid);

              $alluserdata[] = ['firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email,
                                'userid'=>$userid,  'roleid'=>$roleid ];
          }

          $data = ['userdata'=>$alluserdata, 'totalcount'=>$usercount];

          $rs->returnResponse($data);

      }


      public function user($userid = null)
      {
          $rs = new RestApi();

          // Verify Apikey
          $rs->getApikey();

          //Getting Authorization token
          $token = $rs->getBearerToken();

          //Verifying Token
          $rs->verifyToken($token);


          //Checking if user ID is null;
          if($userid == null){
              $rs->throwErrror('USR_O8', USR_08, 'userid');
          }

          //Check if user Id Exists;
          $usercount = User::getUserCountbyUserID($userid);
          if($usercount == 0) {
              $rs->throwErrror('USR_O7', USR_07, 'userid');
          }

          //Getting the actual Api method

          $us = new User($userid);
          $get= $us->recordObject;

          //$userid  = $get->uid;
          $lastname = $get->lastname;
          $firstname = $get->firstname;
          $email = $get->email;

          $roleid  = User::getrolebyUserId($userid);

          $alluserdata = ['firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email,
                           'userid'=>$userid,  'roleid'=>$roleid ];

          $rs->returnResponse($alluserdata);

      }


    public function checklinkavailability($codedstring = null){

        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        //$token = $rs->getBearerToken();

        //Verifying Token
        //$rs->verifyToken($token);

        //Checking if user ID is null;
        if($codedstring == null){
            $rs->throwErrror('USR_O8', USR_08, 'userid');
        }


        $userid = base64_decode($codedstring);

        //check where link is expired
        $count = User::checkexpiredStutus($userid);
        if($count == 0){
            $rs->throwErrror('USR_09', USR_09, 'userid');
        }

        //Api functionality
        $data = ['userid'=>$userid];

        $rs->returnResponse($data);
    }


    public function roles(){

        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Api functionality
        $roledata = User::getRoles();
        $rs->returnResponse($roledata);
    }



    public function  deleteuser($userid = null ){

        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        $method = $_SERVER['REQUEST_METHOD'];

        if($method !== 'DELETE') {
            $rs->throwErrror('REQUEST_METHOD_NOT_VALID', 'Request method not allowed', 'Request Method');
        }


        //Checking if user ID is null;
        if($userid == null){
            $rs->throwErrror('USR_08', USR_08, 'userid');
        }

        //Check if user Id Exists;
        $usercount = User::getUserCountbyUserID($userid);
        if($usercount == 0) {
            $rs->throwErrror('USR_07', USR_07, 'userid');
        }


        $us = new User($userid);
        $us->deleteFromDB();

        // Add to deleted Users
        User::deleterUsers($userid);
        $data= ['message'=>'User successfully deleted', 'userid'=>$userid];
        $rs->returnResponse($data);


//        $us = new User($userid);
//        $us->recordObject->status = 5;
//        if($us->store($userid)){
//            $data= ['message'=>'User successfully deleted', 'userid'=>$userid];
//            $rs->returnResponse($data);
//        }



    }


    public function companyusers($companyid = null){

        $url = parse_url($_SERVER['REQUEST_URI']);

        if(isset($url['query'])) {
            parse_str($url['query'], $parameters);

            $page = isset($parameters['page']) ? $parameters['page'] : 1;
            $page = $page -1;
            $limit = isset($parameters['limit']) ? $parameters['limit'] : 20  ;
        }else{
            $page = 0;
            $limit = 20;
        }
        $rs = new RestApi();

        // Verify Apikey
        $rs->getApikey();

        //Getting Authorization token
        $token = $rs->getBearerToken();

        //Verifying Token
        $rs->verifyToken($token);

        //Checking if user ID is null;
        if($companyid == null){
            $rs->throwErrror('CM_O1', CM_01, 'company ID');
        }

        $companycount = Company::checkCompanyexists($companyid);

        if($companycount == 0){
            $rs->throwErrror('CM_02', CM_02, 'company ID');
        }


        $userdata = Company::getCompanyUsersbyID($companyid, $page, $limit);
        $usercount = Company::getCompanyUsersbyIDCount($companyid);

        $alluserdata = [];

        foreach($userdata as $get){
            $firstname  = $get->firstname;
            $lastname  = $get->lastname;
            $userid  = $get->uid;
            $companyid = $get->cmid;
            $email = $get->email;
            $roleid  = $get->roles_roleid;
            $role = User::getRolebyRoleId($roleid);
            $alluserdata[] = ['firstname'=>$firstname, 'lastname'=>$lastname, 'userid'=>$userid,
                      'companyid'=>$companyid,  'role'=>$role, 'email'=>$email ];
        }

        $data = ['userdata'=>$alluserdata, 'totalcount'=>$usercount];

        $rs->returnResponse($data);


    }





}