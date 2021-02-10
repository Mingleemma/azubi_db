<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 4/18/2019
 * Time: 10:26 AM
 */

class User extends BaseUser
{


    public static function getUserByParam($param ,$searchvalue){
        $rowbyparam = parent::getRecordByParams(self::TABLENAME,array($param => $searchvalue));

        if((!$rowbyparam) || count($rowbyparam) !== 1){
            return false;
        } else {
            $userbyparam = new User($rowbyparam->uid);
            return $userbyparam;
        }

    }

    public static function passwordMD5($password){
        return md5($password);
    }

    public static function getUserData($page, $limit){
        global $connectedDb;
        $query = "select * from users  where status is null limit $page, $limit ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();

    }


    public static function userIdByEmail($email){
        global $connectedDb;
        $query = "select uid from users where email  = '$email'  ";
        $uid = $connectedDb->prepare($query);
        $uid = $connectedDb->fetchColumn();
        return $uid;
    }

    public static function checkUserCredentials($email, $password){
        global $connectedDb;
        $password = self::passwordMD5($password);
        $query = "select count(*) as ct from users where email  = '$email' and password = '$password' ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function userinfo($email){
        global $connectedDb;
        $query = "select * from users where email  = '$email' ";
        $connectedDb->prepare($query);
        return $connectedDb->singleRecord();
    }



    public static function getUserCount(){
        global $connectedDb;
        $query = "select count(*) as ct from users  where status is null ";
        $count = $connectedDb->prepare($query);
        $count = $connectedDb->fetchColumn();
        return $count;
    }


    public static function getUserCountbyUserID($uid){
        global $connectedDb;
        $query = "select count(*) as ct from users  where uid = $uid ";
        $count = $connectedDb->prepare($query);
        $count = $connectedDb->fetchColumn();
        return $count;
    }



    public static function getUserCountByEmail($email){
        global $connectedDb;
        $query = "select count(*) as ct from users where email  = '$email'   ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }


    public static function getrolebyUserId($uid)
    {
        global $connectedDb;
        $query = "select roles_roleid from user_roles  where  users_uid  = $uid  ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function getRolesByuid($uid){
        global $connectedDb;
        $getusercount = "SELECT * from user_roles where uid = $uid";
        $connectedDb->prepare($getusercount);
        return $connectedDb->resultSet();
    }

    public static function getRoleCount($uid, $role){
        global $connectedDb;
        $getusercount = "SELECT  count(*) as ct from user_roles where uid = $uid and role = '$role' ";
        $connectedDb->prepare($getusercount);
        return $connectedDb->fetchColumn();
    }


    public static function getRolebyRoleId($roleid){
        global $connectedDb;
        $query = "select role from roles  where  roleid = $roleid  ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function insertCustomerUser($uid, $cmid){
        global $connectedDb;
        $query = "INSERT INTO company_users  (users_uid, cmid) values ($uid, $cmid)  ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }

    public static function checkCustomerUser($cmid){
        global $connectedDb;
        $query = "SELECT  count(*) as count from  company_users where cmid = $cmid   ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function getCustomerUsers($cmid){
        global $connectedDb;
        $query = "SELECT users.*, company_users.*, user_roles.* FROM users INNER JOIN company_users
                  ON users.uid = company_users.users_uid  inner join  user_roles
                  ON users.uid = user_roles.users_uid WHERE cmid = $cmid 
                  ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }

    public static function getSystemUsers(){
        global $connectedDb;
        $query = "SELECT users.* , user_roles.*  FROM  users INNER JOIN
                  user_roles ON users.uid = user_roles.users_uid  WHERE user_roles.roles_roleid = 1 ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }

    public static function updatePassword($uid, $password){
        global $connectedDb;
        $password  = MD5($password);
        $query = "UPDATE users SET password = '$password' where uid = '$uid'  ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }

    public function deletuserrole($userid){
        global $connectedDb;
        $query = "DELETE from user_roles where users_uid = $userid  ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }

    public static function  userStatus($userid, $status){
        global $connectedDb;
        $query = "INSERT INTO  user_reset_status (uid, status) VALUES ($userid, $status)   ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }

    public static function  checkexpiredStutus($userid){
        global $connectedDb;
        $query = "SELECT count(*) as count  from user_reset_status where uid = $userid and status = 1";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }


    public static function updateUserStatus($userid, $status){
        global $connectedDb;
        $query = "UPDATE  user_reset_status SET status=$status where uid = $userid ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }

    public static function deleteCompanyUsers($uid, $cmid){
        global $connectedDb;
        $query = "DELETE from  company_users  where users_uid  = $uid and cmid  = $cmid ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }

    public static function deleteAllCompanyUsers($cmid){
        global $connectedDb;
        $query = "DELETE from  company_users  where  cmid  = $cmid ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }

    public static function deactivateUser($userid){
        global $connectedDb;
        $query = "UPDATE  users SET status=5 where uid = $userid ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }


    public static function companyUserCount($cmid){
        global $connectedDb;
        $query = "SELECT count(*) as ct from company_users where cmid = $cmid ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function companyUserCountByUid($uid){
        global $connectedDb;
        $query = "SELECT count(*) as ct from company_users where users_uid = $uid";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }



    public static function getSystemUsersCount(){
        global $connectedDb;
        $query = "SELECT count(*) as ct  FROM  users INNER JOIN
                  user_roles ON users.uid = user_roles.users_uid  WHERE user_roles.roles_roleid = 1 ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }


    public static function roleCount($role){
        global $connectedDb;
        $query = "SELECT count(*) as ct from roles where  role = '$role' ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }


    public static function getRoles(){
        global $connectedDb;
        $query = "SELECT role from roles ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }

    public static function getroleIdbyRole($role){
        global $connectedDb;
        $query = "SELECT roleid from roles where  role = '$role' ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function insertUserRoles($userid, $role){
        global $connectedDb;
        $query = "INSERT INTO user_roles (uid, role) values ($userid, '$role') ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }



    public static function getCompanyUsers($page, $limit){
        global $connectedDb;
        $query = "SELECT company_users.*, users.* FROM company_users INNER JOIN users
                  ON company_users.users_uid = users.uid WHERE STATUS IS NULL LIMIT $page, $limit";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }


    public static function getCompanyIdByUserId($uid){
        global $connectedDb;
        $query = "SELECT company_users.*, users.* FROM company_users INNER JOIN users
                  ON company_users.users_uid = users.uid WHERE  company_users.users_uid  = $uid";
        $connectedDb->prepare($query);
        return $connectedDb->singleRecord();
    }

    public static function getCompanyIdFromCompanyUsers($uid){
        global $connectedDb;
        $query = "SELECT cmid from company_users where users_uid = $uid";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function deleterUsers($userid){
        global $connectedDb;
        $today = date('Y-m-d H:i:s');
        $query = "INSERT INTO deleted_users (userid, dateofdeletion) values ($userid, '$today') ";
        $connectedDb->prepare($query);
        $connectedDb->execute();
    }


























}