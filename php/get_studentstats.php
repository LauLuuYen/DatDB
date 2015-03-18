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

        
        $reports = $this->sql_helper->get_reportStats($this->groupID);
        $asessments_s = $this->sql_helper->get_assessmentSentStats($this->groupID);
        $asessments_r = $this->sql_helper->get_assessmentReceivedStats($this->groupID);
        
        $data["mark"] = $this->sql_helper->getAggregateMark($this->groupID);
        $data["reports"] = $this->getRatio($reports);
        $data["assessments_s"] = $this->getRatio($asessments_s);
        $data["assessments_r"] = $this->getRatio($asessments_r);
        
        $this->sql_helper->close();
        
        return $data;
    }
    
}

$data = new Get();
echo json_encode($data->retrieve());


?>
