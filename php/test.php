<?php

session_start();

require_once "include/sql_helper.php";
$this->sql_helper = new SQL_Helper();
$name = $this->sql_helper->getRole($_SESSION["roleID"]);
$this->sql_helper->close();
echo $name;

?>

