<?php

header("Access-Control-Allow-Origin: *");


class Get {

    public function __construct() {
        session_start();
        $this->groupID = $_SESSION["groupID"];
    }
  

    public function retrieve() {
         //TODO check role
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();

        $data = array();
        
        //Get forumID
        $forumID = $this->sql_helper->getForumID($this->groupID);
        
        //Get all threads
        $threads = $this->sql_helper->getAllThreads($forumID);
        
        //Go through every thread, find comments
        foreach($threads as &$thread) {
            $threadID = $thread["threadID"];
            $thread["comments"] = $this->sql_helper->getAllComments($threadID);
        }
        
        $data["forum"]["threads"] = $threads;
        
        $this->sql_helper->close();
        
        return $data;
    }
  
}

$data = new Get();
echo json_encode($data->retrieve());

?>
