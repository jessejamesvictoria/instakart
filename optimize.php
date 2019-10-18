<?php
@session_start();
include 'sqlconnect.php';
$select_query = "SELECT * FROM registered_users WHERE confirmed = 0";
$run_s = mysqli_query($conn, $select_query);
while($row_s = mysqli_fetch_assoc($run_s))
{
	$uid = $row_s['uid'];
	$join_date = $row_s['join_date'];
	$join_date = strtotime($join_date);
	$time_now = time();
	$past_time = ($time_now - (86400*3));
	if($join_date <= $past_time)
	{
		$query = "DELETE FROM registered_users WHERE uid = $uid";
		mysqli_query($conn, $query);
	}
	else
	{
		continue;
	}
	
}
?>