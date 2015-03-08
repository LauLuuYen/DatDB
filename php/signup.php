<?php

header("Access-Control-Allow-Origin: *");
define("DEBUG", true);

if (DEBUG) {
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
}

include "include/config.php";//TODO remove


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


class Signup {

    private $ROLES = array("admin", "student");
    
    /*
    *   Constructor.
    *   @params: string - $name, string - $lastname, string - $email, 
    *            string - $password, string - $groupname, string - $role
    *   @return: none
    */
	public function __construct($name, $lastname, $email, $password, $groupname, $role) {
		$this->name = ucfirst(strtolower(trim($name)));
		$this->lastname = ucfirst(strtolower(trim($lastname)));
		$this->email = strtolower(trim($email));
		$this->password = $password;
        $this->groupname = ucfirst(strtolower(trim($groupname)));
        $this->role = strtolower(trim($role));
	}
	
    
    /*
    *   Validate the inputs.
    *   @params: none
    *   @return: none
    */
	public function checkInputs() {
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
	}
	

    /*
    *   Attempt to register to user and assign user
    *   @params: none
    *   @return: none
    */
	public function register() {
        //Connect to DB
	    $this->conn = connectDB();
	    
        //If user does not exist, create account and assign their roles
        if (!$this->checkExist()) {
        	$this->assignGroup();
        }

        //TODO consider admin
        
        //Close DB connection
        closeDB($this->conn);
	}
	


    /*
    *   Create an empty group.
    *   @params: none
    *   @return: int - $groupID
    */
	private function createGroup()
	{
		$stmt = $this->conn->prepare("INSERT INTO groups (name) VALUES(?)");
        $stmt->bind_param("s", $this->groupname);

        if ($stmt->execute()) {
            $groupID = mysqli_insert_id($this->conn);
            $stmt->close();
            return $groupID;
            
        } else {
            die("An error occurred performing a request");
        }
	}
	
	private function createForum($groupID)
	{
		$stmt = $this->conn->prepare("INSERT INTO forum (groupid) VALUES(?)");
	        $stmt->bind_param("i", $groupID);
	
	        if ($stmt->execute()) {
	            $forumID = mysqli_insert_id($this->conn);
	            $stmt->close();
	            return $forumID;
	            
	        } else {
	            die("An error occurred performing a request");
	        }
	}
    

    /*
    *   Get groupID of an existing group
    *   @params: none
    *   @return: int - $groupID
    */
	private function getGroupID()
	{
		$stmt = $this->conn->prepare("SELECT id FROM groups WHERE name=?");
        $stmt->bind_param("s", $this->groupname);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($groupID);
            
            $registrant = $stmt->fetch();//Bind result with row
            $stmt->close();

            return $groupID;
            
        } else {
            die("An error occurred performing a request");
        }
	}
	
    
    /*
    *   Get roleID of the role
    *   @params: none
    *   @return: int - $roleID
    */
	private function getRoleID() {
		$stmt = $this->conn->prepare("SELECT id FROM roles WHERE name=?");
        $stmt->bind_param("s", $this->role);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($roleID);
            
            $registrant = $stmt->fetch();//Bind result with row
            $stmt->close();

            return $roleID;
            
        } else {
            die("An error occurred performing a request");
        }
	}
	

    /*
    *   Create user into the database
    *   @params: none
    *   @return: bool - $success
    */
	private function createUser($roleID, $groupID)
	{
        $password = md5($this->password);
        $timestamp = date("Y-m-d H:i:s");
        
		$stmt = $this->conn->prepare("INSERT INTO users (name, lastname, email, password, roleid, groupid, timestamp) VALUES(?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssiis", $this->name, $this->lastname, $this->email, $password, $roleID, $groupID, $timestamp);

        if ($stmt->execute()) {
       		$id = mysqli_insert_id($this->conn);
            $success = $id > 0;
            $stmt->close();
            
            //Signing up is done by admin

            return $success;
            
        } else {
            die("An error occurred performing a request");
        }
	}
	

    
    /*
    *   Attempt to assign user to a group
    *   @params: none
    *   @return: none
    */
	private function assignGroup()
	{
		$count = $this->getGroupSize();
        
		if ($count >= 3) {
			result(false, "Group is full");
			return;

		} else if ($count == 0) {
			$groupID = $this->createGroup();
            		$forumID = $this->createForum($groupID);
            		
		} else {
			$groupID = $this->getGroupID();
		}

        $roleID = $this->getRoleID();
        
        //RoleID and groupID gathered, now create user.
		if ($this->createUser($roleID, $groupID)) {
            result(true, "User has been created successfully");
        } else {
            result(false, "Error creating User");
        }

	}
	
    
    /*
    *   Count the number of users in that specified group
    *   @params: none
    *   @return: bool - $exist
    */
	private function getGroupSize()
	{
		$stmt = $this->conn->prepare("SELECT count(*) AS groupcount FROM users WHERE groupid = (SELECT id FROM groups WHERE name=?)");
        $stmt->bind_param("s", $this->groupname);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($groupcount);
            
            $registrant = $stmt->fetch();//Bind result with row
            $stmt->close();

            return $groupcount;
            
        } else {
            die("An error occurred performing a request");
        }
	}


    /*
    *   Check if user already exist in the database.
    *   @params: none
    *   @return: bool - $exist
    */
    private function checkExist() {
		$stmt = $this->conn->prepare("SELECT email FROM Users WHERE email = ?");
        $stmt->bind_param("s", $this->email);

        if ($stmt->execute()) {
            $registrant = $stmt->fetch();
            $stmt->close();

            if (count($registrant) > 0) {
                result(false, "User already exist");
                return true;
            }
            return false;
            
        } else {
            die("An error occurred performing a request");
        }
    }
    
}

/*
$name = "Jack";
$lastname = "Black";
$email = "jackblack@ucl.ac.uk";
$password = "abc123";
$groupname= "ParisHilton";
$role = "studENt";

$signup = new Signup($name, $lastname, $email, $password, $groupname, $role);
if ($signup->checkInputs()) {
    $signup->register();
}

*/


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



?>
