<?php

/*
require_once "session.php";
echo $userSession->getSessionVal("userID");
$userSession->destroySession();
*/
header("Access-Control-Allow-Origin: *");

    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);

	$url = 'http://lauluuyen.azurewebsites.net/php/comment.php';

	$post_request = "userID=23&threadID=35&comment=curl";
	
	$request = json_encode(['userID' => 41]);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	//curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_request);
	
	$response = curl_exec($ch);
	$obj = json_decode($response, true);	
	curl_close($ch);
	
	echo "output:" . $response . "<br>";
	echo "jso2n:" . json_encode($obj);
	
?>

