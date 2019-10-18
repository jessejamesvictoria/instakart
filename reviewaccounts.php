<?php
@session_start();
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
include 'instagram.php';
if(isset($_SESSION['admin_id']))
{
	include 'adminheader.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> <?php
$display_username = addslashes(strip_tags($_GET['username']));
$display_username = mysqli_real_escape_string($conn, $display_username);
$check_display_username_query = "SELECT * FROM ig_accounts WHERE username = '$display_username' AND confirmed=0";
$run_check_query = mysqli_query($conn, $check_display_username_query);
$no_of_rows = mysqli_num_rows($run_check_query);
if($no_of_rows == 0)
{
	echo "Invalid Username";
}
else
{
	echo "Review Account ".$display_username;
}
?> </title>
</head>
<style>
body
{
padding-top:40px;
}
.content
{
	padding-top:7%;
}
.shoutout-info
{
padding:1em;
border-radius:6px;
letter-spacing:-.5px;	
}
#desc
{
	margin-top:20px;
}
</style>
<body>
<div class="container">
     <div class="content">
     <?php 
	 if($no_of_rows==0)
	 {
		echo "<h3> Invalid Username Specified </h3>"; 
	 }
	 else
	 {
	 ?>
     	<div class="col-sm-8">
        	<div class="col-xs-12 bg-info shoutout-info">
            	<div class="col-sm-5 col-md-5 col-lg-4">
                <img src="<?php echo profile_pic($display_username);?>" class="img-circle img-responsive" >
                </div>
                <div class="col-sm-7 col-md-7 col-lg-8">
                	<div class="pull-left">
                     <h2> <?php echo $display_username; ?> </h2>
                     <p> Followers : <?php $followers = followers($display_username); $followers = ($followers/1000); echo $followers."k";?></p>
                    </div>
                </div>
            </div>
            <div class="clearfix">
            
            </div>
            <div class="panel panel-default" id="desc">
            	<div class="panel-heading">Description</div>
                <div class="panel-body"><?php 
				$get_info_query = "SELECT account_description,account_amount, account_time FROM ig_accounts WHERE username = '$display_username'";
				$run_info_query = mysqli_query($conn, $get_info_query);
				$fetch_info_rows = mysqli_fetch_assoc($run_info_query);
				$description = $fetch_info_rows['account_description'];
				echo $description;
				
				?></div>
            </div>
            <form>
            <input type="hidden">
            <div class="panel panel-success">
            <div class="panel-heading">Pricing</div>
            <div class="panel-body">
            <?php 
			$amount = $fetch_info_rows['account_amount'];
			$time = $fetch_info_rows['account_time'];
			echo $time." hours for $".$amount;
			?>
            </br></br>
            <button class="btn btn-success" name="buynow">Buy Now</button>
            </div>
            </div>
            </form>
        </div>
        <div class="col-sm-4">
        	<div class="panel panel-info">
            	<div class="panel-heading">Recent Media</div>
                <div class="panel-body">
						<?php echo latest_post_six($display_username); ?>
                </div>
            </div>
            <div class="panel panel-default">
            	<div class="panel-heading">Author</div>
                <div class="panel-body">
                 <h4><?php  
				 $select_uid_query = "SELECT uid FROM ig_accounts WHERE username = '$display_username'";
				 $run_uid_query = mysqli_query($conn, $select_uid_query);
				 $uid_row = mysqli_fetch_assoc($run_uid_query);
				 $uid = $uid_row['uid'];
				 $user_from_id_query = "SELECT username FROM registered_users WHERE uid = $uid ";
				 $run_u_t_us = mysqli_query($conn, $user_from_id_query);
				 $result_username_row = mysqli_fetch_assoc($run_u_t_us);
				 $result_username = $result_username_row['username'];
				 echo $result_username;
				 ?></h4>
                 <p>Member since : <?php
				 $get_time_query = "SELECT join_date, last_login FROM registered_users WHERE uid = $uid ";
				 $run_get_time_query = mysqli_query($conn, $get_time_query);
				 $time_rows = mysqli_fetch_assoc($run_get_time_query);
				 $join_date = $time_rows['join_date'];
				 echo $join_date;
				  ?></p>
                  <p>Last Login : <?php
				  $last_login = $time_rows['last_login'];
				  $todays_time = time();
				  $todays_date = date('Y-m-d',$todays_time);
				 if($todays_date == $last_login)
				  {
					  echo "Today";
				  }
				  else
				  {
					  echo $last_login;
				  }
				  ?></p>
                </div>
            </div>
        </div>
<?php
	 }
	 include 'footer.php';
	 ?>
</div>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
<?php
}
else
{
	header('Location: index');
}
?>