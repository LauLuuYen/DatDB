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



class Assignment {


	public function __construct() {
        //
	}
	
    public function verifyUser() {
        require_once "session.php";
        
        $userID = $userSession->getSessionVal("userID");
        if (is_null($userID)) {
            result(false, "No userID");
            return false;
        }
        
        
        //More checks
        return true;
        
    }
    
    public function getAllAssignments() {

        result(true, "Data");

    }
}



$assignment = new Assignment();
if ($assignment->verifyUser()) {
    $assignment->getAllAssignments();
}


?>
