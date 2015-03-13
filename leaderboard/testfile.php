<?php
	/*
	SQL-QUERY:
	SELECT groups.name,reports.groupid, reportid, AVG(score) FROM assessments INNER JOIN reports ON (assessments.reportid = reports.id) INNER JOIN groups ON (reports.groupid = groups.id) GROUP BY reportid ORDER BY score DESC;
	*/
	
	
	function fetchLeaderBoard()
	{
		$stmt = conn->prepare("SELECT groups.name,reports.groupid, reportid, AVG(score) FROM assessments INNER JOIN reports ON (assessments.reportid = reports.id) INNER JOIN groups ON (reports.groupid = groups.id) GROUP BY reportid ORDER BY score DESC;");
		if ($stmt->execute()) 
		{
			echo "dat ass";
			/*
	            $stmt->store_result();
	            $stmt->bind_result($groupName,$groupID,$reportID, $averageMark);
	            
	            $data = array();
	            while($stmt->fetch())
	            {
	                $row = array();
	                $row["groupName"] = $groupName;
	                $row["groupID"] = $groupID;
	                $row["averageMark"] = $averageMark;
	                $data[] = $row;
	            }
	          
	            $stmt->free_result();
	            $stmt->close();
	            return $data;
	            */
	            
	        } 
	        else 
	        {
	            die("An error occurred performing a request");
	        }
	}
	fetchLeaderBoard();
	
	
	function writeMsg() 
	{
	    echo "Hello world!";
	}
	
	writeMsg(); // call the function
	
?>
