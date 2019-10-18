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
<title>Get Started with Instakart</title>
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
<center><h3 style="padding-top:50px;">Start Selling Shoutouts.</h3>
<h5>It's easy to link and start making money by selling shoutouts.</h5></center>
</div>
<div class="container">
<div class="col-xs-8 col-xs-offset-2">
<div class="row">
<div class="col-sm-3">
<img src="images/cat.png" class="img-responsive">
</div>
<div class="col-sm-9">
<h3 style="color:#00519E">Accounts with different Categories</h3>
<p>Publisher accounts are sorted in different categories to make you easier to find what you exactly need.</p>
</div>
</div>
</div>
 <br><br>
<div class="col-xs-8 col-xs-offset-2">
<div class="row">
<div class="col-sm-9">
<h3 style="color:#00519E">Low transaction fees</h3>
<p>We deduct only upto 10% of fees of every payment or withdraw you do.</p>
</div>
<div class="col-sm-3">
<img src="images/money.png" class="img-responsive">
</div>
</div>
</div>
<div class="col-xs-8 col-xs-offset-2">
 <br><br>
<div class="row">
<div class="col-sm-3">
<img src="images/refund.png" class="img-responsive">
</div>
<div class="col-sm-9">
<h3 style="color:#00519E">Easy Cancellation, Refund</h3>
<p>Buyer/Seller can cancel shoutouts with one click. Buyer will get 100% refund without any transaction fees.</p>
</div>
</div>
</div>
<div class="col-xs-8 col-xs-offset-2">
 <br><br>
<div class="row">
<div class="col-sm-7">
<h3 style="color:#00519E">Statistics</h3>
<p>Easy to check statistics for any shoutout.</p>
</div>
<div class="col-sm-5">
<img src="images/stats.png" class="img-responsive">
</div>
</div>
</div>
<center>
<div class="col-xs-8 col-xs-offset-2">
<br><br>
So, what are you waiting for ? <br><br>
<a href="register"><button class="btn btn-success">Register Now</button></a></center>
</div>
<br><br>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<?php
include 'footer.php';
?>
</body>
</html>
