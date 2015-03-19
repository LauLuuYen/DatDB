<?php


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
    <script src="../js/settings.js"></script>
    <script src="../js/loader.js"></script>

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
                    <div id="forumlink" class="col-xs-2 no-padding conceal">
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
                    <div id="logoutlink" class="col-xs-offset-2 col-xs-2 no-padding">
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
