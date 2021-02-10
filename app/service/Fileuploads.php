<?php
/**
 * Created by PhpStorm.
 * User: cassie
 * Date: 4/30/18
 * Time: 9:05 PM
 */

class Fileuploads{
    public static $target = APPROOT.'/uploads/';


    public static function acceptFiles($filename){
        return $filename;
    }

    public static function renameFile($filename){
        $tempfilename  = explode(".", $filename);
        $extension = $tempfilename[1];
        $docname =  uniqid().".".$extension;

        return $docname;
    }

    public static function moveFile($filename, $temporarylocation){
        $targetfile = self::$target;
        $newfile = self::renameFile($filename);
        $newfilelocation  = $targetfile.$newfile;
        move_uploaded_file($temporarylocation, $newfilelocation);
    }
}