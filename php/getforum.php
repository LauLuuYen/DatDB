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


require_once "session.php";

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
  

    public function retrieve()
    {
         //TODO check role
        require_once "sql_helper.php";
        $this->sql_helper = new SQL_Helper();

        
        $data = array();
        $profile = array();
        $profile["userID"] = $this->userID;
        $profile["name"] = $this->name;
        $profile["lastname"] = $this->lastname;
        $profile["groupID"] = $this->groupID;
        
        $data["profile"] = $profile;
        
        //Get forumID
        $forumID = $this->sql_helper->getForumID($this->groupID);
        
        //Get all threads
        $data["forum"] = $this->sql_helper->getAllThreads($forumID);
        
        //Go through every thread, find comments
        foreach($data["forum"] as &$thread) {
            $threadID = $thread["threadID"];
            $thread["comments"] = $this->sql_helper->getAllComments($threadID);
            //
        }
        
        result(true, $data);
        
        $this->sql_helper->close();
    }
  
  
}



if($userSession->isLoggedIn())
{
    $forum = new Forum();
    $forum->retrieve();
    
}
else
{
    result(false, "Not logged in");
}


?>
