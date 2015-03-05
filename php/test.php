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

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => array(
			userID => "wrg",
			threadID => 13,
			comment => "gay"
		)
	));


	$response = curl_exec($curl);
	$obj = json_decode($response, true);	
	curl_close($curl);
	
	
	echo "output:" . $response . "<br>";
	echo "jn:" . json_encode($obj);
	
?>

