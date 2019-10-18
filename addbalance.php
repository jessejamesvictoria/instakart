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
<title>Add Balance</title>
</head>
<?php
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'instagram.php';
?>
<style>
body
{
padding-top:40px;
}
#msg
{
	padding-top:40px;
}
.pay
{
	clear:both;
	padding:20px 0px 0px 20px;
}
</style>
<body>
<div class="container">
<?php
if(isset($_POST['amount'])&&isset($_POST['token']))
{
	if(!empty($_POST['amount'])&&!empty($_POST['token']))
	{
		$tokenr = addslashes(strip_tags($_POST['token']));
		$tokenr = mysqli_real_escape_string($conn, $tokenr);
		if($tokenr == $_SESSION['token'])
		{
			$amount = addslashes(strip_tags($_POST['amount']));
			$amount = mysqli_real_escape_string($conn, $amount);
			if($amount != 50 && $amount != 100 && $amount != 200 && $amount != 500 && $amount != 1000 && $amount != 2000)
			{
				?>
                <br><br><br>
            <div class="alert alert-danger" role="alert" width="200" height="60">
        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
            <span aria-hidden="true">x</span>
        </button>
        <ul>
            <li>Invalid amount.</li>
        </ul>
        </div>
        <?php
			}
			else
			{
				$valid = true;
			}
		}
		else
		{
			?>
            <br><br><br>
            <div class="alert alert-danger" role="alert" width="200" height="60">
        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
            <span aria-hidden="true">x</span>
        </button>
        <ul>
            <li>Something went wrong.</li>
        </ul>
        </div>
        <?php
		}
	}
}
?>
<div class="page-header">
<h2 style="padding-top:50px;">Your balance is $ <?php echo $my_bal; ?></h2>
</div>
<div class="content">

	<form method="post" action="addbalance">
    <div class="panel panel-default">
	<div class="panel-heading" >Add Balance</div>
    <div class="panel-body">
    <label class="col-sm-2 control-label" for="username" id="label">Amount</label>
    		<div class="col-sm-8">
            <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">
            <span class="glyphicon glyphicon-usd"></span> 
            </div>
            <select class="form-control" name="amount" onchange="this.form.submit()">
            	<option <?php if(isset($_POST['amount'])){ if($valid == true){if($amount == 50){ echo "selected";}}}?> value="50">50</option>
                <option <?php if(isset($_POST['amount'])){ if($valid == true){if($amount == 100){ echo "selected";}}}?> value="100">100</option>
                <option <?php if(isset($_POST['amount'])){ if($valid == true){if($amount == 200){ echo "selected";}}}?> value="200">200</option>
                <option <?php if(isset($_POST['amount'])){ if($valid == true){if($amount == 500){ echo "selected";}}}?> value="500">500</option>
                <option <?php if(isset($_POST['amount'])){ if($valid == true){if($amount == 1000){ echo "selected";}}}?> value="1000">1000</option>
                <option <?php if(isset($_POST['amount'])){ if($valid == true){if($amount == 2000){ echo "selected";}}}?> value="2000">2000</option>
            </select>
            </div>
            </div>
             </div>
             
             <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
    </form>
	<div class="pay">
<form action="order_process.php" method="post">
    <input type="hidden" name="item_name" value="Instakart - Add Balance" />
    <input type="hidden" name="item_price" value="50"/>
    <input type="hidden" name="item_code" value="1"/>
    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form> 
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
	header('Location: index');
}
?>