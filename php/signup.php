<?php
    header("Access-Control-Allow-Origin: *");

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

	public function __construct($email, $password, $groupname) {
		$this->email = strtolower(trim($email));
		$this->password = md5($password);
        $this->groupname = ucfirst(strtolower(trim($groupname)));
	}
	
	public function checkInputs() {
		return true;
	}
	
	public function register() {
        //Connect to DB
	    $this->conn = connectDB();
	    
        if ($this->checkExist()) {
            return;
        }

        echo $this->email;
        echo $this->groupname;
        
        //result(true, "User does NOT exist");
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

$email = "zODtng@ucl.ac.uk";
$password = "abc123";
$groupname= "zdafEEFEF 2";

$signup = new Signup($email, $password, $groupname);
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
