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
        $this->userID = $userID;
        $this->comment = $comment;
        $this->threadID = $threadID;
	}
	
	public function checkInputs()
	{
		if(!is_int($this->userID))
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
		$forumID = $this->getForumID();
		$threadid = $this->createThread($forumID);
		echo "threadid: ". $threadid;
		closeDB($this->conn);
	}
	
	private function createThread($forumID )
	{
		$timestamp = date("Y-m-d H:i:s");
        
		$stmt = $this->conn->prepare("INSERT INTO thread (forumid, title, timestamp) VALUES(?,?,?)");
       		$stmt->bind_param("iss", $forumID, $this->title, $timestamp);
        	if ($stmt->execute()) {
	       		$threadid = mysqli_insert_id($this->conn);
	            	$stmt->close();
	  
	            	return $threadid;
	            
	        } 
	        else 
	        {
	            	die("An error occurred performing a request");
	        }
	}
	
	private function getForumID()
	{
		$stmt = $this->conn->prepare("SELECT id FROM forum WHERE groupid=(SELECT groupid FROM users WHERE id=?);");
	        $stmt->bind_param("i", $this->userID);
	
	        if ($stmt->execute()) {
	            $stmt->store_result();
	            $stmt->bind_result($userID);
	            
	            $registrant = $stmt->fetch();//Bind result with row
	            $stmt->close();
	
	            return $userID;
	            
	        } else {
	            die("An error occurred performing a request");
	        }
	}
	
}

$threadID = 51;
$userID = 31;
$input = "comments";
$comment = new Comment($userID, $comment, $threadID);

if($comment->checkInputs())
{
	$comment->makeComment();
}


?>
