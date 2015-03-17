<?php


class Session {

    /*
    *
    *   @params: none
    *   @return: none
    */
	public function __construct() {
        //
	}

    /*
    *
    *   @params:
    *   @return: none
    */
    public function login($data) {
        session_start();
        $_SESSION["userID"] = $data["userID"];
        $_SESSION["name"] = $data["name"];
        $_SESSION["lastname"] = $data["lastname"];
        $_SESSION["roleID"] = $data["roleID"];
        $_SESSION["groupID"] = $data["groupID"];
    }
    
    
    public function isLoggedIn($role) {
        session_start();
                
        $loggedIn = isset($_SESSION["userID"]) &&
                    isset($_SESSION["name"]) &&
                    isset($_SESSION["lastname"]) &&
                    isset($_SESSION["roleID"]));
        
        if (!$loggedIn) {
            $url = "http://" . $_SERVER["HTTP_HOST"];
            header("Location: " . $url);
            return false;
        }
        
	require_once "include/sql_helper.php";
	$sql_helper = new SQL_Helper();
	$name = strtolower($sql_helper->getRole($_SESSION["roleID"]));
	$role = strtolower($role);
	$sql_helper->close();

	if($name == $role)
	{
		return true;
	}
	else if($name == "admin")
	{
		$url = "http://" . $_SERVER["HTTP_HOST"]."/admin";
        	 header("Location: " . $url);
	}
	else if ($name == "student")
	{
		$url = "http://" . $_SERVER["HTTP_HOST"]."/report";
        	 header("Location: " . $url);
	}
	
        return false;
    }


    /*
    *   Destroy the session.
    *   @params: none
    *   @return: none
    */
    public function logout() {
    	session_start();
        session_destroy();
        
        $url = "http://" . $_SERVER["HTTP_HOST"];
        header("Location: " . $url);
    }
    
}


$userSession = new Session();


?>
