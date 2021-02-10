<?php

class UserEnroll extends Controller{


    // TODO: cleanu up addadmin and addCustomerUsers -no reason for two functions here!

    public function addadmin(){

        if($this->loggedInUser->hasRole('administrator')){
            if(isset($_POST['creataccount'])){

                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $password = User::passwordMD5($_POST['password']);

                // check if user exists.
                $usercount  =  User::checkUserExist($email);


                if($usercount == 0){
                    $userdata = new User();
                    $datarow =& $userdata->recordObject;
                    $datarow->email = trim($email);
                    $datarow->password = trim($password);
                    $datarow->firstname = trim($firstname);
                    $datarow->lastname = trim($lastname);
                    $datarow->email = trim($email);
                    $datarow->status = 1;
                    $userdata->store();
                    $userid = $datarow->uid;

                    if($userid != null){
                        $role = 'Administrator';
                        $roleid = Roles::userRoleId($role);
                        Roles::enterRoles($roleid, $userid);
                        $messagedata = ['response'=>'User Successfully Enrolled'];
                        $this->view('users/addadmin', $messagedata);
                    }

                }else{
                    $messagedata  = ['response'=>'Error adding user - user already exists'];
                    $this->view('users/addadmin', $messagedata);
                }
            }else{

                $this->view('users/addadmin');
            }

        }
        else{
            Core::notfound();

        }

    }

// Adding Administratrative Customers

    public function  addCustomerUsers(){
        $customers = Customer::listCustomers();

        if(isset($_POST['createCustomerAccount'])){
            $customerid = $_POST['customerid'];
            $email = $_POST['email'];
            $password = User::passwordMD5($_POST['password']);
            $primarycount = User::checkPrimaryUserExist($customerid);
            $count = User::checkUserExist($email);

            if($count == 0){
                // Create a primary account
                $userdata = new User();
                $datarow =& $userdata->recordObject;
                $datarow->password = trim($password);
                $datarow->email = trim($email);
                $datarow->access_level = 2;
                $datarow->status = 1;

                $userdata->store();
                $userid = $datarow->uid;

                if($userid != null){
                    $role = 'customer';
                    if($primarycount == 0) {
                        $isprimary = 1;
                    } else {
                        $isprimary = 0;
                    }
                    $apikey = generateApikey($customerid);
                    $roleid = Roles::userRoleId($role);
                    Roles::enterRoles($roleid, $userid);
                    User::enterUserCustomers($userid, $customerid, $apikey, $isprimary);
                    $customerdata = ['records'=> $customers,'response'=>'Customer Successfully Enrolled'];
                    $this->view('users/addcustomer', $customerdata);
                }
            }else{
                $customerdata = ['records'=> $customers,'response'=>'Error Creating Customer Account'];
                $this->view('users/addcustomer', $customerdata);

            }
        }else{

            $customersdata = ['records'=> $customers];
            $this->view('users/addcustomer', $customersdata );
        }

    }

    public function addSecondaryUsers(){

        $userid = $_POST['userid'];
        $customerids = $_POST['customerids'];

        foreach($customerids as $cid){
            $role = 'customer';
            $apikey = generateApikey($cid);
            $isprimary = 'NULL';
            User::enterUserCustomers($userid, $cid, $apikey, $isprimary);
        }
    }

    public function customeraccounts(){
        $customeraccounts = User::getPrimaryUserAccounts();

        // prepare our customer data before the view. Dealing with roles locked or deleted here for status.
        foreach($customeraccounts as $account){
            $ruser = new User($account->uid);
            $rcustomer = new Customer($account->cid);
            if($ruser->hasRole('deleted')){
                $ruser->recordObject->displaystatus = 'deleted';
            } elseif($ruser->hasRole('locked')){
                $ruser->recordObject->displaystatus = 'locked';
            } else {
                $ruser->recordObject->displaystatus = 'Active';
            }

            // Here we are also going to get the secondary accounts before showing the view
            $secondaries = $ruser->getUserCompanies('secondary');
            $ruser->recordObject->secondaryCustomers = $secondaries;

            $accountsout[] = (object) array_merge((array) $rcustomer->recordObject, (array) $ruser->recordObject);

        }

        $data = ['customeraccounts'=>$accountsout];
        $this->view('users/customeraccounts', $data);

    }

    public function  editcustomeruseraccount(){

        $userid = $_POST['userid'];
        $allaccounts = new User($userid);
        $allaccounts = $allaccounts->getUserCompanies('all');
        $allcustomerdata = ['accounts'=>$allaccounts, 'userid'=>$userid];
        $this->view('users/editcustomeruseraccount', $allcustomerdata);

    }

    public function  editprofile(){
      $userinfo = new User($this->loggedInUser->recordObject->uid);
        if(isset($_POST['updateprofile'])){
            $userinfo->recordObject->firstname = $_POST['firstname'];;
            $userinfo->recordObject->lastname = $_POST['lastname'];;
            $userinfo->recordObject->email = $_POST['email'];
            $userinfo->store();

            if($this->loggedInUser->hasRole('customer')){
                $customerdata = $userinfo->getUserCompanies('primary');
                $companyname = $customerdata->companyname;
                $loggedinuserdata = $this->loggedInUser->recordObject;
                $userdata = ['userdata'=>$loggedinuserdata, 'companyname'=>$companyname];
                $this->view('users/editprofile', $userdata);
             }else{
              $loggedinuserdata = $this->loggedInUser->recordObject;
              $userdata = ['userdata'=>$loggedinuserdata];
              $this->view('users/editprofile', $userdata);
             }
        }else {
           if($this->loggedInUser->hasRole('customer')){
              $customerdata = $userinfo->getUserCompanies('primary');
              $companyname = $customerdata->companyname;
              $loggedinuserdata = $this->loggedInUser->recordObject;
              $userdata = ['userdata'=>$loggedinuserdata, 'companyname'=>$companyname];
              $this->view('users/editprofile', $userdata);
            }else{
              $loggedinuserdata = $this->loggedInUser->recordObject;
              $userdata = ['userdata'=>$loggedinuserdata];
              $this->view('users/editprofile', $userdata);
            }

        }
    }

    public function changeadminpassword (){

        $userinfo = new User($this->loggedInUser->recordObject->uid);

        if(isset($_POST['updatepassword'])){

            $password = User::passwordMD5($_POST['adminpass']);
            $userinfo->recordObject->password = $password;
            $userinfo->store();
            if($this->loggedInUser->hasRole('customer')){
                $customerdata = $userinfo->getUserCompanies('primary');
                $companyname = $customerdata->companyname;
                $userdata = ['companyname'=>$companyname];
                $this->view('users/adminpassword', $userdata);
             }else{
              $this->view('users/adminpassword');
             }

        }else{
          if($this->loggedInUser->hasRole('customer')){
             $customerdata = $userinfo->getUserCompanies('primary');
             $companyname = $customerdata->companyname;
             $userdata = ['companyname'=>$companyname];
             $this->view('users/adminpassword', $userdata);
            }else{
              $this->view('users/adminpassword');
            }

        }

    }

    public function  adminstatus(){
        $userid = $_POST['userid'];
        $userToadmin = new User($userid);
        $userToadmin->removeRole('Super administrator');
    }

    public function  superadminstatus(){
        $userid = $_POST['userid'];
        $userTosuper = new User($userid);
        $userTosuper->addRole('Super administrator');
    }

    public function resetcustomer(){
        $userid = $_POST['userid'];
        $data = ['userid'=>$userid];
        $this->view('users/password', $data);

    }

    public function useraccounts(){
        $userid = $_POST['userid'];
        $customers = Customer::listCustomers();
        $data = ['userid'=>$userid, 'customers'=>$customers];
        $this->view('users/useraccounts', $data);

    }

    public function lockcustomer(){
        $userid = $_POST['userid'];
        $userToLock = new User($userid);
        $userToLock->addRole('locked');

        new Logger("User id $userid was locked.",
            'administrator action',
            $this->loggedInUser->recordObject->email);

    }

    public function unlockcustomer(){
        $userid = $_POST['userid'];
        $userTounLock = new User($userid);
        $userTounLock->removeRole('locked');

        new Logger("User id $userid was unlocked.",
            'administrator action',
            $this->loggedInUser->recordObject->email);

    }

    public function deleteadminaccount(){
        $userid = $_POST['userid'];
        $userTodelete = new User($userid);
        $userTodelete->addRole('deleted');
    }

    public function resetpassword(){
        $userid = $_POST['userid'];
        $password = User::passwordMD5($_POST['resetpass']);
        $userResetpassword = new User($userid);
        $userResetpassword->recordObject->password = $password;
        $userResetpassword->store();

    }

    public function deleteCustomerAccount(){
        $cid = $_POST['cid'];
        $userid = $_POST['userid'];
        User::deleteaccount($userid, $cid);
        // $deleteuser = new User($userid);
        // $deleteuserdeleteaccount($userid);
    }




}


?>
