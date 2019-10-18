<?php
@session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Shoutout Order Summary</title>
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
<?php
if((isset($_POST['view'])&&isset($_POST['oid']))||isset($_SESSION['oid']))
{
   if((!empty($_POST['oid']))||!empty($_SESSION['oid']))
   {	
	   if(isset($_POST['oid']))
	   {
	   $oid = addslashes(strip_tags($_POST['oid']));
	   $oid = mysqli_real_escape_string($conn, $oid);   
	   $_SESSION['oid'] = $oid;
	   }
	   else if(isset($_SESSION['oid']))
	   {
		   $oid = $_SESSION['oid'];
	   }
       $uid = $_SESSION['uid'];
	   $check_order_query = "SELECT * FROM orders WHERE seller_id = $uid AND oid = $oid";
	   $run_check_order = mysqli_query($conn, $check_order_query);
	   $num_of_rows = mysqli_num_rows($run_check_order);
	   if($num_of_rows == 0)
	   {
		?>
            <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-danger" role="alert" width="200" height="60">
            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                <span aria-hidden="true">x</span>
            </button>
            <ul>
                <li>Invalid Order id.</li>
            </ul>
            </div>
            </div>
        <?php  
		die(); 
	   }   
	   else if($num_of_rows >= 1)
	   {
		   $fetch_rows = mysqli_fetch_assoc($run_check_order);
		   $content = $fetch_rows['content'];
		   $ordered_account = $fetch_rows['ordered_account'];
		   $buyer_id = $fetch_rows['buyer_id'];
		   $time = $fetch_rows['time'];
		   $file_type = $fetch_rows['file_type'];
		   $file_name = $fetch_rows['file_name'];
		   $get_buyer_username = "SELECT username FROM registered_users WHERE uid = $buyer_id";
		   $run_buyer_query = mysqli_query($conn, $get_buyer_username);
		   $buyer_row = mysqli_fetch_assoc($run_buyer_query);
		   $buyer_name = $buyer_row['username'];
		   if($file_type == 'video/mp4')
		   {
			   $file_ext = "mp4";
		   }
		   else if($file_type == 'image/jpeg')
		   {
			   $file_ext = "jpg";
		   }
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
else
{
	?>
<div class="panel-body">
<h3 style="padding:5px;" class="text-muted"> Something went wrong </h3>
</div>
<?php
	die();
}
?>
<?php
$oid = $_SESSION['oid'];
$order_query = "SELECT * FROM orders WHERE seller_id = $uid AND oid = $oid";
$run_order_query = mysqli_query($conn, $order_query);
$order_query_row = mysqli_fetch_assoc($run_order_query);
$track_status = $order_query_row['track_status'];
if(isset($_POST['start_tracking'])&&isset($_POST['token']))
{	
	if(!empty($_POST['token']))
	{
		$tokenr = addslashes(strip_tags($_POST['token']));
		$tokenr = mysqli_real_escape_string($conn, $tokenr);
		if($tokenr == $_SESSION['token'])
		{
		$oid = $_SESSION['oid'];
		$check_stats_query = "SELECT track_status FROM orders WHERE seller_id = $uid AND oid = $oid";		
		$run_status_check_query = mysqli_query($conn, $check_stats_query);
		$status_rows = mysqli_fetch_assoc($run_status_check_query);
		$track_status = $status_rows['track_status'];
		if($track_status != 0)
		{
			?>
				<div class="col-md-8 col-md-offset-2">
				<div class="alert alert-danger" role="alert" width="200" height="60">
				<button class="close" aria-label="Close" data-dismiss="alert" type="button">
					<span aria-hidden="true">x</span>
				</button>
				<ul>
					<li>Something went Wrong.</li>
				</ul>
				</div>
				</div>
			<?php
		}
		else if($track_status == 0)
		{
			if(latest_post_array_links($oid) == true)
			{
			$start_time = time();
			$oid = $_SESSION['oid'];
			$update_query = "UPDATE orders SET start_time = $start_time, track_status = 1 WHERE oid = $oid";
			mysqli_query($conn, $update_query);
			}
			else
			{
				?>
				<div class="col-md-8 col-md-offset-2" style="clear:both;">
				<div class="alert alert-danger" role="alert" width="200" height="60">
				<button class="close" aria-label="Close" data-dismiss="alert" type="button">
					<span aria-hidden="true">x</span>
				</button>
				<ul>
					<li>Please post the shoutout content on your account !</li>
				</ul>
				</div>
				</div>
				<?php
			}
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
else if(isset($_POST['mark_complete'])&&isset($_POST['token']))
{
		if(!empty($_POST['token']))
		{
			$tokenr = addslashes(strip_tags($_POST['token']));
			$tokenr = mysqli_real_escape_string($conn, $tokenr);
			if($tokenr == $_SESSION['token'])
			{
			$oid = $_SESSION['oid'];
			$check_stats_query = "SELECT track_status FROM orders WHERE seller_id = $uid AND oid = $oid";		
			$run_status_check_query = mysqli_query($conn, $check_stats_query);
			$status_rows = mysqli_fetch_assoc($run_status_check_query);
			$track_status = $status_rows['track_status'];
			if($track_status != 1)
			{
				?>
					<div class="col-md-8 col-md-offset-2" style="clear:both;">
					<div class="alert alert-danger" role="alert" width="200" height="60">
					<button class="close" aria-label="Close" data-dismiss="alert" type="button">
						<span aria-hidden="true">x</span>
					</button>
					<ul>
						<li>Something went Wrong.</li>
					</ul>
					</div>
					</div>
				<?php
			}
			else if($track_status == 1)
			{
				$oid = $_SESSION['oid'];
				$get_starttime_query = "SELECT start_time, shoutout_link FROM orders WHERE oid = $oid";
				$run_get_info_query = mysqli_query($conn, $get_starttime_query);
				$info_rows = mysqli_fetch_assoc($run_get_info_query);
				$start_time = $info_rows['start_time'];
			    $post_link =  $info_rows['shoutout_link'];
				if(get_likes_by_link($post_link) == false)
				{
					$reset_query = "UPDATE orders SET track_status = 0, shoutout_link = '', start_time = 0 WHERE oid = $oid";
					mysqli_query($conn, $reset_query);
					?>
                    <div class="col-md-8 col-md-offset-2" style="clear:both;">
					<div class="alert alert-danger" role="alert" width="200" height="60">
					<button class="close" aria-label="Close" data-dismiss="alert" type="button">
						<span aria-hidden="true">x</span>
					</button>
					<ul>
						<li>Shoutout was deleted from the Instagram Account, you will need to post shoutout again.<br>Note: You can only delete the shoutout after you mark order as complete.</li>
					</ul>
					</div>
					</div>
                    <?php
				}
				else
				{
					if(check_content_again($oid)==false)
					{
						$reset_query = "UPDATE orders SET track_status = 0, shoutout_link = '', start_time = 0 WHERE oid = $oid";
						mysqli_query($conn, $reset_query);
						?>
                        <div class="col-md-8 col-md-offset-2" style="clear:both;">
					<div class="alert alert-danger" role="alert" width="200" height="60">
					<button class="close" aria-label="Close" data-dismiss="alert" type="button">
						<span aria-hidden="true">x</span>
					</button>
					<ul>
						<li>We found that the contents in the Shoutout was changed, you will need to post shoutout again.</li>
					</ul>
					</div>
					</div>
                        <?php
					}
					else
					{
					$time_now = time();
					$oid = $_SESSION['oid'];
					$get_hours_query = "SELECT post_hours from orders WHERE oid = $oid";
					$run_hours_query = mysqli_query($conn, $get_hours_query);
					$hour_rows = mysqli_fetch_assoc($run_hours_query);
					$hours = $hour_rows['post_hours'];
					$total_req_secs = ($hours*60*60);
					$total_req_secs = ceil($total_req_secs);
					$total_likes_received = get_likes_by_link($post_link);
				    $total_comments_received = get_comments_by_link($post_link);
					$total_time = $time_now - $start_time;
					if($total_time < $total_req_secs)
					{
						$more_needed = $total_req_secs - $total_time;
						$more_min = $more_needed/60;
						$more_min = ceil($more_min);
						?>
                         <div class="col-md-8 col-md-offset-2" style="clear:both;">
					<div class="alert alert-danger" role="alert" width="200" height="60">
					<button class="close" aria-label="Close" data-dismiss="alert" type="button">
						<span aria-hidden="true">x</span>
					</button>
					<ul>
						<li>You need to wait for more <?php echo $more_min; ?> minutes before you delete Shoutout.</li>
					</ul>
					</div>
					</div>
                        <?php
						
					}
					else
						{
						$oid = $_SESSION['oid'];
						$time_now = time();
						$get_paid_amount_query = "SELECT ordered_account, paid_amount, seller_id FROM orders WHERE oid = $oid";
						$run_get_paid_amount_query = mysqli_query($conn, $get_paid_amount_query);
						$paid_row = mysqli_fetch_assoc($run_get_paid_amount_query);
						$paid_amount = $paid_row['paid_amount'];
						$seller_id = $paid_row['seller_id'];
						$ordered_account = $paid_row['ordered_account'];
						$get_seller_balance = "SELECT balance, pending_balance, earned FROM balance WHERE uid = $seller_id";
						$run_seller_balance_query = mysqli_query($conn, $get_seller_balance);
						$row_balance = mysqli_fetch_assoc($run_seller_balance_query);
						$seller_balance = $row_balance['balance'];
						$seller_pending_balance = $row_balance['pending_balance'];
						$total_earned = $row_balance['earned'];
						$total_earned = $total_earned + $paid_amount;
						$new_balance = $paid_amount + $seller_balance;
						$new_pending_balance = $seller_pending_balance - $paid_amount;
						$get_sc = "SELECT score FROM ig_accounts WHERE username = '$ordered_account'";
						$run_sc = mysqli_query($conn, $get_sc);
						$row_sc = mysqli_fetch_assoc($run_sc);
						$score = $row_sc['score'];
						$score = (($total_likes_received+$total_comments_received)/1/10)+$score;
						$update_sc_query = "UPDATE ig_accounts SET score = $score WHERE username = '$ordered_account'";
						mysqli_query($conn, $update_sc_query);
						$update_user_balance = "UPDATE balance set balance = $new_balance, pending_balance = $new_pending_balance, earned = $total_earned WHERE uid = $seller_id";
						mysqli_query($conn, $update_user_balance);
						$update_query = "UPDATE orders SET likes_received = $total_likes_received, comments_received = $total_comments_received, total_time = $total_time, track_status = 2, end_time = $time_now WHERE oid = $oid";
						mysqli_query($conn, $update_query);
						}
					}
				}
			}
		}
		else
		{
				?>
				<div class="panel-body">
				<h3 style="padding:5px;" class="text-muted"> Something went wrong</h3>
				</div>
				<?php
					die();
		}
		
	}		
	else
	{
			?>
			<div class="panel-body">
			<h3 style="padding:5px;" class="text-muted"> Something went wrong</h3>
			</div>
			<?php
				die();
	}
}	
else if(isset($_POST['cancel_shoutout'])&&isset($_POST['token']))
{
		if(!empty($_POST['token']))
		{
			$tokenr = addslashes(strip_tags($_POST['token']));
			$tokenr = mysqli_real_escape_string($conn, $tokenr);
			if($tokenr == $_SESSION['token'])
			{
			$oid = $_SESSION['oid'];
			$check_stats_query = "SELECT track_status FROM orders WHERE seller_id = $uid AND oid = $oid";		
			$run_status_check_query = mysqli_query($conn, $check_stats_query);
			$status_rows = mysqli_fetch_assoc($run_status_check_query);
			$track_status = $status_rows['track_status'];
			if($track_status != 0 && $track_status != 1)
			{
				?>
					<div class="col-md-8 col-md-offset-2" style="clear:both;">
					<div class="alert alert-danger" role="alert" width="200" height="60">
					<button class="close" aria-label="Close" data-dismiss="alert" type="button">
						<span aria-hidden="true">x</span>
					</button>
					<ul>
						<li>Something went Wrong.</li>
					</ul>
					</div>
					</div>
				<?php
			}
			else
			{
				$update_status_query = "UPDATE orders SET track_status = 3 WHERE oid = $oid";
				mysqli_query($conn, $update_status_query);
				$select_paid_amount = "SELECT paid_amount, buyer_id FROM orders WHERE oid = $oid";
				$run_paid_amount_query = mysqli_query($conn, $select_paid_amount);
				$paid_amount_rows = mysqli_fetch_assoc($run_paid_amount_query);
				$paid_amount = $paid_amount_rows['paid_amount'];
				$buyer_id = $paid_amount_rows['buyer_id'];
				$get_buyer_balance_query = "SELECT balance FROM balance WHERE uid = $buyer_id";
				$run_get_balance_query = mysqli_query($conn, $get_buyer_balance_query);
				$balance_rows = mysqli_fetch_assoc($run_get_balance_query);
				$buyer_balance = $balance_rows['balance'];
				$buyer_balance = $buyer_balance + $paid_amount;
				$refund_query = "UPDATE balance SET balance = $buyer_balance WHERE uid = $buyer_id";
				mysqli_query($conn, $refund_query);
				$seller_id = $_SESSION['uid'];
				$get_pending_balance = "SELECT pending_balance FROM balance WHERE uid = $seller_id";
				$run_get_balance_query = mysqli_query($conn, $get_pending_balance);
				$pending_balance_row = mysqli_fetch_assoc($run_get_balance_query);
				$pending_balance = $pending_balance_row['pending_balance'];
				$new_pending_balance = $pending_balance - $paid_amount;
				$update_pending_query = "UPDATE balance SET pending_balance = $new_pending_balance WHERE uid = $seller_id";
				mysqli_query($conn, $update_pending_query);
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
else if($track_status == 1)
			{
				$oid = $_SESSION['oid'];
				$get_starttime_query = "SELECT start_time, shoutout_link FROM orders WHERE oid = $oid";
				$run_get_info_query = mysqli_query($conn, $get_starttime_query);
				$info_rows = mysqli_fetch_assoc($run_get_info_query);
				$start_time = $info_rows['start_time'];
				$post_link =  $info_rows['shoutout_link'];
				if(get_likes_by_link($post_link) == false)
				{
					$reset_query = "UPDATE orders SET track_status = 0, shoutout_link = '', start_time = 0 WHERE oid = $oid";
					mysqli_query($conn, $reset_query);
					?>
                    <div class="col-md-8 col-md-offset-2" style="clear:both;">
					<div class="alert alert-danger" role="alert" width="200" height="60">
					<button class="close" aria-label="Close" data-dismiss="alert" type="button">
						<span aria-hidden="true">x</span>
					</button>
					<ul>
						<li>Shoutout was deleted from the Instagram Account, you need to post shoutout again.<br>Note: You can only delete the shoutout after you mark order as complete.</li>
					</ul>
					</div>
					</div>
                    <?php
				}
				else
				{
					if(check_content_again($oid)==false)
					{
						$reset_query = "UPDATE orders SET track_status = 0, shoutout_link = '', start_time = 0 WHERE oid = $oid";
						mysqli_query($conn, $reset_query);
						?>
                        <div class="col-md-8 col-md-offset-2" style="clear:both;">
					<div class="alert alert-danger" role="alert" width="200" height="60">
					<button class="close" aria-label="Close" data-dismiss="alert" type="button">
						<span aria-hidden="true">x</span>
					</button>
					<ul>
						<li>We found that the contents in the Shoutout was changed, you need to post shoutout again.</li>
					</ul>
					</div>
					</div>
                        <?php
					}
					else
					{
					$time_now = time();
					$oid = $_SESSION['oid'];
					$get_hours_query = "SELECT account_time from ig_accounts WHERE username = '$ordered_account'";
					$run_hours_query = mysqli_query($conn, $get_hours_query);
					$hour_rows = mysqli_fetch_assoc($run_hours_query);
					$hours = $hour_rows['account_time'];
					$total_req_secs = ($hours/60/60);
					$total_likes_received = get_likes_by_link($post_link);
				    $total_comments_received = get_comments_by_link($post_link);
					$total_time = $time_now - $start_time;
					$update_query = "UPDATE orders SET likes_received = $total_likes_received, comments_received = $total_comments_received, total_time = $total_time WHERE oid = $oid";
					mysqli_query($conn, $update_query);
					}
				}
				
			}		
?>
<h3 style="clear:both;">Order Summary.</h3>
<?php
$oid = $_SESSION['oid'];
$order_query = "SELECT * FROM orders WHERE seller_id = $uid AND oid = $oid";
$run_order_query = mysqli_query($conn, $order_query);
$order_query_row = mysqli_fetch_assoc($run_order_query);
?>
        	<div class="panel panel-success">
            	<div class="panel-heading">Shoutout Content</div>
                	<div class="panel-body">
                    <form method="post" action="orders">
                    <p class="text-muted"><small>Note: You must post the text as it is.</small></p>
                        <textarea name="content" maxlength="990" class="form-control" minlength="10"><?php echo $content; ?></textarea>
                        </br>
                      <p class="text-muted"><small>Media: </small></p>
                      <a href="uploads/<?php echo $file_name.".".$file_ext; ?>"><?php echo $file_name.".".$file_ext; ?></a>
                      </br></br>
                      <p class="text-muted"><small>Shoutout time: </small></p>
                      <p><?php echo $time ?></p>
                      <?php
					  if($order_query_row['track_status']==0)
					  {
					  ?>
                      <p class="text-muted" style="color:#FF0004"><small>Note: Shoutout must posted on account before you Start tracking.</small></p>
                      <button class="btn btn-danger" name="cancel_shoutout">Cancel Shoutout</button>&nbsp;&nbsp;
                      <button class="btn btn-success" name="start_tracking">Start tracking</button>
                      <?php
					  }
					  if($order_query_row['track_status']==1)
					  {
					  ?>
                      <p class="text-muted" style="color:#FF0004"><small>Note: Shoutout should not be deleted from Instagram account before you 'Mark Complete'.</small></p>
                      <button class="btn btn-danger" name="cancel_shoutout">Cancel Shoutout</button>&nbsp;&nbsp;
                      <button class="btn btn-warning" name="mark_complete">Mark Complete</button>
                      <?php
					  }
					  else if($order_query_row['track_status']==2)
					  {
						  ?>
                          <p class="text-muted">Order Completed !</p>
                          <?php
					  }
					  else if($order_query_row['track_status']==3)
					  {
						  ?>
                          <p class="text-muted">You have canceled the order.</p>
                          <?php
					  }
					  else if($order_query_row['track_status'] == 4)
					  {
						?>
                          <p class="text-muted">Buyer has canceled the order.</p>
                         <?php  
					  }
					  ?>  
                      <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
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