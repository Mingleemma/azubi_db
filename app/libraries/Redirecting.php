<?php
/**
 * Created by PhpStorm.
 * User: getinnotized
 * Date: 4/23/2018
 * Time: 9:46 AM
 */
class Redirecting {

    /**
     * @param $destinationurl
     */
    public static function location($destinationurl){
        header('Location:'.URLROOT.'/'.$destinationurl);
    }
}