<?php

session_start();
echo "Hello Now";
require_once "include/sql_helper.php";
$this->sql_helper = new SQL_Helper();
echo "Hello";
$name = $this->sql_helper->getRole($_SESSION["roleID"]);
echo "Hello Dino";
$this->sql_helper->close();
echo $name;

?>

