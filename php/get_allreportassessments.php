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
        
        $data["groups"] = $this->sql_helper->getAllGroups();
        $data["reports"] = $this->sql_helper->getAllReports();
        $data["assessments"] = $this->sql_helper->getAllAssessments();
        
        $this->sql_helper->close();
        
        return $data;
    }
    
}

$data = new Get();
echo json_encode($data->retrieve());


?>
