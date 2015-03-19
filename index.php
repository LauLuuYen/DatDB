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
    <link rel="stylesheet" href="../lib/bootstrap.min.css">

    <script src="../lib/jquery-latest.min.js"></script>
    <script src="../lib/angular.min.js"></script>
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
        <div class="col-xs-offset-1 col-xs-10 col-md-offset-4 col-md-4">

            <div class="loginbox">
                <form ng-submit="submit()">
                    <div id="title">Please Login to Proceed</div><br>

                    <div class="input_wrapper">
                        <div class="heading2">Email Address:</div>
                        <input class="input_text" ng-model="account.email" maxlength=100></input>
                        <div class="error invisible">Error: Please enter your email address</div>
                    </div>
                    <div class="input_wrapper">
                        <div class="heading2">Password:</div>
                        <input type="password" class="input_text" ng-model="account.password" maxlength=40></input>
                        <div class="error invisible">Error: Please enter your password</div>
                    </div>

                    <button type="submit" id="submit">Login</button>
                </form>
            </div>

        </div>
    </div>

</body>

</html>
