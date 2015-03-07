<?php



require_once "sql_helper.php";
$sql_helper = new SQL_Helper();
$data = $sql_helper->getLoginDetails("mario@castle.com");
echo "d" .json_encode($data);

$sql_helper->close();


?>

