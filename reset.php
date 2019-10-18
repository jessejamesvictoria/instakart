<?php
@session_start();
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
include 'instagram.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'loggedinheader.php';
}
else if(isset($_SESSION['admin_id']))
{
	include 'adminheader.php';
}
else
{
	include 'navbar.php';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Explore </title>
</head>
<style>
body
{
padding-top:40px;
}
#main-content
{
	padding-top:6%;
}
</style>
<body>
<div class="container">
     <div class="content" id="main-content">
	 <h2> Under Construction </h2>
		</div>
     </div>
</body>