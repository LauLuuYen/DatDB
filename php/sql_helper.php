<?php


class SQL_Helper {

	public function __construct() {
        //
	}


    /*
    *   Get all assignments given a groupID
    *   @params: mysqli - $conn, int - $groupID
    *   @return: array - $data
    */
    public function getReportAssignments($conn, $groupID) {
        $stmt = $conn->prepare("SELECT A.id, title, task, deadline, A.timestamp AS a_timestamp, R.id AS reportid, content, current_status AS status, userid, R.timestamp AS r_timestamp FROM assignments A JOIN reports R ON A.id = R.assignmentID JOIN status S ON R.statusid = S.id WHERE groupid=?");
        $stmt->bind_param("i", $groupID);
        
        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($id, $title, $task, $deadline, $a_timestamp, $reportID, $content, $status, $userID, $r_timestamp);

            $data = array();
            while($stmt->fetch())
            {
                $row = array();
                $row["id"] = $id;
                $row["title"] = $title;
                $row["task"] = $task;
                $row["deadline"] = $deadline;
                $row["timestamp"] = $a_timestamp;
                $report = array();
                $report["reportID"] = $reportID;
                $report["content"] = $content;
                $report["status"] = $status;
                $report["fullname"] = $this->getFullname($conn, $userID);
                $report["timestamp"] = $r_timestamp;
                $row["report"] = $report;
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
    *   Get all assessments given a groupID
    *   @params: mysqli - $conn, int - $groupID
    *   @return: array - $data
    */
    public function getAssessments($conn, $groupID, $assignmentID) {
        $stmt = $conn->prepare("SELECT reportid, name, current_status AS status, R.content, feedback, score, A.userid, A.timestamp FROM assessments A JOIN reports R ON A.reportID=R.id JOIN groups G ON R.groupid=G.id JOIN status S ON A.statusid=S.id WHERE A.groupid=? AND R.assignmentid=?;");
        $stmt->bind_param("ii", $groupID, $assignmentID);
        
        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($reportid, $groupname, $status, $content, $feedback, $score, $userID, $timestamp);
            
            $data = array();
            while($stmt->fetch())
            {
                $row = array();
                $row["reportID"] = $reportID;
                $row["groupname"] = $groupname;
                $row["status"] = $status;
                $row["content"] = $content;
                $row["feedback"] = $feedback;
                $row["score"] = $score;
                $row["fullname"] = $this->getFullname($conn, $userID);
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
    *   Get the forumID given a userID
    *   @params: mysqli - $conn, int - $groupID
    *   @return: int - $forumID
    */
    public function getForumID($conn, $groupID) {
        $stmt = $conn->prepare("SELECT id FROM forum WHERE groupid=?");
        $stmt->bind_param("i", $groupID);

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
    *   Get all the threads given a forumID.
    *   @params: mysqli - $conn, int - $forumID
    *   @return: array - $data
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
    *   Get all the comments given a threadID
    *   @params: mysqli - $conn, int - $threadID
    *   @return: array - $data
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
    
    /*
    *   Get user's name given userID
    *   @params: mysqli - $conn, int - $userID
    *   @return: string - $fullname
    */
    public function getFullname($conn, $userID) {
        if (is_null($userID)) {
            return "";
        }
        
        $stmt = $conn->prepare("SELECT name, lastname WHERE id=?;");
        $stmt->bind_param("i", $userID);
        
         if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($name, $lastname);
            $stmt->fetch();
            
            $fullname = $name . " " .$lastname;
            
            $stmt->free_result();
            $stmt->close();

            return $fullname;
            
        } else {
            die("An error occurred performing a request");
        }
    }
    
}


$sql_helper = new SQL_Helper();

?>