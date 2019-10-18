<?php
@session_start();
include 'sqlconnect.php';
include 'instagram.php';
$query = "SELECT * FROM ig_accounts";
$run_query = mysqli_query($conn, $query);
while($rows = mysqli_fetch_assoc($run_query))
{
	$username = $rows['username'];
	$data = exploredata($username);
	if($data['status']==0)
	{
		$delete_query = "DELETE FROM ig_accounts WHERE username = '$username'";
		mysqli_query($conn, $delete_query);
	}
	else
	{
	$followers = $data['followers'];
	$profile_pic = $data['profile_pic'];
	$update_query = "UPDATE ig_accounts SET followers = $followers, profile_pic = '$profile_pic' WHERE username = '$username'";
	mysqli_query($conn, $update_query);
	}
}
?>