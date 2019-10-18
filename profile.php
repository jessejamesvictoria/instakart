<?php
@session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title> User Profile </title>
</head>
<?php 
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'loggedinheader.php';
}
else
{
	header('Location: index.php');
}
?>
<?php
include 'head.php';
include 'core.inc.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
?>
<style>
body
{
padding-top:40px;
}
</style>
<body>

<div class="container">
<div class="page-header">
<h3 style="padding-top:50px;"> Profile </h3>
</div>

<div class="container">

        <div class="content">
		<div class="panel panel-default">
            <div class="panel-body">
            
                        
                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
	<div class="form-group">
   
		<label> Username </label>
   <span class="glyphicon glyphicon-user"></span>
		<span class="form-control"> <?php echo getfield('username')?> </span>
	</div>
	<div class="form-group">
   
		<label> Email </label>
		<span class="glyphicon glyphicon-envelope"></span> 
		<span class="form-control"> <?php echo getfield('email');?> </span>
	</div>
	<div class="form-group">
   
		<label> Join date </label>
		<span class="glyphicon glyphicon-modal-window"></span> 
		<span class="form-control"> <?php echo getfield('join_date'); ?></span>
	</div>
	<div class="form-group">
	</div>	

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

</html>
<?php
include 'footer.php';
}
else
{
	header('Location: index.php');
}
?>