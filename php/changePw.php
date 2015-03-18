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
	public function __construct($password_o, $password1, $password2) {
        $this->userID = $_SESSION["userID"];
        $this->password_o = $password_o;
        $this->password1 = $password1;
        $this->password2 = $password2;
	}
	
	public function checkInputs() {
        if (strlen($this->password_o) == 0 || is_null($this->password_o)) {
			result(false, "Old password must be set");
            
		} else if (strlen($this->password1) == 0 || is_null($this->password2)) {
			result(false, "New password must be set");
            
        } else if (strlen($this->password1) < 5) {
            result(false, "New password too short");

        } else if ($this->password1 != $this->password2) {
            result(false, "New passwords do not match");
            
		} else {
			return true;
		}
		return false;
	}
	
	public function change() {
        //TODO checkrole
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();

        //Get forum ID
        $forumID = $this->sql_helper->getForumID($this->groupID);
        
        //Create thread
        $threadID = $this->sql_helper->createThread($forumID, $this->title);
        
        //Now create comment with it
		$success = $this->sql_helper->createComment($threadID, $this->comment, $this->userID);
        
		if ($success) {
			result(true, "Success");
		} else {
			result(false, "Failed to make thread");
		}
        
        $this->sql_helper->close();
	}
	
	
}


$password_o = "dfdg";
$password1 = "sfgsg";
$password2 = "bdbtn";
$changer = new ChangePassword($password_o, $password1, $password2);
if ($changer->checkInputs()) {
    echo "change";
}
/*
require_once "session.php";

if($userSession->isLoggedIn("student")) {

    if(!empty($_POST)) {
        $title = $_POST["title"];
        $comment = $_POST["comment"];
        $thread = new Thread($title, $comment);
        
        if($thread->checkInputs()) {
            $thread->makeThread();
        }
    } else {
        result(false, "Error in request!");
    }

} else {
    result(false, "Session timeout");
}
*/



?>
