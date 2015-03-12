<?php

header("Access-Control-Allow-Origin: *");
define("DEBUG", false);

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


class Report {

    /*
    *
    *   @params: none
    *   @return: none
    */
	public function __construct($reportID) {
        $this->reportID = $reportID

	}
	
	public function checkInputs()
	{
        if(!is_integer($this->reportID) || is_null($this->reportID)) {
			result(false, "reportID must be set");
            
		} else {
			return true;
		}
		return false;
	}
	
	public function finalise()
	{
        //TODO checkrole
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();

        //Get forum ID
        $forumID = $this->sql_helper->updateFinalReport($this->reportID);
        

		if ($success) {
			result(true, "Success");
		} else {
			result(false, $reponse.message);
		}
        
        $this->sql_helper->close();
	}
	
	
}


require_once "session.php";

if($userSession->isLoggedIn()) {

    if(!empty($_POST)) {
        $id = $_POST["reportID"];
        $report = new Report($id);
        
        if($report->checkInputs()) {
            $report->finalise();
        }
    } else {
        result(false, "Error in request!");
    }

} else {
    result(false, "Session timeout");
}



?>
