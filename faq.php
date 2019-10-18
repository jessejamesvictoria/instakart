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
<h3 style="padding-top:50px;">FAQ's</h3>
</div>
<h3 style="color:#014B98">Advertiser Questions</h3>
<p style="color:#0050BC">How long does it take to post a shoutout ?</p>
<p>It depends upon the Vendor when he decides to post shoutout. but if he / she takes too long, you can cancel the shoutout and get your refund.</p>
</br>
<p style="color:#0050BC">My shoutout was live and now is shows not posted yet ?</p>
<p>once Vendor posts shoutout you can check the statistics of shoutout. But if Vendor deleted the shoutout or make changes in post the shoutout will be marked as void and Vendor will need to post the shoutout again. so that's your profit in short.</p>
</br>
<p style="color:#0050BC">My shoutout is not yet posted by Publisher, what should i do ?</p>
<p>In case if Vendor is inactive it will take bit more time for him / her to post shoutout but you can cancel the shoutout anytime until it is not published.</p>
</br>
<p style="color:#0050BC">I want to withdraw money i deposited.</p>
<p>It depends upon the Vendor when he decides to post shoutout. but if he / she takes too long, you can cancel the shoutout and get your refund.</p>
</br>
<h3 style="color:#014B98">Vendor/Publisher Questions</h3>
<p style="color:#0050BC">I added Instagram Account but it doesn't shows in My Accounts list ?</p>
<p>Every instagram account is first confirmed by Administrator and then published on website, if your Instagram account is not eligible then it will be deleted, but you can still resubmit account application. <br> Note: You should not resubmit application again and again if it's denied by admin, it will result in Permanent Ban for the specified Instagram Account.</p>
</br>
<p style="color:#0050BC">How long does it take for withdrawing money into my paypal account ?</p>
<p>All the payments are checked manually and it will take about 2-4 business days to complete payment.</p>
</br>
<p style="color:#0050BC">Why is my Instagram account deleted ?</p>
<p>If you change the Instagram Username of linked account then it will result in deletion of account and you will need to resubmit account for approval.</p>
</br>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<?php
include 'footer.php';
?>
</body>
</html>
