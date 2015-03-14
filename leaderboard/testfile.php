<?php

class LeaderboardClass 
{
	
	public function retrieveLeaderboard() 
	{
	require_once "../php/include/sql_helper.php";
	$this->sql_helper = new SQL_Helper();
	
	$leaderboardArray = $this->sql_helper->fetchLeaderBoard();	
	echo "Hello world";
	$this->sql_helper->close();
	}
	
}
	$leaderboardinstance = new LeaderboardClass();
	$leaderboardinstance->retrieveLeaderboard();
	
?>
