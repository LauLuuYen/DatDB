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
  
  
if (!empty($_FILES["myFile"])) {
    $myFile = $_FILES["myFile"];
 
    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        echo "An error occured uploading.";
        exit;
    }

    //$response = "name: " . $myFile["name"] .", size: " . $myFile["size"] . ", type: " .$myFile["type"];
   // echo $response;
    $xml = @simplexml_load_file($myFile['tmp_name']);
    
    if ($xml === FALSE) {
        
        echo "shit xml";
    } else {
        echo json_encode($xml);
    }
} else {
    echo "nothing";
}

?>
