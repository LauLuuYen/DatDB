<?php

header("Access-Control-Allow-Origin: *");
define("DEBUG", true);

if (DEBUG) {
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
}


/*
*   Echoes to the client the result of the process.
*   @params: bool - $success, string - $msg
*   @return: none
*/
function result($success, $msg) {
      $response["success"] = $success;
      $response["message"] = $msg;
      echo json_encode($response);
}


class Assessment{

    public function __construct($reportID, $feedback, $score) {
        $this->userID = $_SESSION["userID"];
        $this->groupID = $_SESSION["groupID"];
        $this->reportID = (int) $reportID;
        $this->feedback = $feedback;
        $this->score = (int) $score;
    }
  
    public function checkInputs() {
        if(is_null($this->reportID) || $this->reportID == 0) {
            result(false, "reportID must be set");

        } else if(strlen($this->feedback) === 0 || is_null($this->feedback)) {
            result(false, "Feedback must be set");

        } else if(strlen($this->feedback) > 500) {
            result(false, "Feedback is too long");

        } else if(is_null($this->score) || $this->score == 0) {
            result(false, "score must be set");

        } else {
            return true;

        }
        return false;
    }
  
    public function submitAssessment() {
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();

        $success = $this->sql_helper->updateAssessment($this->feedback, $this->score, $this->userID, $this->groupID, $this->reportID);
        if ($success) {
            result(true,"Success!");
        } else {
            result(false, "Failed to create assessment");
        }

        $this->sql_helper->close();
    }
  
}


require_once "session.php";

if($userSession->isLoggedIn()) {

    if(!empty($_POST)) {
        $reportID = $_POST["reportID"];
        $feedback = $_POST["feedback"];
        $score = $_POST["score"];

        $assessment = new Assessment($reportID, $feedback, $score);
        if($assessment->checkInputs()) {
            $assessment->submitAssessment();
        }
        
    } else {
        result(false, "Error in request!");
    }
    
} else {
    result(false, "Session timeout");
}
  
?>
