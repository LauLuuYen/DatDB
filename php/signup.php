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

	public function __construct($email, $password) {
		$this->email = $email;
		$this->password = $password;		
	}
	
	public function checkInputs() {
		return true;
	}
	
	public function register() {
        //Connect to DB
	    $this->conn = connectDB();
	    
        if ($this->checkExist()) {
            $this->conn = NULL; //Close DB connection
			result(false, "User already exist");
            return;
        }
		//$user = $registrants[0];

        result(true, "User does NOT exist");
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
		
        $count = count($registrants) > 0;
		return $count;
    }
    
    
}

$email = "zcabtng@ucl.ac.uk";
$password = "abc123";
$signup = new Signup($email, $password);
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
