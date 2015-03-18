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

<html>
<head>


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
<body >
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
            
            // Pull out rank for current user
            //console.log(leadingboardArray);
            //alert(leadingboardArray);
            //alert(leadingboardArray.length);
            var userRankArray = [];
            for (m in leadingboardArray)
            {
            	if(leadingboardArray[1] == "Zeldafans")
            	{
            		alert(Your group name is . leadingboardArray[1]);
            	}
            }
            

        }
    </script>

	 <script>
		var jsLeaderboardJSON = <?php echo json_encode($leaderBoardDataArray); ?>;
    		createLeaderboard();
	</script>
	
<div id="dvTable"></div>

</body>
</html>
