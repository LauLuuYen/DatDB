<?php
header("Access-Control-Allow-Origin: *");
define("DEBUG", true);
if (DEBUG) {
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
}

require_once("include/config.php");
require_once("helper.php");
require_once("session.php");

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
        echo "step1";
      $this->conn = connectDB();
      echo "step2";
      $forumID = $helper->getForumID($this->conn, $this->userID);
      echo "forum :"  .$forumID;
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
