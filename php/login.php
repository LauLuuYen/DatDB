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


class Login {

    /*
    *   Constructor.
    *   @params: string - $email, string - $password
    *   @return: none
    */
	public function __construct($email, $password) {
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
	public function authenticate() {
	    
        require_once "sql_helper.php";
        $this->sql_helper = new SQL_Helper();
        
        //Retrieve the login details
        $data = $this->sql_helper->getLoginDetails($this->email);
        
        //Check if email exist
        if (is_null($data)) {
            result(false, "Invalid email/password combination");
            
        } else {
            
            //Check password match
            if (md5($this->password) != $data["password"]) {
                result(false, "Invalid email/password combination");
                
            } else {
            
                //Store user data in a session
                require_once "session.php";
                unset($data["password"]); //Remove password
                $userSession->login($data);
                
                result(true, "Success!");
                
            }
        }
            
        $this->sql_helper->close();
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
