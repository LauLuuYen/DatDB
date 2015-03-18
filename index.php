<?php

require_once "php/session.php";

$userSession->isLoggedInMain();

?>

<!doctype html>
<html lang="en" ng-app="myApp">

<head>
    <meta charset="UTF-8">
    <title>The HTML5 Herald</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="stylesheet" type="text/css" href="css/loader.css">
    <link rel="stylesheet" href="../lib/bootstrap.min.css">

    <script src="../lib/jquery-latest.min.js"></script>
    <script src="../lib/angular.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/loader.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">


</head>

<body ng-controller="Login">
<img src="img/background1.jpg" class="bg">
<div class="login box">
    <!--Login form-->
    <form ng-submit="submit()">
        
            <div class="input_wrapper">
                <input type="text" class="input_text login"  placeholder="Email" ng-model="account.email">
            </div>
            
            <div class="input_wrapper">
                <input type="password" class="input_text login" placeholder="Password" ng-model="account.password">
            </div>
            
            <div class="input_wrapper">
                <button type="submit" class="btn">Login</button>
            </div>
            
        </form>
    </div>
</body>
	
</html>
