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


class Thread {

    /*
    *
    *   @params: none
    *   @return: none
    */
	public function __construct($title, $comment) {
        $this->userID = $_SESSION["userID"];
        $this->groupID = $_SESSION["groupID"];
        $this->title = $title;
        $this->comment = $comment;

	}
	
	public function checkInputs()
	{
        if(strlen($this->title) === 0 || is_null($this->title))
		{
			result(false, "title must be set");
		}
		else if(strlen($this->title) > 50)
		{
			result(false, "title too long");
		}
		else if(strlen($this->comment) === 0 || is_null($this->comment))
		{
			result(false, "comment must be set");
		}
		else if (strlen($this->comment) > 500)
		{
			result(false, "comment too long");
		}
		else
		{
			return true;
		}
		return false;
	}
	
	public function makeThread()
	{
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


require_once "session.php";

if($userSession->isLoggedIn()) {

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



?>
