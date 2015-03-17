<?php

require_once "../php/session.php";

$userSession->isLoggedIn("");

?>

<!doctype html>
<html lang="en" ng-app="myApp">

<head>
    <meta charset="UTF-8">
    <title>The HTML5 Herald</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="stylesheet" type="text/css" href="css/loader.css">
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0/angular.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/loader.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

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
