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


class Assignments {
    
    /*
    *   Constructor.
    *   @params: string - $name, string - $lastname, string - $email, 
    *            string - $password, string - $groupname, string - $role
    *   @return: none
    */
	public function __construct($title, $task, $deadline) {
		$this->title = $title;
		$this->task = $task;
		$this->deadline = $deadline;
		
	}
	
    
    /*
    *   Validate the inputs.
    *   @params: none
    *   @return: none
    */
	public function checkInputs() {
	/*
        if (strlen($this->name) == 0) {
            result(false, "First name must be set");
            
        } else if (strlen($this->lastname) == 0) {
            result(false, "Last name must be set");
            
        } else if (strlen($this->email) == 0) {
            result(false, "Email must be set");
            
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            result(false, "Invalid email");
            
        } else if (strlen($this->password) == 0) {
            result(false, "Password must be set");
            
        } else if (strlen($this->password) <= 5) {
            result(false, "Password too short");

        } else if (strlen($this->groupname) == 0) {
            result(false, "Group name must be set");
            
		} else if (!in_array($this->role, $this->ROLES)) {
			result(false, "Role not found");
            
		} else {
            return true;
        }

        return false;
	*/
	}

public function create()
{
	$this->conn = connectDB();
	
	$assignmentID = $this->createAssignment();
	if($assignmentID <= 0)
	{
		result (false, "error inserting assignment");
		return;
	}
	
	$this->createReports($assignmentID);
	closeDB($this->conn);
	
}

private function createAssignment() {
	$stmt = $this->conn->prepare("INSERT INTO assignments (title, task, deadline) values(?,?,?)");
	$stmt->bind_param("sss", $this->title, $this->task, $this->deadline);
	if ($stmt->execute()) 
	{
	  $ID = mysqli_insert_id($this->conn);
	  return $ID;
        } 
        else 
        {
            die("An error occurred performing a request");
        }
}

private function createReports($assignmentID)
{	
	$data = $this->getGroupIDs();

	foreach ($data as &$row) {
		foreach ($data as &$row) {
			$groupID = $row["groupid"];
			$reportID = $this->createReport($assignmentID, $groupID);
			$row["reportid"] = $reportID;
		}
	}

	echo json_encode($data);

}

private function createReport($assignmentID, $groupid)
{
	$statusid = 1;
	$stmt = $this->conn->prepare("INSERT INTO reports (groupid, assignmentid, statusid) values (?,?,?)");
	$stmt->bind_param("iii", $groupid, $assignmentID, $statusid);
	if ($stmt->execute()) 
	{
	  $ID = mysqli_insert_id($this->conn);
	  return $ID;
        } 
        else 
        {
            die("An error occurred performing a request");
        }
}

private function getGroupIDs()
{
	$stmt = $this->conn->prepare("SELECT * FROM groups");
	
	if ($stmt->execute()) 
	   {
	   	$stmt->store_result();
	   	$stmt->bind_result($id, $name);
	   	$data = array();
	   	while($stmt->fetch())
	   	{
	   		$row = array();
			$row["groupid"] = $id;
			$row["reportid"] = -1;
	   		$data["" . $name] = $row;	
	   	}
	   	
	   	echo json_encode($data);
	   	
	   	$stmt->free_result();
            	$stmt->close();
            	return $data;
            	
        } else {
            die("An error occurred performing a request");
        }
	
}

    /*
    *   Check if user already exist in the database.
    *   @params: none
    *   @return: bool - $exist
    */

}
/*
if(!empty($_POST))
{
	$name = $_POST['name'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$groupname= $_POST['groupname'];
	$role = $_POST['role'];
	$signup = new Signup($name, $lastname, $email, $password, $groupname, $role);
	if ($signup->checkInputs()) {
	    $signup->register();
	}

}
else
{
	result(false, "Permission Denied");
}

*/

$title = "lggflex2";
$task = "Exampletext";
$deadline = "02/02/02";
$assignment = new Assignments($title, $task, $deadline);
$assignment->create();

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
?>
