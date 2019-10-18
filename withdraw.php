<?php
@session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Withdraw Funds</title>
<style>
body
{
padding-top:30px;
}
.content
{
	padding-top:4%;
}
</style>
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
include 'instagram.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
?>
<body>
<div class="container">
<div class="content">
<div class="col-xs-12 col-sm-6 col-sm-offset-3">
<?php
if(isset($_POST['pp_email'])&&isset($_POST['token'])&&isset($_POST['submit'])&&isset($_POST['repeat_pp_email']))
{
	if(!empty($_POST['pp_email'])&&!empty($_POST['token'])&&!empty($_POST['repeat_pp_email']))
	{
		$tokenr = addslashes(strip_tags($_POST['token']));
		$tokenr = mysqli_real_escape_string($conn, $tokenr);
		if($tokenr == $_SESSION['token'])
		{
			$email = addslashes(strip_tags($_POST['pp_email']));
			$email = mysqli_real_escape_string($conn, $email);
			$repeat_email = addslashes(strip_tags($_POST['repeat_pp_email']));
			$repeat_email = mysqli_real_escape_string($conn, $repeat_email);
			$uid = $_SESSION['uid'];
			$get_my_balance = "SELECT balance FROM balance WHERE uid = $uid";
			$run_get_my_balance_query = mysqli_query($conn, $get_my_balance);
			$fetch_balance_rows = mysqli_fetch_assoc($run_get_my_balance_query);
			$my_balance = $fetch_balance_rows['balance'];
			if($email == $repeat_email)
			{
			$check_pre_pay = "SELECT * FROM payments WHERE uid = $uid AND status = 0";
			$run_pre = mysqli_query($conn, $check_pre_pay);
			$num_pre = mysqli_num_rows($run_pre);
			if($num_pre == 0)
			{
			if($my_balance < 10)
			{
				?>
                <div class="alert alert-info" role="alert" width="200" height="60">
                <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">x</span>
                </button>
                <ul>
                    <li>Minimum payout amount is $ 10.</li>
                </ul>
                </div>
                <?php
			}	
			else if($my_balance < 0)
			{
				?>
                <div class="alert alert-danger" role="alert" width="200" height="60">
                <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">x</span>
                </button>
                <ul>
                    <li>Something went wrong, Please contact Admin for help.</li>
                </ul>
                </div>
                <?php
			}
			else
			{
				$insert_query = "INSERT INTO payments (uid,pp_email) VALUES($uid,'$email')";	
				if(mysqli_query($conn, $insert_query))
				{
					?>
                    <div class="alert alert-success" role="alert" width="200" height="60">
                    <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                     <span aria-hidden="true">x</span>
                    </button>
                    <ul>
                      <li>Withdraw request has been processed, you will get your payment within 48 hours.</li>
                    </ul>
                    </div>
                    <?php
				}
				else
				{
					?>
                    <div class="alert alert-danger" role="alert" width="200" height="60">
               		 <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">x</span>
                    </button>
                    <ul>
                        <li>Something went wrong, Please contact Admin for help.</li>
                    </ul>
                    </div>
                    <?php
				}
			}
			}
			else
			{
			?>
			<div class="alert alert-info" role="alert" width="200" height="60">
               		 <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">x</span>
                    </button>
                    <ul>
                        <li>Please wait while previous payment is processed.</li>
                    </ul>
                    </div>
                    <?php
			}
		}
		else
		{
			?>
			<div class="alert alert-danger" role="alert" width="200" height="60">
			 <button class="close" aria-label="Close" data-dismiss="alert" type="button">
				<span aria-hidden="true">x</span>
			</button>
			<ul>
				<li>Email doesn't match.</li>
			</ul>
			</div>
			<?php
		}
		}
		else
		{
			 ?>
            <div class="panel-body">
            <h3 style="padding:5px;" class="text-muted"> Something went wrong </h3>
            </div>
            <?php
                die();
		}
	}
}
?>
            <div class="page-header">
            <h3>Withdraw Funds</h3>
            </div>
	<div class="panel panel-body">
    
    	 <form action="withdraw" method="post">
    			<div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-envelope"></span> 
								   </div>
								   <input  type="email" class="form-control" name="pp_email" placeholder="Your paypal email"/>
						     </div><br>
                             <div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-envelope"></span> 
								   </div>
								   <input  type="email" class="form-control" name="repeat_pp_email" placeholder="Repeat email"/>
						     </div>
						</div>
            <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
            <button class="btn btn-success" name="submit">Submit</button>
    	 </form>
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