<?php

  class commentEraser
  {
    public function __construct($commentID) {
      
    $this->userID = $_SESSION["userID"];
    $this->commentID = $commentID;
    }
  
  	public function deleteComment()
  	{
  		require_once "include/sql_helper.php";
          $this->sql_helper = new SQL_Helper();
          echo "a";
          echo $this->userID;
          $success = $this->sql_helper->deleteComment($this->commentID, $this->userID);
          echo "test";
          $this->sql_helper->close();
          $url = "http://" . $_SERVER["HTTP_HOST"]."/forum";
          header("Location: " . $url);
  	}
  	
  }
  
    require_once "session.php";
    if($userSession->isLoggedIn("student")) 
    {
      $commentID = 171;
      $commentEraser = new commentEraser($commentID);
      $commentEraser->deleteComment();
      
    /*  if(!empty($_POST)) 
      {
          $threadID = $_POST["threadID"];
          $input = $_POST["comment"];
          $comment = new Comment($input, $threadID);
          if($comment->checkInputs()) 
          {
            $comment->makeComment();
          }
      } 
      else 
      {
        result(false, "Error in request!");
      }*/
    } 
    else 
    {
    result(false, "Session timeout");
    }



?>
