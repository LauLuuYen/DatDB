<?php

header("Access-Control-Allow-Origin: *");


class Get {

    public function __construct() {
        //
    }
	
    
    public function retrieve() {
        
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        $data = array();
        
        //Get all assignments
        $data["assignments"] = $this->sql_helper->getAllAssignments();
        
        $this->sql_helper->close();
        
        return $data;
    }
    
}

$adminInfo = new Get();
echo json_encode($adminInfo->retrieve);


?>
