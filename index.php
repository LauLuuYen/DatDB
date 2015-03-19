<?php

require_once "php/session.php";

$userSession->isLoggedInMain();

?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
    <meta charset="UTF-8">
    <title>Peer Review</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="stylesheet" type="text/css" href="css/loader.css">
    <link rel="stylesheet" href="lib/bootstrap.min.css">

    <script src="lib/jquery-latest.min.js"></script>
    <script src="lib/angular.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/loader.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">


</head>
<body>

    <div class="row">
        <div class="col-xs-12">
            <div class="banner">
                <div class="row">
                    <div class="col-xs-2 no-padding">
                        <img src="img/logo.png" class="logo"></img>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-offset-3 col-xs-6 col-md-offset-4 col-md-4">

            <form class="loginbox" ng-submit="">
                <div id="title">Please Login to proceed</div><br>

                <div class="input_wrapper">
                    <div class="heading2">Email Address:</div>
                    <input class="input_text" maxlength=100></input>
                    <div class="error">Error: Please enter your email address</div>
                </div>
                <div class="input_wrapper">
                    <div class="heading2">Password:</div>
                    <input class="input_text" maxlength=40></input>
                    <div class="error">Error: Please enter your password</div>
                </div>

                <button type="submit">Login</button>
            </form>

        </div>
    </div>

</body>

</html>
