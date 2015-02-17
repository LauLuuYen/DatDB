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

public function createAssignment()
{
	echo 'ladyboy';
	$this->createReports();
}

private function createReports()
{
	$this->getGroupIDs();
}

private function getGroupIDs()
{
	$this->conn = connectDB();
	$stmt = $this->conn->prepare("SELECT * FROM groups");
	
	   if ($stmt->execute()) 
	   {
	   	$stmt->store_result();
	   	$stmt->bind_result($id, $name);
	   	$data = array();
	   	while($stmt->fetch())
	   	{
	   	$data["" . $name] = $id;	
	   	}
	   	echo json_encode($data);
	   	$stmt->free_result();
            $stmt->close();
        } else {
            die("An error occurred performing a request");
        }
	
	closeDB($this->conn);
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
$assignment->createAssignment();

?>
