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


class DeleteUser {
    public function __construct($other_userID) {
        $this->userID = $_SESSION["userID"];
        $this->other_userID = (int)$other_userID;
    }
  
    public function checkInputs() {
        if (is_null($this->other_userID) || $this->other_userID == 0) {
            result(false, "Invalid userID");
        } else {
            return true;
        }
        return false;
    }
    
  	public function delete() {

        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();

        $success = $this->sql_helper->delete_user($this->other_userID);
        if ($success) {
            result(true, "User deleted");
        } else {
            result(false, "User does not exist");
        }
        
        $this->sql_helper->close();
  	}
  	
}
  
require_once "session.php";

if($userSession->isLoggedIn("admin"))  {

    if(!empty($_POST)) {

        $userID = $_POST["userID"];
        $deleter = new DeleteUser($userID);
        if ($deleter->checkInputs()) {
            $deleter->delete();
        }
            
    } else {
        result(false, "Error in request!");
    }
    } else {
    result(false, "Session timeout");
}



?>
