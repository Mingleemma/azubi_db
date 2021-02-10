<?php



class Company extends tableDataObject{

    const TABLENAME= 'company';


    public static function getCompanyCountByEmail($email){
        global $connectedDb;
        $query = "select count(*) as emailcount  from company  where email  = '$email'  ";
        $count= $connectedDb->prepare($query);
        $count = $connectedDb->fetchColumn();
        return $count;
    }

    public static function getCompanyListData($page, $limit){
        global $connectedDb;
        $query = "SELECT * from company  limit $page, $limit ";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }

    public static function getCompanyData(){
        global $connectedDb;
        $userid = $_SESSION['userid'];
        $query = "SELECT company.*, company_users.* FROM  company_users
        INNER JOIN company ON company_users.cmid =  company.cmid
        WHERE company_users.users_uid = $userid ";
        $connectedDb->prepare($query);
        return $connectedDb->singleRecord();
    }



    public static function getCompanyUsersbyID($cmid, $page, $limit){
        global $connectedDb;
        $query = "SELECT users.*, company_users.*, user_roles.* FROM  company_users
                    INNER JOIN users ON company_users.users_uid =  users.uid
                    INNER JOIN user_roles ON users.uid = user_roles.users_uid
                    WHERE company_users.cmid = $cmid limit $page, $limit";
        $connectedDb->prepare($query);
        return $connectedDb->resultSet();
    }


    public static function getCompanyUsersbyIDCount($cmid){
        global $connectedDb;
        $query = "SELECT count(*) as ct  FROM  company_users
                    INNER JOIN users ON company_users.users_uid =  users.uid
                    INNER JOIN user_roles ON users.uid = user_roles.users_uid
                    WHERE company_users.cmid = $cmid";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function checkCompanyexists($cmid){
        global $connectedDb;
        $query = "SELECT  count(*) as count from  company where cmid = $cmid   ";
        $connectedDb->prepare($query);
        return $connectedDb->fetchColumn();
    }

    public static function getCompanyCount(){
        global $connectedDb;
        $query = "select count(*) as count  from company ";
        $count= $connectedDb->prepare($query);
        $count = $connectedDb->fetchColumn();
        return $count;
    }

}


?>