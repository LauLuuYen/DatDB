<?php

header("Access-Control-Allow-Origin: *");
define("DEBUG", true);

if (DEBUG) {
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
}

include "include/config.php";


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
	public function __construct($userID, $comment, $threadID) {
	        $this->userID = (int) $userID;
	        $this->comment = trim($comment);
	        $this->threadID = (int) $threadID;
	}
	
	public function checkInputs()
	{	
		if(!is_int($this->userID) || $this->userID <= 0)
		{
			result(false, "userID must be set");
		}
		else if(strlen($this->comment) === 0 || is_null($this->comment))
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
		$this->conn = connectDB();
		if($this->createComment())
		{
			result(true, "success");
		}
		else
		{
			result(false, "failed to create comment");
		}
		closeDB($this->conn);
	}
	
	private function createComment()
	{
		$timestamp = date("Y-m-d H:i:s");
        
		$stmt = $this->conn->prepare("INSERT INTO comment (threadid, comment, userid, timestamp) VALUES(?,?,?,?)");
       		$stmt->bind_param("isis", $this->threadID, $this->comment, $this->userID, $timestamp);
        	if ($stmt->execute()) {
	       		$commentid = mysqli_insert_id($this->conn);
	            	$success = $commentid > 0;
	            	$stmt->close();
	  
	            	return $success;
	            
	        } 
	        else 
	        {
	            	die("An error occurred performing a request");
	        }
	}
	
}

if(!empty($_POST))
{
	$threadID = $_POST["threadID"];
	$userID = $_POST["userID"];
	$input = $_POST["comment"];
	$comment = new Comment($userID, $input, $threadID);

	if($comment->checkInputs())
	{
		$comment->makeComment();
	}
}
else
{
	result(false, "Permission Denied");
}




?>
