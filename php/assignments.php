<?php

header("Access-Control-Allow-Origin: *");
define("DEBUG", true);

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


class Assignments {
    
    /*
    *   Constructor.
    *   @params: string - $name, string - $lastname, string - $email, 
    *            string - $password, string - $groupname, string - $role
    *   @return: none
    */
	public function __construct($title, $task, $deadline, $assessmentlist) {
		$this->title = strtolower(ucwords(trim($title)));
		$this->task = trim($task);
		$this->deadline = trim($deadline);
		$this->assessmentlist = trim($assessmentlist);
	}
	
    
    /*
    *   Validate the inputs.
    *   @params: none
    *   @return: none
    */
	public function checkInputs() {

        if (strlen($this->title) == 0 || is_null($this->title)) {
            result(false, "Title must be set");
    
        } else if (strlen($this->title) > 80) {
            result(false, "Title too long");
        
        } else if (strlen($this->task) == 0 || is_null($this->task)) {
            result(false, "Task must be set");

        } else if (strlen($this->task) > 800) {
            result(false, "Task too long");
            
        } else if (strlen($this->deadline) == 0 || is_null($this->deadline)) {
            result(false, "Deadline must be set");
        
        } else if (!$this->validDate($this->deadline)) {
            result(false, "Deadline not a date");
        
        } else if (!$this->validJSON($this->assessmentlist)) {
            result(false, "Assessment list not a JSON");
        
		} else {
            return true;
        }

        return false;

	}

    private function validDate($date) {
        $d = DateTime::createFromFormat("d/m/Y", $date);
        return $d && $d->format("d/m/Y") == $date;
    }
    
    private function validJSON($json) {
        $obj = json_decode($json);
        return $obj !== null;
    }
    
    private function reformatDate($date) {
        $parts = explode("/", $date);
        return $parts[2] . "/". $parts[1] . "/". $parts[0];
    }
    
    public function create() {
    
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        //Create the assignment
        $date = $this->reformatDate($this->deadline);

        $assignmentID = $this->sql_helper->createAssignment($this->title, $this->task, $date);
        if($assignmentID <= 0) {
            result (false, "error inserting assignment");
            return;
        }

        //Get Group reportIDs
        $data = $this->sql_helper->getGroupReportIDs();
        
        //Create a report for each group
        foreach ($data as &$row) {
            $groupID = $row["groupid"];
            $reportID = $this->sql_helper->createReport($assignmentID, $groupID);
            $row["reportid"] = $reportID;
        }
        
        //Decode the assessment list to start assigning
        $assessmentlist = json_decode($this->assessmentlist, true);
        
        //Create assessement report link
        foreach($assessmentlist as $key => $grouplist) {
            $groupID = $data["".$key]["groupid"];
        
            foreach($grouplist as $groupname) {
                $reportID = $data["".$groupname]["reportid"];
                
                if (!$this->sql_helper->createAssessment($groupID, $reportID)) {
                    result(false, "Error creating assessment");	
                    return;
                }
            }
     
        }
        
        result(true, "Success");

        $this->sql_helper->close();
    }

}


/*
$json_str = '{  
   "Zdafeefef 2":[  
      "Animatrix",
      "Zeldafans",
      "Theterminator"
   ],
   "Gangnam":[  
      "Parishilton",
      "It\'smorphintime!",
      "Housestark"
   ],
   "Parishilton":[  
      "It\'smorphintime!",
      "Zdafeefef 2",
      "Zeldafans"
   ],
   "Theterminator":[  
      "It\'smorphintime!",
      "Zdafeefef 2",
      "Housestark"
   ],
   "Housestark":[  
      "Animatrix",
      "Parishilton",
      "Theterminator"
   ],
   "Zeldafans":[  
      "Parishilton",
      "Animatrix",
      "Gangnam"
   ],
   "It\'smorphintime!":[  
      "Theterminator",
      "Gangnam",
      "Zdafeefef 2"
   ],
   "Animatrix":[  
      "Zeldafans",
      "Housestark",
      "Gangnam"
   ]
}';
*/
/*
$title = "Tit";
$task = "Exampletext113adfda3";
$deadline = "21/01/2015";
$assignment = new Assignments($title, $task, $deadline, $json_str);
if ($assignment->checkInputs()) {
    $assignment->create();
}
*/


require_once "session.php";

if($userSession->isLoggedIn()) {

    if(!empty($_POST)) {
    
        
        $title = $_POST["title"];
        $task = $_POST["task"];
        $deadline = $_POST["deadline"];
        $json_str = $_POST["assessment_list"];

        $assignment = new Assignments($title, $task, $deadline, $json_str);
        if ($assignment->checkInputs()) {
            $assignment->create();
        }
        

    } else {
        result(false, "Error in request!");
    }

} else {
    result(false, "Session timeout");
}



?>

