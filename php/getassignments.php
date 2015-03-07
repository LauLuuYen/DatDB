<?php

header("Access-Control-Allow-Origin: *");
define("DEBUG", false);

if (DEBUG) {
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
}

require_once "include/config.php";


class Assignment {


    public function __construct() {
        $this->userID = $_SESSION["userID"];
        $this->name = $_SESSION["name"];
        $this->lastname = $_SESSION["lastname"];
        $this->roleID = $_SESSION["roleID"];
        $this->groupID = $_SESSION["groupID"];
    }
	
    
    public function retrieve() {
         //TODO check role
        require_once "sql_helper.php";
        $this->conn = connectDB();
        
        $data = array();
        $profile = array();
        $profile["userID"] = $this->userID;
        $profile["name"] = $this->name;
        $profile["lastname"] = $this->lastname;
        $profile["groupID"] = $this->groupID;
        
        $data["profile"] = $profile;
        
        //Get all assignments
        $data["assignments"] = $sql_helper->getReportAssignments($this->conn, $this->groupID);
        
        //Go through every assignment, find assessment
        foreach($data["assignments"] as &$assignment) {
            $assignmentID = $assignment["id"];
            $assignment["assessments"] = $sql_helper->getAssessments($this->conn, $this->groupID, $assignmentID);
        }

        closeDB($this->conn);
        
        return $data;
    }
    
}


$assignment = new Assignment();



?>
