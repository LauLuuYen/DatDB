<?php

require_once "../php/session.php";

$userSession->isLoggedIn("admin");

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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="//jqueryui.com/jquery-wp-content/themes/jqueryui.com/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    
    
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-route.js"></script>
    <script src="http://code.angularjs.org/1.0.4/angular-sanitize.min.js"></script>

    <script type="text/javascript">
        var response = JSON.parse('<?php require_once "../php/get_profile.php";?>');
        var data = {};
        data["profile"] = response["profile"];
    </script>

    <script src="../js/loader.js"></script>
    <script src="../js/admin.js"></script>
    <script src="../js/loader.js"></script>
    <script src="../js/randomiser.js"></script>



</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="banner">
                <div class="row">
                    <div class="col-xs-2 no-padding">
                        <a href="/admin">
                            <img src="../img/logo.png" class="logo"></img>
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
                    <div class="col-xs-offset-4 col-xs-2 no-padding">
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
            
                <div class="row">

                    <!--Left panel-->
                    <div class="col-sm-4 col-md-4">
                        <div class="left_panel">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="panel header">Home > <a href="#/">Admin</a></div>
                                </div>
                                <div class="col-xs-4 col-sm-12 col-md-12">
                                    <a class="panel btn" href="#/user">Create User</a>
                                </div>
                                <div class="col-xs-4 col-sm-12 col-md-12">
                                    <a class="panel btn" href="#/assignments">Create Assignment</a>
                                </div>
                                <div class="col-xs-4 col-sm-12 col-md-12">
                                    <a class="panel btn" href="#/search">Search User</a>
                                </div>
                                <div class="col-xs-4 col-sm-12 col-md-12">
                                    <a class="panel btn" href="#/leaderboard">Leaderboard</a>
                                </div>
                                <div class="col-xs-4 col-sm-12 col-md-12">
                                    <a class="panel btn" href="#/all">View All</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
        
                    <!--Right content-->
                    <div class="col-sm-8 col-md-8">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="right_content">
                                
                                    <div ng-view></div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
                
            
            </div>
        </div>
    </div>
    

</body>
	
</html>
