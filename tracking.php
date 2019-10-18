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
if((isset($_POST['oid'])&&isset($_POST['view_stats']))||isset($_SESSION['my_oid']))
{
	if((!empty($_POST['oid']))||isset($_SESSION['my_oid']))
	{
		if(isset($_POST['oid']))
		{
		$oid = addslashes(strip_tags($_POST['oid']));
		$oid = mysqli_real_escape_string($conn, $oid);
		$_SESSION['my_oid'] = $oid;
		}
		else if(isset($_SESSION['my_oid']))
		{
			$oid = $_SESSION['my_oid'];
		}
		$select_query = "SELECT * FROM orders WHERE oid = $oid";
		$run_select_query = mysqli_query($conn, $select_query);
		$rows = mysqli_fetch_assoc($run_select_query);
		$track_status = $rows['track_status'];
		$content = $rows['content'];
		$time = $rows['total_time'];
		$ordered_account = $rows['ordered_account'];
		//get IG account info 
		$query = "SELECT account_time FROM ig_accounts WHERE username = '$ordered_account'";
		$run_query = mysqli_query($conn, $query);
		$account_rows = mysqli_fetch_assoc($run_query);
		$account_time = $account_rows['account_time'];
		$paid_amount = $rows['paid_amount'];
		$post_link = $rows['post_link'];
	}
	else
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
 if(isset($_SESSION['my_oid']))
 {
	 $oid = $_SESSION['my_oid'];
	 if(isset($_POST['cancel_shoutout']))
	 {
		$check_stat_query = "SELECT track_status FROM orders WHERE oid = $oid";
		$run_stat_query = mysqli_query($conn, $check_stat_query);
		$stat_row = mysqli_num_rows($run_stat_query);
		$status = $stat_row['track_status'];
		if($status != 0)
		{
		?>
        <div class="panel-body">
        <h3 style="padding:5px;" class="text-muted"> Something went wrong </h3>
        </div>
        <?php
            die();
		}
		else
		{
			$update_stats_query = "UPDATE orders SET track_status = 4 WHERE oid = $oid";
			mysqli_query($conn, $update_stats_query);
			$paid_amount = $rows['paid_amount'];
			$uid = $_SESSION['uid'];
			$get_my_balance = "SELECT balance FROM balance WHERE uid = $uid";
			$run_get_balance_query = mysqli_query($conn, $get_my_balance);
			$balance_row = mysqli_fetch_assoc($run_get_balance_query);
			$my_balance = $balance_row['balance'];
			$my_balance = $my_balance + $paid_amount;
			$update_mybalance_query = "UPDATE balance SET balance = $my_balance WHERE uid = $uid";
			mysqli_query($conn, $update_mybalance_query);
			$seller_id = $rows['seller_id'];
			$get_seller_balance = "SELECT pending_balance FROM balance WHERE uid = $seller_id";
			$run_get_seller_balance_query = mysqli_query($conn, $get_seller_balance);
			$seller_balance_row = mysqli_fetch_assoc($run_get_seller_balance_query);
			$seller_pending_balance = $seller_balance_row['pending_balance'];
			$seller_pending_balance = $seller_pending_balance - $paid_amount;
			$update_seller_pending_balance_query = "UPDATE balance SET pending_balance = $seller_pending_balance WHERE uid = $seller_id";
			mysqli_query($conn, $update_seller_pending_balance_query);
		}
	 }
//new
		if($track_status == 0)
	 {
		$likes = 0;
		$comments = 0;
	 }
	 else if($track_status == 1)
	 {
		$link = $rows['shoutout_link'];
		$ordered_account = $rows['ordered_account'];
		
		if(get_likes_by_link($link)==false)
		{
			$likes = 0;
			$comments = 0;
			$update_status_query = "UPDATE orders SET track_status = 0 WHERE oid = $oid";
			mysqli_query($conn, $update_stats_query);
		}
		else
		{
			$oid = $_SESSION['my_oid'];
			
			if(check_content_again($oid)==false)
			{
			$update_status_query = "UPDATE orders SET track_status = 0 WHERE oid = $oid";
			mysqli_query($conn, $update_stats_query);
			
			}
			else
			{
			$likes = get_likes_by_link($link);
			$comments = get_comments_by_link($link);
			}
		}
	 }
	 else if($track_status == 2)
	 {
		 $oid = $_SESSION['my_oid'];
		 $get_info_query = "SELECT * FROM orders WHERE oid = $oid";
		 $run_get_info_query = mysqli_query($conn, $get_info_query);
		 $info_rows = mysqli_fetch_assoc($run_get_info_query);
		 $likes = $info_rows['likes_received'];
		 $comments = $info_rows['comments_received'];
	 }

//end new
		}
 ?>
 <?php
$oid = $_SESSION['my_oid'];
$new_check_stat_query = "SELECT track_status FROM orders WHERE oid = $oid";
$new_run_stat_query = mysqli_query($conn, $new_check_stat_query);
$new_stat_row = mysqli_fetch_assoc($new_run_stat_query);
$track_status = $new_stat_row['track_status'];
 ?>
 <h4> You have ordered <a href="accounts.php?username=<?php echo $ordered_account;?>">@<?php echo $ordered_account ?></a> for $<?php echo $paid_amount; ?> </h4>

             <div class="panel-body"> 
             	<div class="bg-success col-xs-8">
                	<div class="col-xs-12 col-sm-6 text-center">
                    <h1><span class="glyphicon glyphicon-heart"></span>
                    <?php
					if($track_status == 0 || $track_status == 1 )
					{
						echo $likes;
					}
					else if($track_status == 2)
					{
						echo $likes;
					}
					else
					{
						echo "0";
					}
					?>
                    </h1>
                    <p class="text-muted">Likes</p>
                	</div>
                	<div class="col-xs-12 col-sm-6 text-center">
                     <h1><span class="glyphicon glyphicon-comment"></span>
                     <?php
                     if($track_status == 1)
					{
						echo $comments;
					}
					else if($track_status == 2)
					{
						echo $comments;
					}
					else
					{
						echo "0";
					}
					?> </h1>
                    <p class="text-muted">Comments</p>
                	</div>
                </div>
                </div>
                <div class="panel-body">
                <div class="bg-info col-xs-8">
                	<h4 style="padding:5px;" class="text-muted">
                    <?php
                    if($track_status == 0)
					{
						echo "Your shoutout is not yet posted on the Account.";
					}
					else if($track_status == 1)
					{
						echo "Your shoutout is live on the account <a href=\"http://instagram.com/p/".$link."\" style = 'text-decoration:underline;'>View Post</a>";
					}
					else if($track_status == 2)
					{
						echo "Your shoutout was posted on the preferred account !";
					}
					else if($track_status == 3)
					{
						echo "Seller canceled the Shoutout, you got your refund !";
					}
					else if($track_status == 4)
					{
						echo "You canceled the shouout !";
					}
					?>
                     </h4>
                </div>
                </div>
                <?php 
				if($track_status == 0)
				{?>
                <div class="panel-body">
                <form method="post" action="tracking">
                <button class="btn btn-success" name="cancel_shoutout">Cancel Shoutout</button>
                </form>
                </div>
                <?php
				}
				?>
</div>     
</div>


</div>
</div>
<?php
include 'footer.php';
}
else
{
	header('Location: index');
}
?>