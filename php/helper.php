<?php

header("Access-Control-Allow-Origin: *");


function getForumID($conn, $id) {
    $stmt = $conn->prepare("SELECT id FROM forum WHERE groupid=(SELECT groupid FROM users WHERE id=?);");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($userID);
        
        $registrant = $stmt->fetch();//Bind result with row
        $stmt->close();

        return $userID;
        
    } else {
        die("An error occurred performing a request");
    }
}



?>
