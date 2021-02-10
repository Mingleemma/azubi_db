<?php

/**
 * This class is suppose to handle all uploads
 */

 class Uploads{


    public $target_dir = UPLOAD_PATH;
    public $extension;
    public $filename;
    public $templocation;
    public $type = array('xlsx', 'csv');



      //Gets the extension of the file

     /**
      * @return mixed
      */
       public function fileExtension(){
        $this->extension = explode(".", $this->filename['name']);
        $extension = $this->extension = end($this->extension);
        return $extension;
       }


         //Moves  the file from temporary locatio
        public function moveFiles($filename){
            $this->templocation = $this->filename["tmp_name"];
            move_uploaded_file($this->templocation, $this->target_dir."/".$filename);
        }

         public function upLoadFile($newfilename = null){
             if($newfilename == null){
               $filename =  uniqid().'.'.$this->fileExtension();
             }else{
               $filename =  $newfilename.'.'.$this->fileExtension();
             }
             $this->moveFiles($filename);
             return $successarray = array('status'=>'SUCCESS', 'filename'=>$filename);
         }

        public function removeFile($filename){
            $filepath = UPLOAD_PATH.'/'.$filename;
            unlink($filepath);
        }


 }


?>
