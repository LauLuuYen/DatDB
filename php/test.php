<?php

    header("Access-Control-Allow-Origin: *");
    
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
    include 'include/config.php';
    //$conn = connectDB();

if (!empty($_FILES["myFile"])) {
    $myFile = $_FILES["myFile"];
 
    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        echo "An error occurred uploading.";
        exit;
    }

    //$response = "name: " . $myFile["name"] .", size: " . $myFile["size"] . ", type: " .$myFile["type"];
   // echo $response;
    $xml = simplexml_load_file($myFile['tmp_name']);
    
    libxml_use_internal_errors(true);
$sxe = simplexml_load_string($xml);
if (!$sxe) {
    echo "Failed loading XML\n";
    foreach(libxml_get_errors() as $error) {
        echo "\t", $error->message;
    }
} else {
    echo "Good XML";
}


} else {
    echo "nothing";   
}

?>
