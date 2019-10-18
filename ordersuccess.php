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
<head>
<title>Account Success</title>
</head>
<style>
body
{
	padding-top:70px;
}
</style>
<?php
include 'head.php';
include 'sqlconnect.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid'])&&isset($_SESSION['order_success']))
{
	include 'instagram.php';
?>
<body>
<div class="container">
<div class="page-header">
<div class="container" id="suc">

        <div class="content">
		<div class="panel panel-default">
            <div class="panel-body">  
            <center> <img src="http://i.imgur.com/DTeuMiy.png?1"/></br></br></br>
            <h4 style="color:green"> Your Shoutout has been submitted successfully, you can track your shoutouts <a href="myorders">here</a>.</h4>
            <a href="explore" class="btn btn-success">Explore More</a>
            <a href="dashboard" class="btn btn-warning">Home</a>
            </center>
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
unset($_SESSION['order_success']);
}
else
{
	header('Location: index.php');
}
?>