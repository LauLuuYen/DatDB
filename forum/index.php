<?php

require_once "../php/session.php";

if(!$userSession->isLoggedIn()) {
    $url = "http://" . $_SERVER["HTTP_HOST"];
    header("Location: " . $url);
}

?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <title>Peer Review System</title>

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    
    
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-route.js"></script>
    <script type="text/javascript">
        var response = '<?php require_once "../php/getforum.php"; echo json_encode($forum->retrieve()); ?>';
        console.log(response);
        var data = JSON.parse(response);
    </script>
    <script src="../js/forum.js?v=1.0"></script>

</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="banner"></div>

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
