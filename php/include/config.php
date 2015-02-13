<?php

    define("DB_USERNAME", "ba04b5e16c0e89");
    define("DB_PASSWORD", "4e6c24f2");
    define("DB_HOST", "eu-cdbr-azure-west-b.cloudapp.net");
    define("DB_NAME", "lauluuyen");
  
  //TODO remove
  function connectDB() {
      try {
          $conn = new PDO( "mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
          $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      }
      catch(Exception $e) {
          die(var_dump($e));
      }
      
      return $conn;
  }

    /*
    *   Establish connection to database.
    *   @params: none
    *   @return: mysqli - $conn
    */
    function connectDatabase() {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
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
    function closeDatabase($conn) {
        $conn->close();
    }

?>
