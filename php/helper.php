<?php

header("Access-Control-Allow-Origin: *");


function getForumID($conn, $userid) {
    $stmt = $conn->prepare("SELECT id FROM forum WHERE groupid=(SELECT groupid FROM users WHERE id=?);");
    $stmt->bind_param("i", $userid);

    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($forumID);
        
        $registrant = $stmt->fetch();//Bind result with row
        $stmt->close();

        return $forumID;
        
    } else {
        die("An error occurred performing a request");
    }
}

function getAllThreads($conn, $forumID)
{
    $stmt = $conn->prepare("SELECT id,title,timestamp FROM thread WHERE forumid=?");
    $stmt->bind_param("i", $forumID);
    
     if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($id,$title,$timestamp);
        
	   	$data = array();
	   	while($stmt->fetch())
	   	{
	   	    $row = array();
	   	    $row["threadID"] = $id;
	   	    $row["title"] = $title;
	   	    $row["timestamp"] = $timestamp;
	   	    $data[] = $row;
	   	   
	   	}
        $stmt->free_result();
        $stmt->close();

        return $data;
        
    } else {
        die("An error occurred performing a request");
    }
    
}


?>
