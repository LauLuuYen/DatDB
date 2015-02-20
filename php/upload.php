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
    	public function __construct($userID, $reportID, $txtfile)
    	{
    		$this->userID = $userID;
    		$this->reportID = $reportID;
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
       		
       		$content = trim($array['0']);
               
                if($this->submitReport($content))
                {
                	 result(true, "success");
                }
		else
		{
			result(false, "failed to submit report");	
		}
            }
            
            
    	}
    	
    	private function submitReport($content)
    	{
    		$this->conn = connectDB();
		$stmt = $this->conn->prepare("UPDATE reports SET content=?, userid=?, statusid=?, timestamp=? WHERE id=?");
		$timestamp = date("Y-m-d H:i:s");
		$stmt->bind_param("siis", $content, $this->userID,11, $timestamp, $this->reportID);
		if ($stmt->execute()) 
		{
		  $stmt->close();
		  closeDB($this->conn);
		  return true;
	        } 
		closeDB($this->conn);
	        return false;
    		
    		
    	}
    	
    }
if (!empty($_FILES["myFile"])) {
    $myFile = $_FILES["myFile"];
 
    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        result(false, "An error occured uploading.");
        exit;
    }
	$userID = $_POST['userID'];
	$reportID = $_POST['reportID']; 
	$parser = new FileParser($userID,$reportID, $myFile);
	$parser->checkXML();

    
} else {
    result(false, "nothing");
}

?>
