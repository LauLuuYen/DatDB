<?php

date_default_timezone_set("GMT");

require_once "config.php";

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
    *   Check if user already exist.
    *   @params: string - $email
    *   @return: bool - $exist
    */
    public function checkExist($email) {
		$stmt = $this->conn->prepare("SELECT email FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $registrant = $stmt->fetch();
            $stmt->close();
            $exist = count($registrant) > 0;
            return $exist;
            
        } else {
            die("An error occurred performing a request");
        }
    }
    

    /*
    *   Create user account
    *   @params: string - $name, string - $lastname, string - $email, 
    *            string - $password, int - $roleID, int - $groupID
    *   @return: bool - $success
    */
	public function createUser($name, $lastname, $email, $password, $roleID, $groupID) {
        $password_md5 = md5($this->password);
        $timestamp = date("Y-m-d H:i:s");
        
		$stmt = $this->conn->prepare("INSERT INTO users (name, lastname, email, password, roleid, groupid, timestamp) VALUES(?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssiis", $name, $lastname, $email, $password_md5, $roleID, $groupID, $timestamp);

        if ($stmt->execute()) {
       		$id = mysqli_insert_id($this->conn);
            $success = $id > 0;
            $stmt->close();
        
            return $success;
            
        } else {
            die("An error occurred performing a request");
        }
	}
	
    
    /*
    *   Create an empty group.
    *   @params: none
    *   @return: int - $groupID
    */
	public function createGroup($groupname) {
		$stmt = $this->conn->prepare("INSERT INTO groups (name) VALUES(?)");
        $stmt->bind_param("s", $groupname);

        if ($stmt->execute()) {
            $groupID = mysqli_insert_id($this->conn);
            $stmt->close();
            return $groupID;
            
        } else {
            die("An error occurred performing a request");
        }
	}
	

    /*
    *   Create an forum
    *   @params: int - $groupID
    *   @return: int - $forumID
    */
	public function createForum($groupID) {
		$stmt = $this->conn->prepare("INSERT INTO forum (groupid) VALUES(?)");
	        $stmt->bind_param("i", $groupID);
	
	        if ($stmt->execute()) {
	            $forumID = mysqli_insert_id($this->conn);
	            $stmt->close();
	            return $forumID;
	            
	        } else {
	            die("An error occurred performing a request");
	        }
	}
    
    
    /*
    *   Create assignment
    *   @params: string - $title, string - $task, string - $deadline
    *   @return: int - $assignmentID
    */
    public function createAssignment($title, $task, $deadline) {
        $timestamp = date("Y-m-d H:i:s");

        $stmt = $this->conn->prepare("INSERT INTO assignments (title, task, deadline, timestamp) values(?,?,?,?)");
        $stmt->bind_param("ssss", $title, $task, $deadline, $timestamp);
        
        if ($stmt->execute())  {
            $assignmentID = mysqli_insert_id($this->conn);
            $stmt->close();
            return $assignmentID;
            
        } else {
            die("An error occurred performing a request");
        }
    }


    /*
    *   Create assessment
    *   @params: int - $groupID, int - $reportID
    *   @return: bool - $success
    */
    public function createAssessment($groupID, $reportID) {
        $statusid = $this->getStatusID("Incomplete");
        
        $stmt = $this->conn->prepare("INSERT INTO assessments (groupid, reportid, statusid) values (?,?,?)");
        $stmt->bind_param("iii", $groupID, $reportID, $statusid);
        
        if ($stmt->execute())  {
            $stmt->close();
            return true;
            
        } else {
            die("An error occurred performing a request");
        }
    }


    /*
    *   Create report
    *   @params: int - $assignmentID, int - $groupid
    *   @return: int - $reportID
    */
    public function createReport($assignmentID, $groupid) {
        $statusid = $this->getStatusID("Incomplete");

        $stmt = $this->conn->prepare("INSERT INTO reports (groupid, assignmentid, statusid) values (?,?,?)");
        $stmt->bind_param("iii", $groupid, $assignmentID, $statusid);
    
        if ($stmt->execute())  {
            $reportID = mysqli_insert_id($this->conn);
            $stmt->close();
            return $reportID;
            
        } else {
            die("An error occurred performing a request");
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
                $report["content"] = is_null($content) ? "":str_replace("\n", "<br/>", $content);
                $report["status"] = $status;
                $report["fullname"] = $this->getFullname($userID);
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
    public function getAssessments($groupID) {
        $stmt = $this->conn->prepare("SELECT reportID, name, current_status, content, feedback, score, A.userid, A.timestamp, title, R.statusid FROM assessments A JOIN reports R JOIN groups G JOIN status S JOIN assignments AI ON A.reportID = R.id AND R.groupid = G.id AND A.statusid = S.id AND AI.id = R.assignmentid WHERE A.groupid=?;");
        $stmt->bind_param("i", $groupID);
        
        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($reportID, $groupname, $status, $content, $feedback, $score, $userID, $timestamp, $title, $r_statusID);
            
            $data = array();
            while($stmt->fetch()) {
                $reportstatus = $this->getStatus($r_statusID);
                $row = array();
                $row["reportID"] = $reportID;
                $row["groupname"] = $groupname;
                $row["_status"] = $status;
                $row["content"] = is_null($content) ? "":str_replace("\n", "<br/>", $content);
                $row["feedback"] = is_null($feedback) ? "-":str_replace("\n", "<br/>", $feedback);
                $row["score"] = is_null($score) ? "-":$score;
                $row["fullname"] = $this->getFullname($userID);
                $row["timestamp"] = is_null($timestamp) ? "":$timestamp;
                $row["title"] = $title;
                $row["status"] = $reportstatus;
                $row["isdisabled"] = $reportstatus != "Complete";
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
            $stmt->bind_result($id, $title, $timestamp);
            
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
    *   @params: int - $threadID, bool - $full
    *   @return: array - $data
    */
    public function getAllComments($threadID, $userID)
    {
        $stmt = $this->conn->prepare("SELECT C.id, U.name, U.lastname, C.content, userid, C.timestamp FROM comment C JOIN users U ON U.id = C.userID WHERE threadID=?;");
        $stmt->bind_param("i", $threadID);
        
         if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($id, $name, $lastname, $content, $c_userID, $timestamp);
            
            $data = array();
            while($stmt->fetch()) {
                $row = array();
                $row["commentID"] = $id;
                $row["fullname"] = $name . " " . $lastname;
                $row["timestamp"] = $timestamp;
                $row["content"] = str_replace("\n", "<br/>", $content);
                $row["candelete"] = $userID == $c_userID;
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
    
        $stmt = $this->conn->prepare("SELECT name, lastname FROM users WHERE id=?;");
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
    *   Update the report with new content and the user who submitted it.
    *   @params: string - $content, int - $userID, int - $reportID
    *   @return: boolean - $success
    */
    public function updateReport($content, $userID, $reportID) {
        $statusid = $this->getStatusID("Draft");
        $timestamp = date("Y-m-d H:i:s");

        $stmt = $this->conn->prepare("UPDATE reports SET statusid=?, content=?, userid=?, timestamp=? WHERE id=?");
        $stmt->bind_param("isisi", $statusid, $content, $userID, $timestamp, $reportID);
        
        if($stmt->execute()) {

            $stmt->close();
            
            return true;

        } else {
            die("An error occurred performing a request");
        }
    }
    
    
    /*
    *   Finalise the report into the complete state
    *   @params: int - $reportID
    *   @return: boolean - $success
    */
    public function updateFinalReport($reportID) {
        $statusid = $this->getStatusID("Complete");
        $timestamp = date("Y-m-d H:i:s");

        $stmt = $this->conn->prepare("UPDATE reports SET statusid=?, timestamp=? WHERE id=?");
        $stmt->bind_param("isi", $statusid, $timestamp, $reportID);
        
        if($stmt->execute()) {

            $stmt->close();
            return true;

        } else {
            die("An error occurred performing a request");
        }

    }
    

    /*
    *   Update assessment of the user for the group
    *   @params: string - $feedback, int - $score, int - $userID, int - $groupID, int - $reportID
    *   @return: boolean - $success
    */
    public function updateAssessment($feedback, $score, $userID, $groupID, $reportID) {
        $statusID = $this->getStatusID("Complete");
        $timestamp = date("Y-m-d H:i:s");

        $stmt = $this->conn->prepare("UPDATE assessments SET statusid=?,feedback=?,score=?,userid=?,timestamp=? WHERE groupid=? AND reportid=?");
        $stmt->bind_param("isiisii", $statusID, $feedback, $score, $userID, $timestamp, $groupID, $reportID);
        
        if($stmt->execute()) {
            $stmt->close();

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
    
    /*
    *   Get statusID
    *   @params: string - $status
    *   @return: int - $statusID
    */
    public function getStatusID($status) {
    
        $stmt = $this->conn->prepare("SELECT id FROM status WHERE current_status=?;");
        $stmt->bind_param("s", $status);
        
         if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($statusID);
            $stmt->fetch();
            
            $stmt->close();

            return $statusID;
            
        } else {
            die("An error occurred performing a request");
        }
    }
    

    /*
    *   Get status name by id
    *   @params: int - $statusID
    *   @return: string - $status
    */
    public function getStatus($statusID) {
    
        $stmt = $this->conn->prepare("SELECT current_status FROM status WHERE id=?;");
        $stmt->bind_param("i", $statusID);
        
         if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($status);
            $stmt->fetch();
            
            $stmt->close();

            return $status;
            
        } else {
            die("An error occurred performing a request");
        }
    }
    
    
    /*
    *   Get roleID
    *   @params: string - $role
    *   @return: int - $roleID
    */
	public function getRoleID($role) {
		$stmt = $this->conn->prepare("SELECT id FROM roles WHERE name=?");
        $stmt->bind_param("s", $role);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($roleID);
            
            $registrant = $stmt->fetch();//Bind result with row
            $stmt->close();

            return $roleID;
            
        } else {
            die("An error occurred performing a request");
        }
	}
    

    /*
    *   Get groupID of an existing group
    *   @params: none
    *   @return: int - $groupID
    */
	public function getGroupID($groupname) {
		$stmt = $this->conn->prepare("SELECT id FROM groups WHERE name=?");
        $stmt->bind_param("s", $groupname);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($groupID);
            
            $registrant = $stmt->fetch();//Bind result with row
            $stmt->close();

            return $groupID;
            
        } else {
            die("An error occurred performing a request");
        }
	}
    
    
    /*
    *   Get groupID and reportIDs
    *   @params: none
    *   @return: array - $data
    */
    public function getGroupReportIDs() {
        $stmt = $this->conn->prepare("SELECT * FROM groups");

        if ($stmt->execute())  {
            $stmt->store_result();
            $stmt->bind_result($id, $name);
            $data = array();
            
            while($stmt->fetch()) {
                $row = array();
                $row["groupid"] = $id;
                $row["reportid"] = -1;
                $data["" . $name] = $row;	
            }

            $stmt->free_result();
            $stmt->close();
            return $data;

        } else {
            die("An error occurred performing a request");
        }
    }
    
    
    /*
    *   Count the number of users in that specified group
    *   @params: string - $groupname
    *   @return: int - $groupcount
    */
	public function getGroupSize($groupname) {
		$stmt = $this->conn->prepare("SELECT count(*) AS groupcount FROM users WHERE groupid = (SELECT id FROM groups WHERE name=?)");
        $stmt->bind_param("s", $groupname);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($groupcount);
            
            $registrant = $stmt->fetch();//Bind result with row
            $stmt->close();

            return $groupcount;
            
        } else {
            die("An error occurred performing a request");
        }
	}
	
    
    /*
    *   Get all assignments for the admin
    *   @params: none
    *   @return: array - $data
    */
    public function getAllAssignments() {
        $stmt = $this->conn->prepare("SELECT id, title, task, deadline, timestamp FROM assignments;");
        
        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($id, $title, $task, $deadline, $timestamp);
            $data = array();
            
            while($stmt->fetch()) {
                $row = array();
                $row["assignmentID"] = $id;
                $row["title"] = $title;
                $row["task"] = str_replace("\n", "<br/>", $task);
                $row["deadline"] = $deadline;
                $row["created"] = $timestamp;
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
    *   Get all groups for the admin
    *   @params: bool - $stats
    *   @return: array - $data
    */
    public function getAllGroups($stats) {
        $stmt = $this->conn->prepare("SELECT id, name FROM groups;");
        
        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($id, $name);
            $data = array();
            
            while($stmt->fetch()) {
                $row = array();
                $row["groupID"] = $id;
                $row["groupname"] = $name;
                if ($stats) {
                    $row["reports"] = [];
                    $row["assessments"] = [];
                }
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
    *   Get all students
    *   @params: none
    *   @return: array - $data
    */
    public function getAllStudents() {
        $role = "Student";
        $stmt = $this->conn->prepare("SELECT id, name, lastname, email, groupid, timestamp FROM users WHERE roleid=(SELECT id FROM roles WHERE name=?);");
        $stmt->bind_param("s", $role);
        
        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($id, $name, $lastname, $email, $groupid, $timestamp);
            $data = array();

            while($stmt->fetch()) {
                $row = array();
                $row["userID"] = $id;
                $row["name"] = $name;
                $row["lastname"] = $lastname;
                $row["email"] = $email;
                $row["groupID"] = $groupid;
                $row["created"] = $timestamp;
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
    *   Get all assessments made by a group
    *   @params: none
    *   @return: array - $data
    */
    public function getAllAssessmentsInGroup($groupID) {
        $stmt = $this->conn->prepare("SELECT reportID, current_status, feedback, score, userid, timestamp FROM assessments A JOIN status S ON A.statusID = S.id WHERE groupID=?");
        $stmt->bind_param("i", $groupID);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($reportID, $status, $feedback, $score, $userID, $timestamp);
            $data = array();
            
            while($stmt->fetch()) {
                $row = array();
                $row["reportID"] = $reportID;
                $row["status"] = $status;
                $row["feedback"] = is_null($feedback) ? "":str_replace("\n", "<br/>", $feedback);
                $row["score"] = is_null($score) ? "-":$score;
                $row["userID"] = is_null($userID) ? "":$userID;
                $row["created"] = is_null($timestamp) ? "":$timestamp;
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
    *   Get all reports made by a group
    *   @params: none
    *   @return: array - $data
    */
    public function getAllReportsInGroup($groupID) {
        $stmt = $this->conn->prepare("SELECT R.id, assignmentid, current_status, content, userid, timestamp FROM reports R JOIN status S ON R.statusid = S.id WHERE groupid =?;");
        $stmt->bind_param("i", $groupID);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($reportID, $assignmentID, $status, $content, $userID, $timestamp);
            $data = array();
            
            while($stmt->fetch()) {
                $row = array();
                $row["reportID"] = $reportID;
                $row["assignmentID"] = $assignmentID;
                $row["status"] = $status;
                $row["content"] = is_null($content) ? "":str_replace("\n", "<br/>", $content);
                $row["userID"] = is_null($userID) ? "":$userID;
                $row["created"] = is_null($timestamp) ? "":$timestamp;
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
    *   Get assessment marks for a particular group
    *   @params: int - $groupID
    *   @return: array - $data
    */
    public function getAssessmentMarksInGroup($groupID) {
        $stmt = $this->conn->prepare("SELECT R.id, AE.groupid, A.title, current_status, feedback, score, AE.timestamp FROM reports R JOIN assignments A JOIN assessments AE JOIN status S ON R.assignmentid = A.id AND AE.reportid = R.id AND AE.statusid = S.id WHERE R.groupid = ?;");
        $stmt->bind_param("i", $groupID);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($reportID, $o_groupID, $title, $status, $feedback, $score, $timestamp);
            $data = array();
            
            while($stmt->fetch()) {
                $row = array();
                $row["assessmentID"] = $reportID . $o_groupID;
                $row["title"] = $title;
                $row["status"] = $status;
                $row["feedback"] = is_null($feedback) ? "":str_replace("\n", "<br/>", $feedback);
                $row["score"] = is_null($score) ? "-":$score;
                $row["timestamp"] = is_null($timestamp) ? "":$timestamp;
                $row["isdisabled"] = $status != "Complete";
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
    *   Get all the available groups of less than 3 members
    *   @params: none
    *   @return: array - $data
    */
    public function getAvailableGroups() {
        $stmt = $this->conn->prepare("SELECT G.name, COUNT(*) FROM users U JOIN groups G ON U.groupid = G.id GROUP BY groupid HAVING COUNT(*) < 3;");

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($name, $count);
            $data = array();
            
            while($stmt->fetch()) {
                $row = array();
                $data[] = $name;
            }

            $stmt->free_result();
            $stmt->close();
            return $data;
            
        } else {
            die("An error occurred performing a request");
        }
    }
    
	//Leaderboard function
	public function fetchLeaderBoard()
	{
		$stmt = $this->conn->prepare("SELECT groups.name,reports.groupid, reportid, AVG(score) FROM assessments INNER JOIN reports ON (assessments.reportid = reports.id) INNER JOIN groups ON (reports.groupid = groups.id) GROUP BY reportid ORDER BY AVG(score) DESC;");
		if ($stmt->execute()) 
		{
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
	        } 
	        else 
	        {
	            die("An error occurred performing a request");
	        }
	}
	
    public function deleteComment($commentID, $userID) 
    {
        $stmt = $this->conn->prepare("DELETE FROM comment WHERE id=? AND userid=?");
        $stmt->bind_param("ii", $commentID, $userID);
        
        if ($stmt->execute()) 
        { 	
            $stmt->close();
            return true;
        } 
        else 
        {
            die("An error occurred performing a request");
        }
    }
    
    public function getRole($roleID)
    {
    	$stmt = $this->conn->prepare("SELECT name FROM roles WHERE id=?;");
        $stmt->bind_param("i", $roleID);
         if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($userRole);
            $stmt->fetch();
            $stmt->close();
            return $userRole;
        } 
        else 
        {
            die("An error occurred performing a request");
        }
    }
	
	
	public function getThreadOwner($threadID) 
    	{
	        $stmt = $this->conn->prepare("SELECT userid FROM comment WHERE threadid=? ORDER BY timestamp ASC LIMIT 1;");
	        $stmt->bind_param("i", $threadID);
        
	        if ($stmt->execute()) {
	            $stmt->store_result();
	            $stmt->bind_result($userID);
	            $stmt->fetch();
	            $stmt->close();
	            return $userID;
	        } 
	        else 
	        {
	            die("An error occurred performing a request");
	        }
    	}
	
	
}


?>
