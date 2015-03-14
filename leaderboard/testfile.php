<?php

class LeaderboardClass 
{
	
	public function retrieveLeaderboard() 
	{
	require_once "../php/include/sql_helper.php";
	$this->sql_helper = new SQL_Helper();
	
	$leaderboardArray1 = $this->sql_helper->fetchLeaderBoard();	
	//echo $leaderboardArray1;
	print_r($leaderboardArray1);
	$this->sql_helper->close();
	}
	
}
	
	$leaderboardinstance = new LeaderboardClass();
	$leaderBoardarray2 = $leaderboardinstance->retrieveLeaderboard();
	echo json_encode($leaderBoardarray2);
	//print_r($leaderBoardarray);
	
?>
