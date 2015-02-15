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
    
    
    class FileParser {
    	public function __construct($txtfile)
    	{
	        $this->txtfile = $txtfile;
    	}
    	
    	public function checkXML()
    	{
    	    $xml = @simplexml_load_file($this->txtfile['tmp_name']);
            
            if ($xml === FALSE) {
                result(false, "shit xml");
            } else {
                $rootname = $xml->getName();
                
                if ($rootname != "Content" && $rootname != "content") {
                    result(false, "fuck you");
                    return;
                }
                 
                if (count($xml->children()) < 0) {
                        result(false, "has children");
                	return;
                }
       		$json = json_encode($xml);
       		$array = json_decode($json, true);
                result(true, $array['0']);

            }
            
            
    	}
    	
    }
if (!empty($_FILES["myFile"])) {
    $myFile = $_FILES["myFile"];
 
    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        result(false, "An error occured uploading.");
        exit;
    }

    $parser = new FileParser($myFile);
    $parser->checkXML();
    
    
} else {
    result(false, "nothing");
}

?>
