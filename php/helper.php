<?php

header("Access-Control-Allow-Origin: *");
define("DEBUG", true);
if (DEBUG) {
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
}

class Helper {

    /*
    *
    *   @params: none
    *   @return: none
    */
	public function __construct() {

	}
	

	public function getForumID($conn, $id)
	{
		$stmt = $conn->prepare("SELECT id FROM forum WHERE groupid=(SELECT groupid FROM users WHERE id=?);");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($userID);
            
            $registrant = $stmt->fetch();//Bind result with row
            $stmt->close();

            return $userID;
            
        } else {
            die("An error occurred performing a request");
        }
	}
    
    
}

$helper = new Helper();



?>
