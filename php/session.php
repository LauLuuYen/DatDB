<?php


class Session {

    /*
    *   Start session instance
    *   @params: none
    *   @return: none
    */
	public function __construct() {
        session_start();
	}
	

    /*
    *   Get the session value at the key.
    *   @params: none
    *   @return: ? - $value
    */
	public function getSessionVal($key) {
        $value = $_SESSION["".$key];
        return $value;
	}
	

    /*
    *   Set the session value at the key.
    *   @params: string - $key, ? - $value
    *   @return: none
    */
    public function setSessionVal($key, $value) {
        $_SESSION["".$key] = $value;
    }
    

    /*
    *   Destroy the session.
    *   @params: none
    *   @return: none
    */
    public function destroySession() {
    	
    	if(!session_destroy())
    	{
    		$this->setSessionVal("userID", -1);	
    	}
        //echo "Session destroyed";
    }
    
}


$userSession = new Session();


?>
