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
        echo "<p>An error occurred.</p>";
        exit;
    }

    if (!$success) { 
        echo "<p>Unable to save file.</p>";
        exit;
    } else {
        
        echo "Uploaddededed!";
    }
} else {
    echo "nothing";   
}

?>
