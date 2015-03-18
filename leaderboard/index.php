<?php
class LeaderboardClass 
{
	
	public function retrieveLeaderboard() 
	{
	require_once "../php/include/sql_helper.php";
	$this->sql_helper = new SQL_Helper();
	
	$leaderboardArray = $this->sql_helper->fetchLeaderBoard();	
	$this->sql_helper->close();
	return $leaderboardArray;
	}
	
}
	$leaderboardinstance = new LeaderboardClass();
	$leaderBoardDataArray = $leaderboardinstance->retrieveLeaderboard();
	
	$jsonLeaderboardData = json_encode($leaderBoardDataArray);
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
        var response = JSON.parse('<?php require_once "../php/get_profile.php";?>');
        var data = {};
        data["profile"] = response["profile"];
    </script>
    <script src="../js/leaderboard.js"></script>


<style>
h1 {
    border-bottom: 3px solid #cc9900;
    color: #996600;
    font-size: 30px;
    
}
table, th , td  {
    border: 1px solid grey;
    border-collapse: collapse;
    padding: 5px;
    text-align:center;
    margin: 0 auto;
}
table tr:nth-child(odd)	{
    background-color: #f1f1f1;
    text-align:center;
}
table tr:nth-child(even) {
    background-color: #ffffff;
    text-align:center;
}
</style>



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
                    <div id="logoutlink" class="col-xs-offset-4 col-xs-2 no-padding">
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
