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


class Comment {

    /*
    *
    *   @params: none
    *   @return: none
    */
	public function __construct($comment, $threadID) {
        $this->userID = $_SESSION["userID"];
        $this->comment = trim($comment);
        $this->threadID = (int) $threadID;
	}
	
	public function checkInputs()
	{	
		if(strlen($this->comment) === 0 || is_null($this->comment))
		{
			result(false, "comment must be set");
		}
		/*
		else if(strlen($this->comment) > 50))
		{
			result(false, "comment too long");
		}
		*/
		else if(!is_int($this->threadID))
		{
			result(false, "threadID must be set");
		}
		else
		{
			return true;
		}
		return false;
	}
	
	public function makeComment()
	{
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        $success = $this->sql_helper->createComment($this->threadID, $this->comment, $this->userID);
        
		if ($success) {
			result(true, "Success");
		} else {
			result(false, "Failed to create comment");
		}
        
        $this->sql_helper->close();
        
	}
	

	
}


    
require_once "session.php";

if($userSession->isLoggedIn()) {

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
    
} else {
    result(false, "Session timeout");
}

?>
