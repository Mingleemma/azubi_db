<?php

class BaseUser extends tableDataObject {
	const TABLENAME = 'users';

	// FUNCTIONS FROM THE "CONTROLLER" MISTAKENLY CREATED INSTEAD OF AN OBJECT FOR ROLE CONCEPTS
	// -------------------------------------------------------------------------------------------
    /**
     * @return array
     * @throws frameworkError
     */
    public function listRoles(){
		global $fdadb;

		$thisuid = $this->recordObject->uid;

		$getroles = "select role from users
				join user_roles on users.uid = user_roles.users_uid
			    join roles on user_roles.roles_roleid = roles.roleid
			    where uid = $thisuid";
		$fdadb->prepare($getroles);
		$roles = $fdadb->resultSet(true);
		foreach($roles as $role){
			$rolesout[] = $role['role'];
		}
		return $rolesout;
	}

    /**
     * @param $role
     *
     * @return bool
     * @throws frameworkError
     */
    public function hasRole($role){
		global $fdadb;

		$thisuid = $this->recordObject->uid;

		$getrole = "select role from users
				join user_roles on users.uid = user_roles.users_uid
			    join roles on user_roles.roles_roleid = roles.roleid
			    where uid = $thisuid ";

		// accept array of multiple roles to check from
		if(is_array($role)){
			$roles = "('" . implode("','",$role) . "')";
			$getrole .= " and role in $roles";
		} else {
			$getrole .= " and role='$role'";
		}
		$fdadb->prepare($getrole);
		if(count($fdadb->resultSet()) >0){
			return true;
		} else {
			return false;
		}
	}

    /**
     * @param $role
     *
     * @return mixed
     * @throws frameworkError
     */
    public function roletype($role){
		global $fdadb;
		$getuserrole = "Select roleid from roles where role = '$role' ";
		$rl = $fdadb->prepare($getuserrole);
		$role = $fdadb->fetchColumn();
		return $role;
	}

    /**
     * @param $roletype
     *
     * @throws frameworkError
     */
    public function addRole($roletype){
		global $fdadb;
		$uid = $this->recordObject->uid;
		$roleid = $this->roletype($roletype);
		$query = "INSERT INTO  user_roles  (users_uid, roles_roleid) values ($uid , $roleid) ";
		$fdadb->prepare($query);
		$fdadb->execute();
	}


    /**
     * @param $roletype
     *
     * @throws frameworkError
     */
    public function removeRole($roletype){
		global $fdadb;
		$uid = $this->recordObject->uid;
		$roleid = $this->roletype($roletype);
		$query = "DELETE from user_roles where users_uid = $uid and roles_roleid = $roleid ";
		$fdadb->prepare($query);
		$fdadb->execute();
	}

    /**
     * @param $role
     *
     * @return mixed
     * @throws frameworkError
     */
    public static function getUsersWithRole($role){
		global $fdadb;

		$getUqry = "select users.*, roles.role from users join
					user_roles on uid = users_uid join
					roles on roleid = roles_roleid where role = '$role'
					and uid not in (
					  select users_uid from user_roles join roles on roles_roleid = roleid
					    where role = 'deleted'
					) order by uid";
		$fdadb->prepare($getUqry);
		return $fdadb->resultSet();
	}
}
