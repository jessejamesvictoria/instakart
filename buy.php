<?php
@session_start();
ob_start();
ini_set('upload_max_filesize','12M');
ini_set('post_max_size','12M');
?>
<!DOCTYPE html>
<html>
<?php 
include 'head.php';
include 'sqlconnect.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'loggedinheader.php';
}
else
{?>
<div class="container">
<div class="content" style="padding-top:8%;">
	<?php include 'navbar.php';
	echo "<h4> You must be logged in to continue with purchase,<br>Login <a href='login'>Here</a> OR Register <a href='register'>Here</a> </h4>";
	die();
	?>
    </div></div>
    <?php
}
?>
<head>
<title>Buy Shoutout</title>
<style>
body
{
padding-top:40px;
}
.content
{
	padding-top:4%;
}
</style>
</head>
<body>
<?php
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'instagram.php';
?>
<body>
<div class="container">
<div class="content">
<?php
//form validation
	if(isset($_POST['email'])&&isset($_POST['content'])&&isset($_POST['time'])&&isset($_POST['token'])&&isset($_POST['submit_form']))
	{
		if(!empty($_POST['email'])&&!empty($_POST['content'])&&!empty($_POST['time'])&&!empty($_POST['token']))
		{
			$tokenr = addslashes(strip_tags($_POST['token']));
			$tokenr = mysqli_real_escape_string($conn, $tokenr);
			if($tokenr == $_SESSION['token'])
			{
				$file = $_FILES['file']['name'];
				if(isset($file))
				{	
					if(!empty($file))
					{
					$file_tmp_name = $_FILES['file']['tmp_name'];
					$file_size = $_FILES['file']['size'];
					$file_type = $_FILES['file']['type'];
					$file_size_needed = 11000000;
						if($file_size > $file_size_needed )
						{
							?>
                            <div class="alert alert-danger" role="alert" width="200" height="60">
							<button class="close" aria-label="Close" data-dismiss="alert" type="button">
								<span aria-hidden="true">x</span>
							</button>
							<ul>
								<li>Please choose a file size under 10 MB.</li>
							</ul>
							</div>
                            <?php
						}
						else
						{
						   if($file_type != 'image/jpeg' && $file_type != 'video/mp4')
							{
								?>
                                <div class="alert alert-danger" role="alert" width="200" height="60">
							<button class="close" aria-label="Close" data-dismiss="alert" type="button">
								<span aria-hidden="true">x</span>
							</button>
							<ul>
								<li>Valid file types are .jpeg / .mp4</li>
							</ul>
							</div>
                                <?php
							}
							else
							{
								$time = addslashes(strip_tags($_POST['time']));
								$time = mysqli_real_escape_string($conn, $time);
								$email = addslashes(strip_tags($_POST['email']));
								$email = mysqli_real_escape_string($conn, $email);
								$content = addslashes(strip_tags($_POST['content']));
								$content = mysqli_real_escape_string($conn, $content);	
								$buying_username = $_SESSION['buy_user'];
								$get_sellerid_query = "SELECT * FROM ig_accounts WHERE username = '$buying_username'";
								$run_sellerid_query = mysqli_query($conn, $get_sellerid_query);
								$row = mysqli_fetch_assoc($run_sellerid_query);
								$uid = $_SESSION['uid'];
								$get_my_username = "SELECT username FROM registered_users WHERE uid = $uid";
								$run_my_query = mysqli_query($conn, $get_my_username);
								$rows = mysqli_fetch_assoc($run_my_query);
								$username = $rows['username'];
								$_SESSION['my_username'] = $username;
								$price = $row['account_amount'];
								$time_hours = $row['account_time'];
								$seller_id = $row['uid'];
								$buyer_id = $_SESSION['uid'];
								//Balance alter
								$my_balance_query = "SELECT * FROM balance WHERE uid= $uid";
								$run_my_balance_query = mysqli_query($conn, $my_balance_query);
								$balance_num_rows = mysqli_num_rows($run_my_balance_query);
								if($seller_id == $buyer_id)
								{
									?>
                                    <div class="alert alert-danger" role="alert" width="200" height="60">
                                    <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true">x</span>
                                    </button>
                                    <ul>
                                    <li>You cannot buy your own Shoutout.</li>
                                    </ul>
                                    </div>
                                    <?php
								}
								else
								{
								if($balance_num_rows == 0)
								{
									?>
                                    <div class="alert alert-danger" role="alert" width="200" height="60">
                                    <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true">x</span>
                                    </button>
                                    <ul>
                                    <li>You donot have enough balance to buy shoutout.</li>
                                    </ul>
                                    </div>
                                    <?php
								}
								else
								{
									$my_balance_rows = mysqli_fetch_assoc($run_my_balance_query);
									$my_balance = $my_balance_rows['balance'];
									if($my_balance < $price)
									{
										?>
									<div class="alert alert-danger" role="alert" width="200" height="60">
                                    <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true">x</span>
                                    </button>
                                    <ul>
                                    <li>You donot have enough balance to buy shoutout.</li>
                                    </ul>
                                    </div>
                                    <?php
									}
									else
									{
										$my_balance = ($my_balance-$price);
										$update_balance_query = "UPDATE balance SET balance = $my_balance WHERE uid = $uid";
										if(mysqli_query($conn, $update_balance_query))
										{
											$check_seller_balance = "SELECT balance FROM balance WHERE uid = $seller_id";
											$run_check_query = mysqli_query($conn, $check_seller_balance);
											$num_of_seller_rows = mysqli_num_rows($run_check_query);
											if($num_of_seller_rows == 0)
											{
											$insert_seller_balance = "INSERT INTO balance (uid,pending_balance) VALUES($seller_id,$price)";
												if(mysqli_query($conn, $insert_seller_balance))
												{
													$insert = true;
												}
											}
											else
											{
												$update_seller_balance_query = "UPDATE balance SET pending_balance = $price WHERE uid = $seller_id";
												if(mysqli_query($conn, $update_seller_balance_query))
												{
													$update = true;
												}
											}
											if($insert == true || $update == true)
												{
												echo "hello world";
												$to = "shobhitbhosure7@gmail.com";
												$subject = "Thanks for Purchasing on Instakart";
												$headers = "MIME-Version: 1.0" . "\r\n";
												$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
												
												// More headers
												$headers .= 'From: Instakart' . "\r\n";
												$headers .= 'Cc: noreply@instakart.rf.gd' . "\r\n";
												$body = "<center>
<html>
<head>
<style>
td
{
	padding:5px;
}
</style>
</head>
<body style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0; padding: 0;' bgcolor='#f6f6f6'>

<table class='body-wrap' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;' bgcolor='#f6f6f6'><tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'><td style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;' valign='top'></td>
		<td class='container' width='600' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; width: 100% !important; margin: 0 auto; padding: 0;' valign='top'>
			<div class='content' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 0;'>
				<table class='main' width='100%' cellpadding='0' cellspacing='0' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;' bgcolor='#fff'><tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'><td class='alert alert-warning' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #FF9F00; margin: 0; padding: 20px;' align='center' bgcolor='#FF9F00' valign='top'>
							Thanks for purchasing on Instakart.
						</td>
					</tr><tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'><td class='content-wrap' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 10px;' valign='top'>
							<table width='100%' cellpadding='0' cellspacing='0' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'><tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'><td class='content-block' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;' valign='top'>
										Hello <strong style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>".$username."</strong><br><br><br>You have Ordered Account <a href='http://instakart.rf.gd/accounts.php?username=".$buying_username."'><strong style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>".$buying_username."</strong></a> for $".$price.".
									</td>
								</tr><tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'><td class='content-block' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;' valign='top'>
										You can track order stastics <a href='http://instakart.rf.gd/myorders'>here</a>
									</td>
								<tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'><td class='content-block' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;' valign='top'>
										Thanks for choosing Instakart.
									</td>
								</tr></table></td>
					</tr></table><div class='footer' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;'>
					<table width='100%' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'><tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'><td class='aligncenter content-block' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;' align='center' valign='top'><a href='http://instakart.rf.gd/explore' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;'>Explore</a> more on Instakart.</td>
						</tr></table></div></div>
		</td>
		<td style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;' valign='top'></td>
	</tr></table></body>
</html></center>";
												mail($to,$subject,$body,$headers);
												$randfilename = str_shuffle('abcdefghij1234567');
												if($file_type == 'image/jpeg')
												{
												$filename_uploaded = $randfilename.".jpg";
												}
												else if($file_type == 'video/mp4')
												{
												$filename_uploaded = $randfilename.".mp4";
												}
												$location = 'uploads/';
												move_uploaded_file($file_tmp_name,$location.$filename_uploaded);
												mysqli_query($conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
												$order_query = "INSERT INTO orders(ordered_account, buyer_id, seller_id, paid_amount, content, receipt_email, time, file_name, file_type, post_hours) VALUES('$buying_username',$buyer_id,$seller_id,$price,'$content','$email','$time','$randfilename','$file_type', $time_hours)";
												if($run_order_query = mysqli_query($conn, $order_query))
												{
													$_SESSION['order_success'] = true;
													header('Location: ordersuccess');
												}
											}
										}
									}
								}
								}
								//balance alter end
							}
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
								<li>Please select a valid File.</li>
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
								<li>Please choose a file to be uploaded.</li>
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
								<li>Something went wrong.</li>
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
								<li>All fields are required.</li>
							</ul>
							</div>
            <?php
		}
	}
	//form
	if((isset($_POST['buynow'])&&isset($_POST['username'])||$_SESSOIN['buying']=true))
	{
		if((!empty($_POST['username']))||isset($_SESSION['buy_user']))
		{
			if(isset($_POST['buynow']))
			{
			$username = addslashes(strip_tags($_POST['username']));
			$username = mysqli_real_escape_string($conn, $username);
			}
			else
			{
				$username = $_SESSION['buy_user'];
			}
			$get_username_query = "SELECT * FROM ig_accounts WHERE username = '$username' and confirmed = 1";
			$run_query = mysqli_query($conn, $get_username_query);
			$no_of_usernames = mysqli_num_rows($run_query);
			$rows = mysqli_fetch_assoc($run_query);
			if($no_of_usernames == 0)
			{
				echo "<h3> Invalid Username </h3>";
			die();
			}
			else
			{
				$_SESSION['buy_user'] = $username;
				?>
                <div class="panel panel-default panel-success">
                	<div class="panel-heading">Cart Summary</div>
                	<div class="panel-body">
                    	<table class="table">
                        	<thead> 
                            <?php 
							$followers = (followers($username))/10;
							$time = $rows['account_time'];
							$price = $rows['account_amount'];
							?>
                            <tr>
                            <th> Account / Followers / Duration </th>
                            <th> Price </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                            <td><img src="<?php echo profile_pic($username)?>" width="30" height="30" class="img-circle"><?php echo "@".$username." / ".(($followers)/1000)."k / ".$time." hr"; ?></td>
                            <td><?php echo "$".$price; ?></td>
                            </tr>
                            </tbody>  
                        </table>
                    </div>
                </div>
                <div class="panel panel-default ">
                	<div class="panel-heading">Shoutout Details</div>
                    <div class="panel-body order-form">
                    <?php 
					$uid = $_SESSION['uid'];
					$get_info = "SELECT * FROM registered_users WHERE uid = $uid";
					$run_get_query = mysqli_query($conn, $get_info);
					$info_rows = mysqli_fetch_assoc($run_get_query);
					?> 
                     	<form method="post" action="buy" enctype="multipart/form-data">
                         	<div class="form-group">
                            <label for="email">Email</label><br>
                            <p class="text-muted"><small>Purchase recepit will be sent to this email</small></p>
                            <input type="email" name="email" required class="form-control" placeholder="Email" value="<?php echo $info_rows['email']?>">
                            </div>
                            <div class="form-group">
                            <label for="content">Shoutout Content</label>
                            <p class="text-muted"><small>You can add content in plain text, and it will be posted exactly on the Account</small></p>
                            <p class="text-muted" style="color:#E00003"><small>The content will be posted as it is on the instagram account.</small></p>
                            <textarea name="content" maxlength="990" class="form-control" minlength="10"></textarea>
                            </div>
                            <div class="form-group">
                            <label for="file">Shoutout Image/Video</label>
                            <p class="text-muted"><small>Choose a Image or Video File, Limit size 10 MB Supported formats <span style="color:#CF0306">.jpeg, .mp4</span></small></p>
                            <input type="file" name="file">
                            </div>
                              <div class="form-group">
                              	<label for="comment">Preferred Shoutout Time</label>
                                <p class="text-muted"><small>Tell more about shoutout with preferred Shoutout Time</small></p>
                                <p class="text-muted"><small>Date Format <span style="color:#CF0306">YYYY/MM/DD</span> Time Format  <span style="color:#CF0306">HH:MM AM/PM</span></small></p>
                                <input type="text" name="time" class="form-control" placeholder="Date & Time" minlngth="15" maxlength="100">
                              </div>
                              <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
                              <div class="modal-footer">
									<button class="btn btn-success" name="submit_form">Submit</button>
							  </div>
                    	</form>
                    </div>
                </div>
                <?php
			}
		}
		else
		{
			echo "<h3> Something went wrong </h3>";
			die();
		}
	}
	else
	{
		echo "<h3> Something went wrong </h3>";
			die();
	}
?>

</div>
</div>
</body>
<?php
include 'footer.php';
}
else
{
	?>
<div class="container">
<div class="content" style="padding-top:8%;">
	<?php include 'navbar.php';
	echo "<h4> You must be logged in to continue with purchase,<br>Login <a href='login'>Here</a> OR Register <a href='register'>Here</a> </h4>";
	die();
	?>
    </div></div>
    <?php
}
?>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> 
</body>
</html>