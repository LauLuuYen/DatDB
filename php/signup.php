<?php
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set("GMT");
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
    include "include/config.php";

    function result($success, $message) {
        $response["success"] = $success;
        $response["message"] = $message;
        echo json_encode($response);
    }
  

class Signup {

	public function __construct($name, $lastname, $email, $password, $groupname, $role) {
		$this->name = ucfirst(strtolower(trim($name)));
		$this->lastname = ucfirst(strtolower(trim($lastname)));
		$this->email = strtolower(trim($email));
		$this->password = md5($password);
        $this->groupname = ucfirst(strtolower(trim($groupname)));
        	$this->role = strtolower(trim($role));
	}
	
	public function checkInputs() {
		
		//Check role is valid
		$ROLES = array("admin", "student");
		if (!in_array($this->role, $ROLES)) {
			results(false, "Role not found");
			return false;
		}
		return true;
	}
	
	public function register() {
        //Connect to DB
	    $this->conn = connectDB();
	    
        if (!$this->checkExist()) {
        	$this->assignGroup();
        }
	

	}
	
	private function getRoleID() {
		$stmt = $this->conn->prepare("SELECT id FROM roles WHERE name = ?");
		$stmt->bindValue(1, $this->role);
		$stmt->execute();		
		$registrants = $stmt->fetchAll();
		$roleID = $registrants[0]["id"];
		return $roleID;
	}
	
	private function createGroup()
	{
		$stmt = $this->conn->prepare("INSERT INTO groups (name) VALUES(?)");
		$stmt->bindValue(1, $this->groupname);
		$stmt->execute();		
		$groupID = $this->conn->lastInsertId();
		return $groupID;
	}
	
	private function createUser()
	{
		$stmt = $this->conn->prepare("INSERT INTO users (name, lastname, email, password, timestamp) VALUES(?,?,?,?,?)");
		$stmt->bindValue(1, $this->name);
		$stmt->bindValue(2, $this->lastname);
		$stmt->bindValue(3, $this->email);
		$stmt->bindValue(4, $this->password);
		$stmt->bindValue(5, date("Y-m-d H:i:s"));
		$stmt->execute();		
		$userID = $this->conn->lastInsertId();
		return $userID;
	}
	
	private function assignUserGroup($userID, $groupID)
	{
		$stmt = $this->conn->prepare("INSERT INTO usergroups (userid, groupid) VALUES(?,?)");
		$stmt->bindValue(1, $userID);
		$stmt->bindValue(2, $groupID);
		$stmt->execute();		
		$id = $this->conn->lastInsertId();
		return $id;
	}
	
	private function assignUserRole($userID, $roleID)
	{
		$stmt = $this->conn->prepare("INSERT INTO userroles (userid, roleid) VALUES(?,?)");
		$stmt->bindValue(1, $userID);
		$stmt->bindValue(2, $roleID);
		$stmt->execute();		
		$id = $this->conn->lastInsertId();
		return $id;
	}
	
	private function getGroupID()
	{
		$stmt = $this->conn->prepare("SELECT id FROM groups WHERE name = ?");
		$stmt->bindValue(1, $this->groupname);
		$stmt->execute();		
		$registrants = $stmt->fetchAll();
		$groupID = $registrants[0]["id"];
		return $groupID;
	}
	
	private function assignGroup()
	{
		$count = $this->getGroupSize();
		echo "c: " .$count;
		return;
		if ($count >= 3)
		{
			result(false, "Group is full");
			$this->conn = NULL; //Close DB connection
			return;
		}
		else if ($count == 0)
		{
			$groupID = $this->createGroup();
		}
		else
		{
			$groupID = $this->getGroupID();
		}

        	$roleID = $this->getRoleID();
		$userID = $this->createUser();

		$this->assignUserRole($userID, $roleID);
		$this->assignUserGroup($userID, $groupID);
		
		result(true, "User has been created successfully");
		$this->conn = NULL; //Close DB connection
		
	}
	
	private function getGroupSize()
	{
		$stmt = $this->conn->prepare("SELECT COUNT(*) AS groupcount FROM usergroups WHERE groupid=(SELECT id FROM groups WHERE name=?);");
		$stmt->bindValue(1, $this->groupname);
		$stmt->execute();		
		$registrants = $stmt->fetchAll();
		return $registrants[0]['groupcount'];
	}

    /*
    *   Check if user already exist in the database.
    *   @params: none
    *   @return: int - $count
    */
    private function checkExist() {
		$stmt = $this->conn->prepare("SELECT email FROM Users WHERE email = ?");
		$stmt->bindValue(1, $this->email);
		$stmt->execute();		
		$registrants = $stmt->fetchAll();
		
        if (count($registrants) > 0) {
            $this->conn = NULL; //Close DB connection
			result(false, "User already exist");
            return true;
        }
		return false;
    }
    
    
}

$name = "Amigo pollos3";
$lastname = "Los Hermanos";
$email = "z4@ucl.ac.uk";
$password = "abc123";
$groupname= "zdafEEFEF 2";
$role = "studENT";

$signup = new Signup($name, $lastname, $email, $password, $groupname, $role);
if ($signup->checkInputs()) {
    $signup->register();
}

/*
if(!empty($_POST))
{
	$password = $_POST['password'];
	$email = $_POST['email'];
	$signup = new Signup($email, $password);
	$signup->authenticate();
}
else
{
	result(false, "Permission Denied");
}
*/


?>
