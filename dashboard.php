<?php 
@session_start();
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'loggedinheader.php';
	
}
else
{
	header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<?php
include 'head.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'sqlconnect.php';
	include 'instagram.php';
	include 'core.inc.php';
?>
<style>
body
{
padding-top:40px;
}
#dash
{
	padding-top:30px;
}
</style>
<head>
<title> User Dashboard </title>
</head>
<body>
<div class="container">
     <div class="content" id="dash">
            <div class="panel-header">
                <h3 >
                <?php 
				$uid = $_SESSION['uid'];
				$get_username_query = "SELECT username FROM registered_users WHERE uid = $uid";
				$run_get_query = mysqli_query($conn, $get_username_query);
				$rows = mysqli_fetch_assoc($run_get_query);
				$username = $rows['username'];
				?>
                   Welcome <?php echo $username ?>
                </h3>
                <div class="panel-body">
                <p>If you are looking to sell shoutouts, please <a href="find">add new account</a> on accounts page! </p>
           		<div class="bg-info col-xs-12">
                <div class="col-xs-12 col-sm-6 text-center">
                <h2> $<?php echo total_balance() ?> </h2>
                <small> Total Balance | <a href="withdraw">Withdraw</a> | <a href="addbalance">Deposit</a></small>
                <br>
                </div>
                 <div class="col-xs-12 col-sm-6 text-center">
                <h2><?php total_orders(); ?> <span class="glyphicon glyphicon-envelope"></h2> 
                <small>Total Received Orders, <a href="todos">View</a> | <a href="myorders">My Orders</a></small>
                <br>
                </div>
                </div>
                <div class="col-xs-12">
                	<div class="col-xs-12 col-sm-6 text-center">
                    	<h2>$<?php total_earned();?></h2>
                        <small> Total Earned </small>
                        <br>
                    </div>
                      <div class="col-xs-12 col-sm-6 text-center">
                <h2><?php total_sold(); ?> <span class="glyphicon glyphicon-camera"></h2> 
                <small> Shoutouts Sold. </a></small>
                <br>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>




<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
<?php
include 'footer.php';
}
else
{
	header('Location: index.php');
}