<?php

header("Access-Control-Allow-Origin: *");


class AdminInfo {

    public function __construct() {
        session_start();
        $this->userID = $_SESSION["userID"];
        $this->name = $_SESSION["name"];
        $this->lastname = $_SESSION["lastname"];
        $this->roleID = $_SESSION["roleID"];
        $this->groupID = $_SESSION["groupID"];
    }
	
    
    public function retrieve() {
        
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
        $data["assignments"] = $this->sql_helper->getAllAssignments();

        //Get all available groups;
        $data["available_groups"] =$this->sql_helper->getAvailableGroups();
        
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

$adminInfo = new AdminInfo();

?>
