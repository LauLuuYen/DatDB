<?php

    define("DB_USERNAME", "ba04b5e16c0e89");
    define("DB_PASSWORD", "4e6c24f2");
    define("DB_HOST", "eu-cdbr-azure-west-b.cloudapp.net");
    define("DB_NAME", "lauluuyen");

    /*
    *   Establish connection to database.
    *   @params: none
    *   @return: mysqli - $conn
    */
    function connectDB() {
        $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
            die("Failed to connect to database");
        }
        return $conn;
    }


    /*
    *   Close database connection.
    *   @params: mysqli - $conn
    *   @return: none
    */
    function closeDB($conn) {
        $conn->close();
    }

?>
