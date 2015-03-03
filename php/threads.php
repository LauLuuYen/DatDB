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


class Thread {

    /*
    *
    *   @params: none
    *   @return: none
    */
	public function __construct($userID, $title, $comment) {
        $this->userID = $userID;
        $this->title = $title;
        $this->comment = $comment;

	}
	
	public function checkInputs()
	{
		if(!is_int($this->userID))
		{
			result(false, "userID must be set");
		}
		else if(strlen($this->title) === 0 || is_null($this->title))
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
		/*
		else if(strlen($this->comment) > 50))
		{
			result(false, "comment too long");
		}
		*/
		else
		{
			return true;
		}
		return false;
	}
	
	public function makeThread()
	{
		$this->conn = connectDB();
		$forumID = $this->getForumID();
		echo "forumid: ". $forumID;
		closeDB($this->conn);
	}
	
	private function createThread()
	{
		
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



$userID = 31;
$title = "title";
$comment = "comments";

$thread = new Thread($userID, $title, $comment);

if($thread->checkInputs())
{
	echo "making thread\n";
	$thread->makeThread();
}


?>
