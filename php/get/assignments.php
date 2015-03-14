<?php

header("Access-Control-Allow-Origin: *");


class Get {

    public function __construct() {
        session_start();
        $this->groupID = $_SESSION["groupID"];
    }
	
    
    public function retrieve() {

        require_once "../include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        $data = array();
        
        //Get all assignments
        $data["assignments"] = $this->sql_helper->getReportAssignments($this->groupID);
        
        //Go through every assignment, find assessment
        foreach($data["assignments"] as &$assignment) {
            $assignmentID = $assignment["id"];
            $assignment["assessments"] = $this->sql_helper->getAssessments($this->groupID, $assignmentID);
        }

        $this->sql_helper->close();
        
        return $data;
    }
    
}


$data = new Get();


?>
