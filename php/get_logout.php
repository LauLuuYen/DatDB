<?php

header("Access-Control-Allow-Origin: *");

require_once "../php/session.php";

$userSession->logout();

?>
