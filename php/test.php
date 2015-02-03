<?php

    header("Access-Control-Allow-Origin: *");
    
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);

    echo "step1";
    include 'includes/config.php';
    
    echo "step2";

    $conn = connectDB();
    echo "step3";

?>
