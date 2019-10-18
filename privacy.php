<?php 
@session_start();
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'loggedinheader.php';
}
else if(isset($_SESSION['admin_id'])&&!empty($_SESSION['admin_id']))
{
	include 'adminheader.php';
}
else
{
	include 'navbar.php';
}
include 'head.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Instakart Privacy Policy</title>
</head>
<style>
body
{
padding-top:40px;
}
</style>
<body>
<div class="container">
<div class="page-header">
<h3 style="padding-top:50px;">Privacy Policy</h3>
<h5> We always give security and privacy first priority </h5>
</div>
 <div class="content">
		<div class="panel panel-default">
            <div class="panel-body">
<ul>
<li> We will never publicize your Email, Password or any other private info that is associated with the account </li>
<li> We will never sell your personal information by any means </li>
<li> Your account passwords are encrypted, and you have the ability to change it whenever you need </li>
<li> You will never receive any unwanted emails from us </li>
</ul>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<?php
include 'footer.php';
?>
</body>
</html>
