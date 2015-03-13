<html>
<head>
<title>Demo</title>
<style>
#div1 {margin:10px;font-size:1.25em;}
table {border-collapse:collapse;border:1px solid #7f7f7f;}
td {border:1px solid #7f7f7f;width:50px;height:50px;text-align:center;}
</style>
</head>
<body >
test 
test
test
<div id="div1"></div>

<script>
var totalRows = 5;
var cellsInRow = 5;
var min = 1;
var max = 10;

    function drawTable() {
        // get the reference for the body
        var div1 = document.getElementById('div1');
 
        // creates a <table> element
        var tbl = document.createElement("table");
 
        // creating rows
        for (var r = 0; r < totalRows; r++) {
            var row = document.createElement("tr");
	     
	     // create cells in row
             for (var c = 0; c < cellsInRow; c++) {
                var cell = document.createElement("td");
		getRandom = Math.floor(Math.random() * (max - min + 1)) + min;
                var cellText = document.createTextNode(Math.floor(Math.random() * (max - min + 1)) + min);
                cell.appendChild(cellText);
                row.appendChild(cell);
            }           
            
	tbl.appendChild(row); // add the row to the end of the table body
        }
    
     div1.appendChild(tbl); // appends <table> into <div1>
}
window.onload=drawTable; 
</script>
</body>
</html>
