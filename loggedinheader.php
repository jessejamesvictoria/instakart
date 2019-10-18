<?php
@session_start();
@include 'sqlconnect.php';
if(isset($_SESSION['uid']))
{
	$uid = $_SESSION['uid'];
	$get_my_balance = "SELECT balance FROM balance WHERE uid = $uid";
	$run_query = mysqli_query($conn, $get_my_balance);
	$rows = mysqli_fetch_assoc($run_query);
	$num_rows = mysqli_num_rows($run_query);
	if($num_rows == 0)
	{
		$my_bal = 0;
	}
	else
	{
		$my_bal = $rows['balance'];
	}
?>
<nav class="navbar navbar-inverse navbar-fixed-top" id="my-navbar">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="" class="navbar-brand">IGShoutouts</a>
		</div><!-- Navbar header -->
		<div class="collapse navbar-collapse" id="navbar-collapse">
		
			<ul class="nav navbar-nav navbar-right">
				<li><a href="explore"><span class="glyphicon glyphicon-search"> Explore</a></li>
                <li><a href="addbalance" title="balance"><span class="glyphicon glyphicon-usd"> <strong><span style="font-size:15px;"><?php echo $my_bal;?></span></strong></a></li>
				<li><a href="dashboard" title="dashboard"><span class="glyphicon glyphicon-signal">&nbsp;Dashboard<span class="visible-xs" >Dashboard</span></a></li>
				<li><a href="myaccounts" title="accounts"><span class="glyphicon glyphicon-camera">&nbsp;Accounts<span class="visible-xs" >My Acconts</span></a></li>
				<li><a href="profile" title="profile"><span class="glyphicon glyphicon-user">&nbsp;Profile<span class="visible-xs" >Profile</span></a></li>
				<li><a href="logout" title="logout"><span class="glyphicon glyphicon-log-out"><span class="visible-xs" >Logout</span></a></li>
		
			</ul>
		</div>
		
	</div><!-- End of the container -->
</nav><!-- End of the navbar -->
<?php
}
?>