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
    <link rel="stylesheet" href="../lib/bootstrap.min.css">
    
    
    <script src="../lib/jquery-latest.min.js"></script>
    <script src="../lib/angular.min.js"></script>
    <script src="../lib/angular-route.js"></script>


    <script type="text/javascript">
        var response = <?php require_once "../php/get_profile.php"; ?>;
        var data = {};
        data["profile"] = response["profile"];
    </script>
    <script src="../js/report.js?v=1.0"></script>
    <script src="../js/loader.js"></script>

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
                        <a href="/leaderboard">
                            <div class="tab">
                                Leaderboard
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
                    <div class="col-xs-2 no-padding">
                        <a href="/settings">
                            <div class="tab">
                                Settings
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-2 no-padding">
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
                                    <div class="panel header"><a href="#/">Home</a></div>
                                </div>
                                <div class="col-xs-4 col-sm-12 col-md-12">
                                    <a class="panel btn" href="#/submit">Submit Report</a>
                                </div>
                                <div class="col-xs-4 col-sm-12 col-md-12">
                                    <a class="panel btn" href="#/assessments">Assessment</a>
                                </div>
                                <div class="col-xs-4 col-sm-12 col-md-12">
                                    <a class="panel btn" href="#/marks">Marks</a>
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
