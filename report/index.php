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
        var response = '<?php require_once "../php/getassignments.php"; echo json_encode($assignment->retrieve()); ?>';
        console.log(response);
        var data = JSON.parse(response);
    </script>
    <script src="../js/report.js"></script>

</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="banner">
            

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
                                    <div class="panel header">Home > <a href="#/">Report</a></div>
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
