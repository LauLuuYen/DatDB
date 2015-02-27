<?php

  header("Access-Control-Allow-Origin: *");
  define("DEBUG", true);
  if (DEBUG) {
      ini_set("display_errors",1);
      ini_set("display_startup_errors",1);
      error_reporting(E_ALL & ~E_NOTICE);
  }
  include "include/config.php";
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

class Assessment{

  public function __construct($groupID, $reportID, $feedback, $score, $userID)
  {
    $this->groupID = $groupID;
    $this->reportID = $reportID;
    $this->feedback = $feedback;
    $this->score = $score;
    $this->userID = $userID;
  }   
  
  public function checkInputs()
  {
    
    if(!is_int($this->groupID))
    {
      result(false, "groupID must be set");
      
    }
    else if(!is_int($this->reportID))
    {
      result(false, "reportID must be set");
    }
    else if(strlen($this->feedback) === 0)
    {
      result(false, "feedback must be set");
    }
    else if(!is_int($this->score))
    {
      result(false, "score must be set");
    }
    else if(!is_int($this->userID))
    {
      result(false, "userID must be set");
    }
    else
    {
      return true;
    }
    return false;
  }
  
}

  //$groupID = 21;
  //$reportID = 2071;
  //$feedback = "Princess Latifa";
  //$score = 4;
  //$userID = 51;
  
  $groupID = 21;
  $reportID = null;
  $feedback = "Princess Latifa";
  $score = 4;
  $userID = 51;
  
  $assessment = new Assessment($groupID, $reportID, $feedback, $score, $userID);
  
  if($assessment->checkInputs())
  {
    echo "checkInputs function run";
  }
  
  
?>
