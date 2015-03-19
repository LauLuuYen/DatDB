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


class ChangePassword {

    /*
    *
    *   @params: none
    *   @return: none
    */
	public function __construct($pw_o, $pw_1, $pw_2) {
        $this->userID = $_SESSION["userID"];
        $this->pw_o = trim($pw_o);
        $this->pw_1 = trim($pw_1);
        $this->pw_2 = trim($pw_2);
	}
	
	public function checkInputs() {
		if(strlen($this->pw_o) == 0 || is_null($this->pw_o)) {
			result(false, "Old password must be set");
            
		} else if (strlen($this->pw_1) == 0 || is_null($this->pw_1)) {
			result(false, "New password must be set");
            
		} else if(strlen($this->pw_1) < 5) {
			result(false, "New password too short");
            
		} else if($this->pw_1 != $this->pw_2) {
            result(false, "New passwords do not match");
            
		} else {
			return true;
		}
		return false;
	}
	
	public function change() {
        $this->pw_o = md5($this->pw_o);
        $this->pw_1 = md5($this->pw_1);
        $this->pw_2 = null;
        
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        $canchange = $this->sql_helper->can_changepassword($this->userID, $this->pw_o );
        if ($canchange) {
            $this->sql_helper->update_password($this->userID, $this->pw_1);
            result(true, "Success");
            
        } else {
            result(false, "Wrong password");
        }
 
        $this->sql_helper->close();
	}
	
}


require_once "session.php";

if($userSession->isLoggedInEither()) {
    if(!empty($_POST)) {
        $pw_o = $_POST["pwo"];
        $pw_1 = $_POST["pw1"];
        $pw_2 = $_POST["pw2"];
        $changer = new ChangePassword($pw_o, $pw_1, $pw_2);

        if($changer->checkInputs()) {
            $changer->change();
        }
    } else {
        result(false, "Error in request!");
    }
    
} else {
    result(false, "Session timeout");
}


?>
