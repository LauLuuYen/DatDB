<?php

header("Access-Control-Allow-Origin: *");


class Get {

    public function __construct() {
        session_start();
        
        $this->groupID = $_SESSION["groupID"];
    }
	
    private function getRatio($arr) {
        $i=0;
        $j=0;
        foreach($arr as $row) {
            if ($row["status"] == "Complete") {
                $j++;
            }
            $i++;
        }
        return $j."/".$i;
    }
    public function retrieve() {
        
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();

        $data = array();

        
        $data["assignments"] = $this->sql_helper->count_assignments();
        $data["groups"] = $this->sql_helper->count_groups();
        $data["reports"] = $this->sql_helper->count_reports();
        $data["assessments"] = $this->sql_helper->count_assessments();
        $data["students"] = $this->sql_helper->count_students();
        
        $this->sql_helper->close();
        
        return $data;
    }
    
}

$data = new Get();
echo json_encode($data->retrieve());


?>
