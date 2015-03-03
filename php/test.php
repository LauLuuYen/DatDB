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
	//$post =
	/*
	//$request = json_encode($post);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	//curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	*/
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => array(
			userID => 23,
			threadID => 325,
			comment => "testst"
		)
	));


	$response = curl_exec($curl);
	$obj = json_decode($response, true);	
	curl_close($curl);
	
	
	echo "output:" . $response . "<br>";
	echo "jn:" . json_encode($obj);
	
?>

