<?php
header("Access-Control-Allow-Origin: *");
define("DEBUG", true);

if (DEBUG) {
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
}

require_once "include/config.php";
require_once "session.php";

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

class Forum
{
  public function __construct()
  {
    $this->userID = $_SESSION["userID"];
    $this->name = $_SESSION["name"];
    $this->lastname = $_SESSION["lastname"];
    $this->roleID = $_SESSION["roleID"];
    $this->groupID = $_SESSION["groupID"];
    
  }
  
  public function checkInputs()
  {
      //TODO check role
      return true;
  }
  
    public function retrieve()
    {
        require_once "sql_helper.php";
        $this->conn = connectDB();
        
        $data = array();
        $profile = array();
        $profile["userID"] = $this->userID;
        $profile["name"] = $this->name;
        $profile["lastname"] = $this->lastname;
        $profile["groupID"] = $this->groupID;
        
        $data["profile"] = $profile;
        
        //Get forumID
        $forumID = $sql_helper->getForumID($this->conn, $this->userID);
        
        //Get all threads
        $data["forum"] = $sql_helper->getAllThreads($this->conn, $forumID);
        
        //Go through every thread, find comments
        foreach($data["forum"] as &$thread) {
            $threadID = $thread["threadID"];
            $thread["comments"] = $sql_helper->getAllComments($this->conn, $threadID);
            
        }
        
        result(true, $data);
        
        closeDB($this->conn);
    }
  
  
}



if($userSession->isLoggedIn())
{
    $forum = new Forum();
    if($forum->checkInputs())
    {
        $forum->retrieve();
    }
}
else
{
    result(false, "Not logged in");
    
}


?>
