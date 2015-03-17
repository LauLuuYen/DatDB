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


class commentEraser
{
    public function __construct($commentID) {
      
    $this->userID = $_SESSION["userID"];
    $this->commentID = (int)$commentID;
    }
  
    public function checkInputs() {
        if (is_null($this->commentID) || $this->commentID == 0) {
            result(false, "Invalid commentID");
        } else {
            return true;
        }
        return false;
    }
    
  	public function deleteComment()
  	{
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();

        $success = $this->sql_helper->deleteComment($this->commentID, $this->userID);

        $this->sql_helper->close();
        
        result(true, "Success");
  	}
  	
}
  
require_once "session.php";

if($userSession->isLoggedIn("student")) 
{

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

}
else
{
    result(false, "Session timeout");
}



?>
