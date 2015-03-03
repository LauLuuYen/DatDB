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


class Thread {

    /*
    *
    *   @params: none
    *   @return: none
    */
	public function __construct($userID, $title, $comment) {
        $this->userID = $userID;
        $this->title = $title;
        $this->comment = $comment;

	}
}


$userID = 31;
$title = "title";
$comment = "comments";





?>