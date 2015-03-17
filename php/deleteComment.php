<?php

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
        
        $url = "http://" . $_SERVER["HTTP_HOST"]."/forum";
        header("Location: " . $url);
  	}
  	
}
  
require_once "session.php";

if($userSession->isLoggedIn("student")) 
{
    $commentID = 241;
    $commentEraser = new commentEraser($commentID);

    if ($commentEraser->checkInputs()) {
        $commentEraser->deleteComment();
    }
      
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
