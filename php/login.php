<?php
    header("Access-Control-Allow-Origin: *");
    
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
    //nclude 'include/config.php';
  
  function result($success, $message) {
    $response['success'] = $success;
    $response['message'] = $message;
    echo $response;
  }
  
  result(true, "hi tan");
?>
