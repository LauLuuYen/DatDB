<?php

header("Access-Control-Allow-Origin: *");


class Get {

    public function __construct() {
        //
    }
	
    
    public function retrieve() {
        
        require_once "../include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        $data = array();
        
        //Get all available groups;
        $data["available_groups"] =$this->sql_helper->getAvailableGroups();
        
        $this->sql_helper->close();
        
        return $data;
    }
    
}

$data = new Get();
echo json_encode($data->retrieve());


?>
