<?php
require_once "session.php";
echo $userSession->getSessionVal("userID");
$userSession->destroySession();
?>

