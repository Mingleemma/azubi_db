<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 8/4/2019
 * Time: 8:50 PM
 */

class Roles extends tableDataObject
{
    const TABLENAME  = 'roles';

    public static  function getGroupedRoles(){
        global $connectedDb;
        $getrecords = "SELECT module from roles group by  module ";
        $connectedDb->prepare($getrecords);
        return $connectedDb->resultSet();
    }

    public static  function getroleBymodule($module){
        global $connectedDb;
        $getrecords = "SELECT role  from roles where module = '$module' ";
        $connectedDb->prepare($getrecords);
        return $connectedDb->resultSet();
    }

    public static  function specificRole($role){

        $userid  = $_SESSION['userid'];
        global $connectedDb;
        $getrecords = "SELECT count(*) as CT  from user_roles where uid = $userid and role = '$role' ";
        $connectedDb->prepare($getrecords);
        return $connectedDb->fetchColumn();
    }

    public static  function deleteRole($role, $uid){

        //$uid  = $_SESSION['uid'];
        global $connectedDb;
        $getrecords = "DELETE from user_roles where role = '$role' and uid = $uid ";
        $connectedDb->prepare($getrecords);
        $connectedDb->execute();
    }
}



