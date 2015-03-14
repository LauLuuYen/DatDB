<?php

header("Access-Control-Allow-Origin: *");


class Get {

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
        
        $this->sql_helper->close();
        
        return $data;
    }
    
}

$data = new Get();
echo json_encode($data->retrieve());


?>
