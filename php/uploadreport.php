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

    
    
class FileParser {
    
    public function __construct($reportID, $txtfile) {
        $this->userID = $_SESSION["userID"];
        $this->reportID = $reportID;
        $this->txtfile = $txtfile;
    }

    public function checkTXT() {
        $content = trim(file_get_contents($this->txtfile['tmp_name']));
        
        $this->submitReport($content);
    }
    
    public function checkXML() {
        $xml = @simplexml_load_file($this->txtfile['tmp_name']);

        if ($xml === FALSE) {
            result(false, "Not a VALID XML file.");
        } else {
            $rootname = $xml->getName();

            if ($rootname != "Content" && $rootname != "content") {
                result(false, "Please check the XML file guidelines");
                return;
            }

            if (count($xml->children()) < 0) {
                result(false, "Please check the XML file guidelines");
                return;
            }
            
            $json = json_encode($xml);
            $array = json_decode($json, true);

            $content = trim($array['0']);

            $this->submitReport($content);
    
        }
    }
    
    private function submitReport($content) {
        if (strlen($content) > 5000) {
            result(false, "Report has exceeded 5000 characters");
            return;
        } else if (strlen($content) == 0) {
            result(false, "Cannot submit empty report");
            return;
        }
        
        require_once "include/sql_helper.php";
        $this->sql_helper = new SQL_Helper();
            
        $success = $this->sql_helper->updateReport($content, $this->userID, $this->reportID);
        
        if($success) {
            result(true, "Success");
        } else {
            result(false, "Failed to submit report");
        }
        
        $this->sql_helper->close();
    }

}


require_once "session.php";

if($userSession->isLoggedIn("student")) {

    if (!empty($_FILES["myFile"])) {
        $file = $_FILES["myFile"];
     
        if ($file["error"] !== UPLOAD_ERR_OK) {
            result(false, "An error occured uploading");
 
        } else if ($file["size"] > 5000000) { //5mb
            result(false, "File size too big");
            
        } else {
            $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
           
            $reportID = $_POST["reportID"];
            $parser = new FileParser($reportID, $file);
            
            switch ($ext) {
                case "xml":
                    $parser->checkXML();
                    break;
                case "txt":
                    $parser->checkTXT();
                    break;
                default:
                    result(false, "Unrecognised extension");
            }

    
        
        }
        
        
    } else {
        result(false, "Error in request!");
    }
    
} else {
    result(false, "Session timeout");
}

?>
