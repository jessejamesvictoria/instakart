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
<h3 style="padding-top:50px;">Terms and Services</h3>
<h5>By using Instakart you agree to our terms and servies</h5>
</div>
<div class="container">
 <div class="content">
		<div class="panel panel-default">
            <div class="panel-body">
            <h4>Advertiser Terms</h4>
<ul>
<li>Instakart Vendors can cancel the shoutout if they find content inappropraite.</li>
<li>You can canel the shoutout only before it is posted by vendor.</li>
<li>You must wait for atleast 12 hours for shoutout to be posted, even though you can cancel shoutout.</li>
<li>Spamming with orders and cancellation will result in Permanent Ban.</li>
</ul>
 <hr>
<h4>Vendor Terms</h4>
           
<ul>
<li>You must mark order as complete before you delete shoutout from Instagram Account.</li>
<li>Deleteing shoutout from Instagram account without marking shoutout as comeplet will void the shoutout / Order and you will need to post shoutout again.</li>
<li>Advertiser can cancel the shoutout before you start tracking / post shoutout.</li>
<li>If the added / Linked Instagram Account is not found due to username changed on Instagram then your account will be deleted from website.</li>
</ul>

<hr>
<h4>Refunds and Shoutout Cancellations</h4>
          
<ul>
<li>Advertiser can cancel the shoutout and get the full refund until the shoutout is not live.</li>
<li>Once the shoutout is Live only Vendor will be able to cancel the shoutout and Advertiser will get his full refund.</li>
<li>There will be no refund after the shoutout is completed.</li>
</ul>
</div>
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
