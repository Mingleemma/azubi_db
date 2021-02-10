<?php
/**
 * Created by PhpStorm.
 * User: astro
 * Date: 25-Feb-18
 * Time: 13:42
 */

class Guard {
    public function __construct() {
        if(!isset($_SESSION['userid'])){
            header('Location:'. URLROOT);
        }
    }
}