<html>
<head>
<title>Demo</title>

</head>
<body >
test 
test
test


	<?php
	
	 //$query = "SELECT * FROM friends WHERE friendid = '".$_SESSION['user_id']."' AND allow = 1 ORDER BY first_name ASC";
	
	//$result = mysql_query($query) or die ("Query failed");
	
	
	
	echo "<table width = 100% border = '0' cellspacing = '2' cellpadding = '0'>";
	
	
	
	// loop to create rows
	
	//if(mysql_affected_rows() > 0){
	
	//while ($friendList = mysql_fetch_array($result)) {
	
	
	
	echo "<tr>"
	
	echo "<td>testrow</td>"
	//. "<td><a href='memberindex.php?id = ".$friendList['id']."'><img src='".$friendList['friendImg']."' title='".$friendList['first_name']."' alt='".$friendList['first_name']."'/><br />".$friendList['first_name']."</a><br /></td> " 
	
	. "</tr> ";
	
	}
	
	
	
	echo "</table> "; ?>


</body>
</html>
