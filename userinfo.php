<?php
@session_start();
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
if(isset($_SESSION['admin_id']))
{
include 'adminheader.php';
?>
<html>
<head>
<meta charset="UTF-8">
<title>User Info</title>
</head>
<style>
body
{
padding-top:55px;
}
</style>
<body>
<div class="container">
<div class="content">
<?php
if(isset($_GET['username']))
{
	$username = addslashes(strip_tags($_GET['username']));
	$username = mysqli_real_escape_string($conn, $username);
	$g_u = "SELECT * FROM registered_users WHERE username = '$username'";
	$r_u = mysqli_query($conn, $g_u);
	$rows = mysqli_num_rows($r_u);
	if($rows == 0)
	{
		?>
<div class="panel-body">
<h3 style="padding:5px;" class="text-muted">Invalid Username.</h3>
</div>
<?php
	die();
	}
	else if($rows >= 1)
	{
		$found = true;
	}
}
else
{
	?>
<div class="panel-body">
<h3 style="padding:5px;" class="text-muted">Username not specified.</h3>
</div>
<?php
	die();
}
?>
<?php 
if($found == true)
{
	$get_uid = "SELECT uid, email FROM registered_users WHERE username = '$username'";
	$run_uid = mysqli_query($conn, $get_uid);
	$uid_row = mysqli_fetch_assoc($run_uid);
	$uid = $uid_row['uid'];
	$email = $uid_row['email'];
?>
<div class="panel-header">
    <div class="content" style="padding-top:40px;">
        <div class="col-sm-8">
        	<div class="col-xs-12 bg-info">
            <nobr><h4><span class="glyphicon glyphicon-user"></span>
            <?php echo $username; ?> ~ <span class="text-muted"><small><?php echo $email; ?></small></span></h4>
            </div>
            <div style="padding-top:20px;" class="col-xs-12 col-sm-6 text-center">
            <h1><span class="glyphicon glyphicon-usd"></span>
            <?php 
			$bal_q = "SELECT balance, earned FROM balance WHERE uid = $uid";
			$run_bal_q = mysqli_query($conn, $bal_q);
			$row_bal = mysqli_fetch_assoc($run_bal_q);
			$balance = $row_bal['balance'];
			$earned = $row_bal['earned'];
			echo $balance;
			?>
            </h1>
            <small class="text-muted">Total Balance | $<?php echo $earned; ?> Earned</small>
            </div>
            <div style="padding-top:20px;" class="col-xs-12 col-sm-6 text-center">
            <h1><span class="glyphicon glyphicon-picture"></span>
            <?php 
			$s_query = "SELECT * FROM orders WHERE seller_id = $uid AND track_status = 2";
			$r_s_query = mysqli_query($conn, $s_query);
			$s_row = mysqli_num_rows($r_s_query);
			if($s_row==0)
			{
				echo "0";
			}
			else
			{
				echo $s_row;
			}
			
			?>
            </h1>
            <small class="text-muted">Total Shoutouts sold</small>
            </div>
            <div class="col-xs-12 bg-success" style="margin-top:20px;">
            <h5><span class="glyphicon glyphicon-camera"></span>
           Instagram Accounts</h5>
            </div>
             <table class="table">
        <thead>
                 <tr>
                 <th> Account </th>
                 <th> Followers </th>
                 <th> Price </th>
                 </tr>
         </thead>
         <tbody>
         <?php 
		$s_q = "SELECT * FROM ig_accounts WHERE uid = $uid";
		$r_q = mysqli_query($conn, $s_q);
		while($row_q = mysqli_fetch_assoc($r_q))
		{
		?>
         <tr> 
         <td><img src="<?php echo $row_q['profile_pic']; ?>" width="30" height="30" class="img-circle"><a href="accounts.php?username=<?php echo $row_q['username']; ?>">@<?php echo $row_q['username']; ?></a></td>
         <td><?php echo ($row_q['followers'])/1000;?>k</td>
         <td>$<?php echo $row_q['account_amount'];?></td>
         </tr>
         <?php
		}
		?>
         </tbody>
        </table>
        </div>   
    </div>
 </div>
 
<?php
}
?>
</div>
</div>
</body>
</html>
<?php
include 'footer.php';
}
else
{
	header('Location: index.php');
}
?>