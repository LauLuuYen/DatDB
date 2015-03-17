<?php

session_start();
echo "Hello Now";
require_once "include/sql_helper.php";
echo "Hello Pikachu";
$sql_helper = new SQL_Helper();
echo "Hello";
$name = $sql_helper->getRole($_SESSION["roleID"]);
echo "Hello Dino";
$sql_helper->close();
echo $name;

?>

