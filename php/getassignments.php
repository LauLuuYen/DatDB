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
	
    
    public function getAllAssignments() {
        require_once "session.php";
        
        if ($userSession->isLoggedIn()) {
            result(true, "Data");

        } else {
            result(false, "No userID");

        }
    }
}



$assignment = new Assignment();
$assignment->getAllAssignments();



?>
