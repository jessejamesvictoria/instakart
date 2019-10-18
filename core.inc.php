<?php
@session_start();
@include 'sqlconnect.php';
if(isset($_SESSIONS['uid'])){
	$uid = $_SESSION['uid'];
}
function getfield($the_field)
{	
	@include 'sqlconnect.php';
	$field = $the_field;
	@session_start();
	$uid = $_SESSION['uid'];
	$query = "SELECT $field FROM registered_users WHERE uid = $uid";
	$run_query = mysqli_query($conn, $query);
	$fetch_row = mysqli_fetch_assoc($run_query);
	return $fetch_row["$field"];
}
function get_ip() {
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else {
		return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	}
}
function total_users()
{
	@include 'sqlconnect.php';
	$select_total_users_query = "SELECT * FROM registered_users";
	$run_total_query = mysqli_query($conn, $select_total_users_query);
	$total_count = mysqli_num_rows($run_total_query);
	echo $total_count;
}
function total_accounts()
{
	@include 'sqlconnect.php';
	$select_total_users_query = "SELECT * FROM ig_accounts WHERE confirmed = 1";
	$run_total_accounts_query = mysqli_query($conn, $select_total_users_query);
	$total_accounts_count = mysqli_num_rows($run_total_accounts_query);
	echo $total_accounts_count;
}
function need_approval()
{
  	@include 'sqlconnect.php';
	$select_need_approval = "SELECT * FROM ig_accounts WHERE confirmed = 0 ";
	$run_need_approval = mysqli_query($conn, $select_need_approval);
	echo $no_of_need_approval = mysqli_num_rows($run_need_approval);
	
}
function total_balance()
{
	@include 'sqlconnect.php';
	$uid = $_SESSION['uid'];
	$balance_query = "SELECT balance FROM balance WHERE uid = $uid";
	$run_balanced_query = mysqli_query($conn, $balance_query);
	$row = mysqli_fetch_assoc($run_balanced_query);
	$no_of_rows = mysqli_num_rows($run_balanced_query);
	if($no_of_rows != 0)
	{
	echo $row['balance'];
	}
	else
	{
	echo "0";
	}
}
function total_earned()
{
	@include 'sqlconnect.php';
	$uid = $_SESSION['uid'];
	$earned_query = "SELECT earned FROM balance WHERE uid = $uid";
	$run_earned_query = mysqli_query($conn, $earned_query);
	$row = mysqli_fetch_assoc($run_earned_query);
	$no_of_rows = mysqli_num_rows($run_earned_query);
	if($no_of_rows != 0)
	{
	echo $row['earned'];
	}
	else
	{
	echo "0";
	}
}
function total_orders()
{
	@include 'sqlconnect.php';
	$seller_id = $_SESSION['uid'];
	$get_orders_query = "SELECT * FROM orders WHERE seller_id=$seller_id";
	$run_orders_query = mysqli_query($conn, $get_orders_query);
	$row = mysqli_num_rows($run_orders_query);
	if($row != 0 )
	{
		echo $row;
	}
	else
	{
		echo "0";
	}
}
function total_sold()
{
	@include 'sqlconnect.php';
	$seller_id = $_SESSION['uid'];
	$get_sold_query = "SELECT * FROM orders WHERE seller_id=$seller_id and track_stauts=2";
	$run_sold_query = mysqli_query($conn, $get_sold_query);
	$row = mysqli_num_rows($run_sold_query);
	if($row !=0 )
	{
		echo $row;
	}
	else
	{
		echo "0";
	}
}
function all_user_sales()
{
	@include 'sqlconnect.php';
	$q = "SELECT * FROM orders WHERE track_status = 2";
	$r_q = mysqli_query($conn, $q);
	$n_rows = mysqli_num_rows($r_q);
	if($n_rows == 0)
	{
		echo "0";
	}
	else
	{
		echo $n_rows;
	}
}
function total_messages()
{
	@include 'sqlconnect.php';
	$query = "SELECT * FROM contacts";
	$r_query = mysqli_query($conn, $query);
	$num_rows = mysqli_num_rows($r_query);
	if($num_rows == 0)
	{
		echo "0";
	}
	else
	{
		echo $num_rows;
	}
}
?>