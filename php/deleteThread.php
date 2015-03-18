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


class threadEraser
{
    public function __construct($threadID) {
      
    $this->userID = $_SESSION["userID"];
    $this->threadID = (int)$threadID;
    }
  
    public function checkInputs() {
        if (is_null($this->threadID) || $this->threadID == 0) {
            result(false, "Invalid threadID");
        } else {
            return true;
        }
        return false;
    }
    
  	public function deleteThread()
  	{
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();

        $sqlThreadOwner = $this->sql_helper->getThreadOwner($this->threadID);
        
        echo "sql thread owner is: " . $sqlThreadOwner;
        
        if($sqlThreadOwner == $this->userID)
        {
            echo ("You are the thread owner");
            //DELETE COMMENT
        }
        else
        {
            echo ("You are not the thread owner");
        }

        $this->sql_helper->close();
        
        result(true, "Success");
  	}
  	
}
  
require_once "session.php";

if($userSession->isLoggedIn("student")) 
{

        $threadID = 21;
        $threadEraser = new threadEraser($threadID);

        if ($threadEraser->checkInputs()) {
            $threadEraser->deleteThread();
        }

/*
    if(!empty($_POST)) {
        $commentID = $_POST["commentID"];
        $commentEraser = new commentEraser($commentID);

        if ($commentEraser->checkInputs()) {
            $commentEraser->deleteComment();
        }
    }
    else
    {
        result(false, "Error in request!");
    }
    */
}
else
{
    result(false, "Session timeout");
}



?>
