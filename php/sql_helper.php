<?php

require_once "include/config.php";

class SQL_Helper {

    /*
    *   Constructor
    *   @params: mysqli - $conn
    *   @return: none
    */
	public function __construct() {
        $this->conn = connectDB();
	}


    /*
    *   Close database connection
    *   @params: none
    *   @return: none
    */
    public function close() {
        closeDB($this->conn);
    }
    
    
    /*
    *   Get Login details given an email
    *   @params: string - $email
    *   @return: array - $data
    */
    public function getLoginDetails($email) {
        $stmt = $this->conn->prepare("SELECT id, password, name, lastname, roleID, groupID FROM users WHERE email=?;");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($id, $password, $name, $lastname, $roleID, $groupID);

            $registrant = $stmt->fetch();
            $stmt->close();
            
            if (count($registrant) == 0) {
                return null;
            }

            $data = array(
                "userID" => $id,
                "name" => $name,
                "lastname" => $lastname,
                "roleID"=>$roleID,
                "groupID"=>$groupID,
                "password"=>$password
            );
            return $data;

        } else {
            die("An error occurred performing the request");
        }
        
    }
    
    
    /*
    *   Get all assignments given a groupID
    *   @params: int - $groupID
    *   @return: array - $data
    */
    public function getReportAssignments($groupID) {
        $stmt = $this->conn->prepare("SELECT A.id, title, task, deadline, A.timestamp AS a_timestamp, R.id AS reportid, content, current_status AS status, userid, R.timestamp AS r_timestamp FROM assignments A JOIN reports R ON A.id = R.assignmentID JOIN status S ON R.statusid = S.id WHERE groupid=?");
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
                $report["content"] = is_null($content) ? "":$content;
                $report["status"] = $status;
                $report["fullname"] = $this->getFullname($conn, $userID);
                $report["timestamp"] = is_null($r_timestamp) ? "":$r_timestamp;
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
    *   @params: int - $groupID
    *   @return: array - $data
    */
    public function getAssessments($groupID, $assignmentID) {
        $stmt = $this->conn->prepare("SELECT reportid, name, current_status AS status, R.content, feedback, score, A.userid, A.timestamp FROM assessments A JOIN reports R ON A.reportID=R.id JOIN groups G ON R.groupid=G.id JOIN status S ON A.statusid=S.id WHERE A.groupid=? AND R.assignmentid=?;");
        $stmt->bind_param("ii", $groupID, $assignmentID);
        
        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($reportID, $groupname, $status, $content, $feedback, $score, $userID, $timestamp);
            
            $data = array();
            while($stmt->fetch())
            {
                $row = array();
                $row["reportID"] = $reportID;
                $row["groupname"] = $groupname;
                $row["status"] = $status;
                $row["content"] = is_null($content) ? "":$content;
                $row["feedback"] = is_null($feedback) ? "":$feedback;
                $row["score"] = is_null($score) ? "-":$score;
                $row["fullname"] = $this->getFullname($conn, $userID);
                $row["timestamp"] = is_null($timestamp) ? "":$timestamp;
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
    *   @params: int - $groupID
    *   @return: int - $forumID
    */
    public function getForumID($groupID) {
        $stmt = $this->conn->prepare("SELECT id FROM forum WHERE groupid=?");
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
    *   @params: int - $forumID
    *   @return: array - $data
    */
    public function getAllThreads($forumID)
    {
        $stmt = $this->conn->prepare("SELECT id,title,timestamp FROM thread WHERE forumid=?");
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
    *   @params: int - $threadID
    *   @return: array - $data
    */
    public function getAllComments($threadID)
    {
        $stmt = $this->conn->prepare("SELECT C.id, U.name, U.lastname, C.content, C.timestamp FROM comment C JOIN users U ON U.id = C.userID WHERE threadID=?;");
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
    *   @params: int - $userID
    *   @return: string - $fullname
    */
    public function getFullname($userID) {
        if (is_null($userID)) {
            return "";
        }
        
        $stmt = $this->conn->prepare("SELECT name, lastname WHERE id=?;");
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
    
    
    /*
    *   Insert assessment of the user for the group
    *   @params: int - $userID
    *   @return: boolean - $success
    */
    public function createAssessment($feedback, $score, $userID, $groupID, $reportID) {
        $statusID = 21; //Use right status
        $timestamp = date("Y-m-d H:i:s");

        $stmt = $this->conn->prepare("UPDATE assessments SET statusid=?,feedback=?,score=?,userid=?,timestamp=? WHERE groupid=? AND reportid=?");
        $stmt->bind_param("isiisii", $statusID, $feedback, $score, $userID, $timestamp, $groupID, $reportID);
        
        if($stmt->execute()) {

            //TODO check update succeeded.
            return true;
            
        } else {
            die("An error occurred performing a request");
        }

    }
  
  
    /*
    *   Insert a thread given the forumID and title
    *   @params: int - $userID
    *   @return: int - $threadID
    */
	public function createThread($forumID, $title)
	{
		$timestamp = date("Y-m-d H:i:s");
        
        $stmt = $this->conn->prepare("INSERT INTO thread (forumid, title, timestamp) VALUES(?,?,?)");
        $stmt->bind_param("iss", $forumID, $title, $timestamp);
        
        if ($stmt->execute()) {
            $threadID = mysqli_insert_id($this->conn);
            $stmt->close();

            return $threadID;

        } else {
            die("An error occurred performing a request");
        }
	}
    

    /*
    *   Insert a comment given the threadID, the user who made the comment
    *   @params: int - $threadID, int
    *   @return: boolean - $success
    */
    public function createComment($threadID, $comment, $userID) {
        $timestamp = date("Y-m-d H:i:s");

        $stmt = $this->conn->prepare("INSERT INTO comment (threadid, content, userid, timestamp) VALUES(?,?,?,?)");
        $stmt->bind_param("isis", $threadID, $comment, $userID, $timestamp);
        
        if ($stmt->execute()) {
            $commentID = mysqli_insert_id($this->conn);
            $success = $commentID > 0;
            $stmt->close();

            return $success;

        } else {
            die("An error occurred performing a request");
        }
    }
    
}


?>
