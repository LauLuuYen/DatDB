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
	//echo $jsonLeaderboardData;
	//print_r($leaderBoardDataArray);
	//echo "Hello World";
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
}
table tr:nth-child(odd)	{
    background-color: #f1f1f1;
}
table tr:nth-child(even) {
    background-color: #ffffff;
}
</style>


</head>
<body >

    <script type="text/javascript">
        function createLeaderboard() 
        {
            //Build an array containing assignment records.
            
            var assigment = new Array();
            var jsLeaderboardJSON = <?php echo json_encode($leaderBoardDataArray); ?>;
            //alert(jsLeaderboardJSON[0].groupName);
            assigment.push(["Rank", "Group Name", "Average mark"]);
            for (i in jsLeaderboardJSON) 
		 {
		 	//alert(jsLeaderboardJSON[i].groupName);
		     assigment.push([jsLeaderboardJSON][i].groupName, "Parishilton", "4.5"]);
		 }
            
            assigment.push([1, "Parishilton", "4.5"]);
            assigment.push([2, "gooo", "1.7"]);
            assigment.push([3, "Mario Cart fans", "2.2"]);
            assigment.push([4, "Cosplayer over9k", "5"]);
         
            //Create a HTML Table element.
            var table = document.createElement("TABLE");
            table.border = "1";
         
            //Get the count of columns.
            var columnCount = assigment[0].length;
         
            //Add the header row.
            var row = table.insertRow(-1);
            for (var i = 0; i < columnCount; i++) {
                var headerCell = document.createElement("TH");
                headerCell.innerHTML = assigment[0][i];
                row.appendChild(headerCell);
            }
         
            //Add the data rows.
            for (var i = 1; i < assigment.length; i++) 
            {
                row = table.insertRow(-1);
                for (var j = 0; j < columnCount; j++) 
                {
                    var cell = row.insertCell(-1);
                    cell.innerHTML = assigment[i][j];
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
    		
    		//var jsTable = jsLeaderboardJSON[1].groupName;
    		//var jsTable = "Hello world!";
    		var jsTable = "<table>";
    		
    		jsTable += "<tr><td>" + "Hello world!" +
    		"</td><td>" +
    		"Hello you!" +
    		//jsLeaderboardJSON[0].groupName +
    		"</td></tr>";
    		
		//for (i in jsLeaderboardJSON)
		//{
		  //alert("<div><br />" + jsLeaderboardJSON[i].groupName + "<br /></div>");
		//jsTable = jsTable + "<tr><td>" +
	        //jsLeaderboardJSON[i].groupName +
	        //"</td><td>" +
	        //jsLeaderboardJSON[i].groupID +
	        //"</td><td>" +
	        //jsLeaderboardJSON[i].averageMark +
	        //"</td></tr>";
		//}
	    	jsTable += "</table>";
		document.getElementById("dvTestTable").innerHTML = jsTable;	
    		
	//	var jsLeaderboardJSON = <?php echo json_encode($leaderBoardDataArray); ?>;
	//	 for (var key in jsLeaderboardJSON) 
	//	 {
	//	    if (JSONObject.hasOwnProperty(key)) {
	//	      alert(JSONObject[key]["groupName"] + ", " + JSONObject[key]["groupID"]);
	//	    }
	//	 }
    	//	alert(js_array);
	</script>
	

<div id="dvTable"></div>

<div id="dvTestTable"></div>

</body>
</html>
