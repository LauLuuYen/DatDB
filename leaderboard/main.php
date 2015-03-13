<html>
<head>

    <script type="text/javascript">
        function createLeaderboard() 
        {
            //Build an array containing Customer records.
            var customers = new Array();
            customers.push(["Assignment Title", "Group Name", "Average mark"]);
            customers.push([LG flex, "Parishilton", "4.5"]);
            customers.push([LG flex, "Animatrix", "1.7"]);
            customers.push([LG flex, "Mario Cart fans", "2.2"]);
            customers.push([LG flex, "Cosplayer over9k", "5"]);
         
            //Create a HTML Table element.
            var table = document.createElement("TABLE");
            table.border = "1";
         
            //Get the count of columns.
            var columnCount = customers[0].length;
         
            //Add the header row.
            var row = table.insertRow(-1);
            for (var i = 0; i < columnCount; i++) {
                var headerCell = document.createElement("TH");
                headerCell.innerHTML = customers[0][i];
                row.appendChild(headerCell);
            }
         
            //Add the data rows.
            for (var i = 1; i < customers.length; i++) 
            {
                row = table.insertRow(-1);
                for (var j = 0; j < columnCount; j++) 
                {
                    var cell = row.insertCell(-1);
                    cell.innerHTML = customers[i][j];
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
