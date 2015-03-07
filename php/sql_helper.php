<?php


class SQL_Helper {

    /*
    *
    *   @params: none
    *   @return: none
    */
	public function __construct() {
        //
	}

    /*
    *
    *   @params: none
    *   @return: none
    */
    public function getForumID($conn, $userid) {
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
    

    /*
    *
    *   @params: none
    *   @return: none
    */
    public function getAllThreads($conn, $forumID)
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
    
    /*
    *
    *   @params: none
    *   @return: none
    */
    public function getAllComments($conn, $threadID)
    {
        $stmt = $conn->prepare("SELECT C.id, U.name, U.lastname, C.content, C.timestamp FROM comment C JOIN users U ON U.id = C.userID WHERE threadID=?;");
        $stmt->bind_param("i", $threadID);
        
         if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($id, $name, $lastname, $content, $timestamp);
            
            $data = array();
            while($stmt->fetch())
            {
                $row = array();
                $row["commentID"] = $id;
                $row["fullname"] = $name . " " . $lastname;
                $row["content"] = $content;
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
    
    

}


$sql_helper = new SQL_Helper();

?>
