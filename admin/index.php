<!doctype html>
<html lang="en" ng-app="myApp">

<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <title>Peer Review System</title>

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="//jqueryui.com/jquery-wp-content/themes/jqueryui.com/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    
    
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-route.js"></script>
    <script src="../js/admin.js"></script>
    <script src="../js/randomiser.js"></script>


</head>

<body>
    <div class="row">
        <div class="col-md-12">
           <div class="banner">
              <div class="row">
              	<div class="col-xs-8 col-sm-4 col-md-2">
        	<!-- <a href="/" title="Return to the homepage" id="logo">
+  		 <img style="width: 80%; height: 80%;" src="/img/logo.gif" />
+		 </a> -->
		<a class="navbar-brand" rel="home" href="#" title="Return to the homepage">
		   <img style="height:100%;" src="/img/logo.gif">
		</a>
		</div>
		<div class="col-xs-0 col-sm-4 col-md-6">
			
		</div>
		   <div class="col-xs-4 col-sm-4 col-md-4">
		      <div class="pull-right top">
			<button type="button" class="btn btn-primary" aria-label="setting">
  			<span class="glyphicon glyphicon-cog" aria-hidden="true"> Setting </span>
			</button>
			<button type="button" class="btn btn-primary" aria-label="about">
  			<span class="glyphicon glyphicon-user" aria-hidden="true"> About </span>
			</button>
			<button type="button" class="btn btn-primary" aria-label="logout">
  			<span class="glyphicon glyphicon-log-out" aria-hidden="true"> Log Out </span>
			</button>
		   </div>
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
                                    <a class="panel btn" href="#/groups">View Groups</a>
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
