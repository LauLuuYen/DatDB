<?php

header("Access-Control-Allow-Origin: *");


class Assignment {

    public function __construct() {
        session_start();
        $this->userID = $_SESSION["userID"];
        $this->name = $_SESSION["name"];
        $this->lastname = $_SESSION["lastname"];
        $this->roleID = $_SESSION["roleID"];
        $this->groupID = $_SESSION["groupID"];
    }
	
    
    public function retrieve() {
         //TODO check role
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        $data = array();
        $profile = array();
        $profile["userID"] = $this->userID;
        $profile["name"] = $this->name;
        $profile["lastname"] = $this->lastname;
        $profile["groupID"] = $this->groupID;
        
        $data["profile"] = $profile;
        
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


$assignment = new Assignment();


?>
