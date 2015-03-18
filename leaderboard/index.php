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
    
	<br><br>
	<center class="heading">LEADERBOARD</center>
	<br><br>
    <script type="text/javascript">
        function createLeaderboard() 
        {
            //Build an array containing assignment records.
            var leadingboardArray = new Array();
            var jsLeaderboardJSON = <?php echo json_encode($leaderBoardDataArray); ?>;
            leadingboardArray.push(["Rank", "Group Name", "Average mark"]);
            var j = 0;
            var n = 0;
            var previousMark = -1;
            var currentMark = -1;
            for (i in jsLeaderboardJSON) 
		 {
		 	currentMark = jsLeaderboardJSON[j].averageMark;
			
			if((!jsLeaderboardJSON[j].averageMark) && (j>0) && (jsLeaderboardJSON[j-1].averageMark == null))
		 	{
		 		n--;
		 		leadingboardArray.push([n+1, jsLeaderboardJSON[j].groupName, "-"]);
		 	}
		 	else if(currentMark == previousMark)
		 	{	
		 		n--;
		 		leadingboardArray.push([n+1, jsLeaderboardJSON[j].groupName, jsLeaderboardJSON[j].averageMark]);
		 		
		 	}
		 	else if(!jsLeaderboardJSON[j].averageMark)
		 	{
		 		leadingboardArray.push([n+1, jsLeaderboardJSON[j].groupName, "-"]);
		 		
		 	}
		 	else
		 	{
		 		leadingboardArray.push([n+1, jsLeaderboardJSON[j].groupName, jsLeaderboardJSON[j].averageMark]);
		 		previousMark = jsLeaderboardJSON[j].averageMark;
		 	}
		 	//alert(jsLeaderboardJSON[0].groupName);
		     j++;
		     n++;
		 }
 
         
            //Create a HTML Table element.
            var table = document.createElement("TABLE");
            table.border = "1";
         
            //Get the count of columns.
            var columnCount = leadingboardArray[0].length;
         
            //Add the header row.
            var row = table.insertRow(-1);
            for (var i = 0; i < columnCount; i++) {
                var headerCell = document.createElement("TH");
                headerCell.innerHTML = leadingboardArray[0][i];
                row.appendChild(headerCell);
            }
         
            //Add the data rows.
            for (var i = 1; i < leadingboardArray.length; i++) 
            {
                row = table.insertRow(-1);
                for (var j = 0; j < columnCount; j++) 
                {
                    var cell = row.insertCell(-1);
                    cell.innerHTML = leadingboardArray[i][j];
                }
            }   
     
            var dvTable = document.getElementById("dvTable");
            dvTable.innerHTML = "";
            dvTable.appendChild(table);
        }
    </script>

<!-- <input type="button" value="Generate Table" onclick="GenerateTable()" /> -->
	 <script>
		var jsLeaderboardJSON = <?php echo json_encode($leaderBoardDataArray); ?>;
    		createLeaderboard();
	</script>
	
<div id="dvTable"></div>
    
</body>
	
</html>
