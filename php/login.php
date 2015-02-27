<?php

header("Access-Control-Allow-Origin: *");
define("DEBUG", false);

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


class Login
{

    /*
    *   Constructor.
    *   @params: string - $email, string - $password
    *   @return: none
    */
	public function __construct($email, $password)
    {
		$this->email = strtolower(trim($email));
		$this->password = $password;		
	}
	

    /*
    *   Validate the inputs.
    *   @params: none
    *   @return: none
    */
	public function checkInputs()
    {
        if (strlen($this->email) == 0) {
            result(false, "Email must be set");
            
        } else if (strlen($this->password) == 0) {
            result(false, "Password must be set");
            
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            result(false, "Invalid email");

        } else {
            return true;
        }
        
        return false;
	}
	

    /*
    *   Attempt to authenticate the user.
    *   @params: none
    *   @return: none
    */
	public function authenticate()
	{
	    $this->conn = connectDB();
	    
		$stmt = $this->conn->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->bind_param("s", $this->email);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($id, $name, $lastname, $email, $password, $roleID, $groupID, $timestamp);
            
            $registrant = $stmt->fetch();
            
            if (count($registrant) == 0) {
                //No user found
                result(false, "Email does not exist");
                return;
            }
            
            if (md5($this->password) != $password) {
                result(false, "Invalid email/password combination");
            } else {
            	
                require_once "session.php";
                $data = array(
                    "userID" => $id,
                    "name" => $name,
                    "lastname" => $lastname,
                    "roleID"=>$roleID,
                    "groupID"=>$groupID
                );
                $userSession->login($data);
            
                result(true, "Success!");
                //TODO return back other stuff
                
            }
            
            $stmt->close();
            closeDB($this->conn);

        } else {
            die("An error occurred performing the request");
        }
    }

}



if(!empty($_POST))
{
	$email = $_POST["email"];
	$password = $_POST["password"];
    $login = new Login($email, $password);
    if ($login->checkInputs()) {
        $login->authenticate();
    }
}
else
{
	result(false, "Permission Denied");
}



?>
