<?php

session_start();
require_once "include/sql_helper.php";
$sql_helper = new SQL_Helper();
$name = $sql_helper->getRole($_SESSION["roleID"]);
$sql_helper->close();
echo $name;

?>

