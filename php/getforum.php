<?php

header("Access-Control-Allow-Origin: *");
define("DEBUG", false);

if (DEBUG) {
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
}


class Forum {
    public function __construct() {
        $this->userID = $_SESSION["userID"];
        $this->name = $_SESSION["name"];
        $this->lastname = $_SESSION["lastname"];
        $this->roleID = $_SESSION["roleID"];
        $this->groupID = $_SESSION["groupID"];
    }
  

    public function retrieve() {
         //TODO check role
        require_once "include/sql_helper.php";
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
        $threads = $this->sql_helper->getAllThreads($forumID);
        
        //Go through every thread, find comments
        foreach($threads as &$thread) {
            $threadID = $thread["threadID"];
            $thread["comments"] = $this->sql_helper->getAllComments($threadID);
            //
        }
        
        $data["forum"]["threads"] = $threads;
        
        $this->sql_helper->close();
        
        return $data;
    }
  
}


$forum = new Forum();


?>
