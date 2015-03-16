<?php

  class commentEraser
  {
    public function __construct($commentID, $userID) {
    $this->userID = $_SESSION["userID"];
    $this->commentID = $commentID;
    }
  
  	public function deleteComment()
  	{
  		require_once "include/sql_helper.php";
          $this->sql_helper = new SQL_Helper();
  
          $success = $this->sql_helper->deleteComment($this->commentID, $this->userID);
  
          if ($success) {
  			result(true, "Success");
  		} else {
  			result(false, "Failed to delete comment");
  		}
          
          $this->sql_helper->close();
  
  	}
  	
  }
  
  

?>
