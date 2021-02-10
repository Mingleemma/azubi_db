<?php

class Ajax extends Controller{


    public function deletehomeservice(){
        $homeservice = new HomeServicesData($_POST['homeid']);
        $homeservice->deleteFromDB();
    }




}

?>
