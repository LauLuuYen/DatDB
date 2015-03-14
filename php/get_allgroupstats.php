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
        $data["groups"] = $this->sql_helper->getAllGroups();
        
        foreach($data["groups"] as &$group) {
            $groupID = $group["groupID"];
            //Get users in group
            $group["users"] = $this->sql_helper->getAllStudentInGroup($groupID);
            $group["assessments"] = $this->sql_helper->getAllAssessmentsInGroup($groupID);
            $group["reports"] = $this->sql_helper->getAllReportsInGroup($groupID);
        }
        
        $this->sql_helper->close();
        
        return $data;
    }
    
}

$data = new Get();
echo json_encode($data->retrieve());


?>
