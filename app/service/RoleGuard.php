<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 8/5/2019
 * Time: 6:32 AM
 */

class RoleGuard
{
     public function __construct($role)
     {

        $rolecount = Roles::specificRole($role);

          if($rolecount == 0){
              header('Location:'. URLROOT .'/pages');
              exit;
          }
     }

     public static function checkRole($role){
         $rolecount = Roles::specificRole($role);
         return $rolecount;
     }
}