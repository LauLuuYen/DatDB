<?php

header("Access-Control-Allow-Origin: *");
define("DEBUG", false);

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

		} else if (!in_array($this->role, $this->ROLES)) {
			result(false, "Role not found");
        
        //A student needs to have a group
        } else if ($this->role == $this->ROLES[1] &&
            (strlen($this->groupname) == 0 || is_null($this->groupname))) {
            result(false, "Group name must be set");
            
            
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
    public function registerUser() {
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        //Check if user exist
        $exist = $this->sql_helper->checkExist($this->email);
        if ($exist) {
            result(false, "User already exist!");
            return;
        }
        
        //Get RoleID
        $roleID = $this->sql_helper->getRoleID($this->role);
        
        //Create Admin account
        if ($this->role == $this->ROLES[0]) {
            
            $this->createAdmin($roleID);
            
        //Create Student account
        } else {
            
            $this->createStudent($roleID);
        
        }
        
        
        $this->sql_helper->close();
    }

    /*
    *   Create admin account only
    *   @params: int - $roleID
    *   @return: none
    */
    private function createAdmin($roleID) {
    
        if ($this->sql_helper->createUser($this->name, $this->lastname, $this->email, $this->password, $roleID, null)){
            result(true, "Success");
        
        } else {
            result(false, "Failed to create user account");
        }

    }
    
    
    /*
    *   Create student account, assign to group with forum
    *   @params: int - $roleID
    *   @return: none
    */
    private function createStudent($roleID) {
    
        $count = $this->sql_helper->getGroupSize($this->groupname);
		if ($count >= 3) {
			result(false, "Group is full");
			return;

		} else if ($count == 0) {
			$groupID = $this->sql_helper->createGroup($this->groupname);
            $forumID = $this->sql_helper->createForum($groupID);
            		
		} else {
			$groupID = $this->sql_helper->getGroupID($this->groupname);
		}

        if ($this->sql_helper->createUser($this->name, $this->lastname, $this->email, $this->password, $roleID, $groupID)){
            result(true, "Success");
        
        } else {
            result(false, "Failed to create user account");
        }
        
    }
    
}

/*
//Only admins allowed to assign
$name = "Jack2";
$lastname = "Black2";
$email = "mario@castlsg.com";
$password = "abc123";
$groupname= "Housestark";
$role = "Student";

$signup = new Signup($name, $lastname, $email, $password, $groupname, $role);
if ($signup->checkInputs()) {
    $signup->registerUser();
}
*/
require_once "session.php";

if($userSession->isLoggedIn()) { //TODO make admin only in session

    if(!empty($_POST)) {
        $name = $_POST["name"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $groupname= $_POST["groupname"];
        $role = $_POST["role"];
        
        $signup = new Signup($name, $lastname, $email, $password, $groupname, $role);
        if ($signup->checkInputs()) {
            $signup->registerUser();
        }
        
    } else {
        result(false, "Permission Denied");
    }

} else {
    result(false, "Session timeout");
}



?>
