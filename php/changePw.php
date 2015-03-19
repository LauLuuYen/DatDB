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
        echo "changepassword";
        /*
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        $success = $this->sql_helper->createComment($this->threadID, $this->comment, $this->userID);
        
		if ($success) {
			result(true, "Success");
		} else {
			result(false, "Failed to create comment");
		}
        
        $this->sql_helper->close();
        */
	}
	

	
}


require_once "session.php";

if($userSession->isLoggedIn()) {
    $pw_o = "sfgg";
    $pw_1 = "adf";
    $pw_2 = "adfdfg";
    $changer = new ChangePassword($pw_o, $pw_1, $pw_2);

    if($changer->checkInputs()) {
        $changer->change();
    }
    
} else {
    result(false, "Session timeout");
}
/*


    if(!empty($_POST)) {
        $threadID = $_POST["threadID"];
        $input = $_POST["comment"];
        $comment = new Comment($input, $threadID);

        if($comment->checkInputs()) {
            $comment->makeComment();
        }
    } else {
        result(false, "Error in request!");
    }
    
*/

?>
