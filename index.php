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
	?>

<!DOCTYPE html>
<html>
<?php
include 'head.php';
?>
<head>
<title>IGshoutouts : Buy, Sell Instagram Shoutouts</title>
</head>
<style>
body
{
padding-top:40px;
}
#main-jumbo
{
background-attachment:fixed;
background-repeat:no-repeat;
background-image:url(http://i.imgur.com/Mupws4W.jpg?1);
background-size: cover;
padding:130px 0 130px 0;
}
</style>
<body>

<div class="jumbotron" id="main-jumbo">
	<div class="container text-center">
		<h1 style="color:white"> Shoutout IG </h1>
		<p style="color:white"> Instakart is #1 marketplace for buying and selling Shoutouts.</p>
		<div class="btn-group">
			<a href="explore" class="btn btn-lg btn-success">Explore</a>
		</div>
	</div><!-- End container again -->
</div><!-- End of Jumbotron -->
<div class="container">
<div class="row">
	<div class="col-lg-4">
		<div class="panel panel-default text-center">
			<div class="panel-body">
			<span class="glyphicon glyphicon-camera"></span>
				<h4> Quality Accounts</h4>
				<p> We provide quality shoutouts from HQ accounts.
					and provide the sorted results according to the
					account score maintained by our bot.
					
							</p>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="panel panel-default text-center">
			<div class="panel-body">
			<span class="glyphicon glyphicon-thumbs-up"></span>
				<h4> Satisfied Results</h4>
				<p> You are surely to get satisfied results from our HQ Instagram accounts.
					which are filtered based on score.
					
					
							</p>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="panel panel-default text-center">
			<div class="panel-body">
			<span class="glyphicon glyphicon-stats"></span>
				<h4> statistical Analysis</h4>
				<p> We keep track for every shoutout order and sale and provide full statistics for it.	
							</p>
			</div>
		</div>
	</div>
</div>
</div>

<?php
@include 'footer.php';
?>


<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>