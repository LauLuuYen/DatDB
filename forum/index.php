<?php

require_once "../php/session.php";

$userSession->isLoggedIn("student");

?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <title>Peer Review System</title>

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link rel="stylesheet" type="text/css" href="../css/loader.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    
    
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-route.js"></script>

    <script type="text/javascript">
        var response = JSON.parse('<?php require_once "../php/get_profile.php";?>');
        var data = {};
        data["profile"] = response["profile"];
    </script>

    <script src="../js/loader.js"></script>
    <script src="../js/forum.js?v=1.0"></script>

</head>

<body>
    <div class="row">
        <div class="col-xs-12">
            <div class="banner">
                <div class="row">
                    <div class="col-xs-2 no-padding">
                        <a href="/report">
                            <img src="../img/logo.png" class="logo"></img>
                        </a>
                    </div>
                    <div class="col-xs-2 no-padding">
                        <a href="/forum">
                            <div class="tab">
                                Forum
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-2 no-padding">
                        <a href="/account">
                            <div class="tab">
                                Account
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-2 no-padding">
                        <a href="/about">
                            <div class="tab">
                                About
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-offset-2 col-xs-2 no-padding">
                        <a href="/php/get_logout.php">
                            <div class="tab">
                                Logout
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!--Inner body-->
        <div class="col-sm-offset-1 col-sm-10
                    col-md-offset-1 col-md-10">
            <div class="innerbody">
            
                <div ng-view></div>

            </div>
        </div>
    </div>
    
    
</body>
	
</html>
