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
    
    
    public function isLoggedIn(role) {
        session_start();
                
        $loggedIn = isset($_SESSION["userID"]) &&
                    isset($_SESSION["name"]) &&
                    isset($_SESSION["lastname"]) &&
                    isset($_SESSION["roleID"]) &&
                    isset($_SESSION["groupID"]);
        
        if (!$loggedIn) {
            $url = "http://" . $_SERVER["HTTP_HOST"];
            header("Location: " . $url);
        }
    }


    /*
    *   Destroy the session.
    *   @params: none
    *   @return: none
    */
    public function destroySession() {
    	if(!session_destroy()) {
    		$this->setSessionVal("userID", -1);	
    	}
        
        $url = "http://" . $_SERVER["HTTP_HOST"];
        header("Location: " . $url);
    }
    
}


$userSession = new Session();


?>
