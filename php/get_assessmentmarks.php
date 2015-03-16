<?php

header("Access-Control-Allow-Origin: *");


class Get {

    public function __construct() {
        session_start();
        $this->groupID = $_SESSION["groupID"];
    }
	
    
    public function retrieve() {

        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        $data = array();
        
        //Get all assessment marks
        $data["assessments"] = $this->sql_helper->getAssessmentMarksInGroup($this->groupID);
        
        $this->sql_helper->close();
        
        return $data;
    }
    
}


$data = new Get();
echo json_encode($data->retrieve());

?>
