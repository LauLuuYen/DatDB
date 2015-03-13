<html>
<head>

    <script type="text/javascript">
        function createLeaderboard() 
        {
            //Build an array containing assignment records.
            var assigment = new Array();
            assigment.push(["Rank", "Group Name", "Average mark"]);
            assigment.push([1, "Parishilton", "4.5"]);
            assigment.push([2, "Animatrix", "1.7"]);
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

</head>
<body >
<!-- <input type="button" value="Generate Table" onclick="GenerateTable()" /> -->
	<script>
    		createLeaderboard();
	</script>

<div id="dvTable"></div>



</body>
</html>
