<?php
@session_start();
include 'head.php';
@include 'sqlconnect.php';
include 'core.inc.php';
if(isset($_SESSION['admin_id']))
{
include 'adminheader.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Payments </title>
</head>
<style>
.message-dis
{
	padding-top:40px;
}
</style>
<body>
<div class="container">
<div class="page-header">
<div class="message-dis">
<?php
if(isset($_POST['mark'])&&isset($_POST['pid'])&&isset($_POST['bal']))
{
	if(!empty($_POST['pid']))
	{
		$pid = addslashes(strip_tags($_POST['pid']));
		$pid = mysqli_real_escape_string($conn, $pid);
		$bal = addslashes(strip_tags($_POST['bal']));
		$bal = mysqli_real_escape_string($conn, $bal);
		$comission = ($bal/9);
		$check_query = "SELECT * FROM payments WHERE pid = $pid AND status = 0";
		$run_check_query = mysqli_query($conn, $check_query);
		$num_rows = mysqli_num_rows($run_check_query);
		if($num_rows == 0)
		{
			?>
            <div class="panel-body">
            <h3 style="padding:5px;" class="text-muted"> Something went wrong</h3>
            </div>
            <?php
            die();
		}
		else
		{
			$time_now = time();
			$p_rows = mysqli_fetch_assoc($run_check_query);
			$uid = $p_rows['uid'];
			$update_query = "UPDATE payments SET status = 1, time = $time_now, amount = $bal WHERE pid = $pid";
			$delete_query = "UPDATE balance SET balance = 0 WHERE uid = $uid";
			if((mysqli_query($conn, $update_query))&&mysqli_query($conn, $delete_query))
			{	
			?>
				<div class="alert alert-success" role="alert" width="200" height="60">
                <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">x</span>
                </button>
                <ul>
                    <li>Payment marked as complete</li>
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
                    <li>Something went wrong 3</li>
                </ul>
                </div>
				<?php
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
                    <li><p class="text-muted">Something went wrong</p></li>
                </ul>
                </div>
                <?php
	}
}
else if(isset($_POST['delete'])&&isset($_POST['pid']))
{
	if(!empty($_POST['pid']))
	{
		$pid = addslashes(strip_tags($_POST['pid']));
		$pid = mysqli_real_escape_string($conn, $pid);
		$check_query = "SELECT * FROM payments WHERE pid = $pid AND status = 0";
		$run_check_query = mysqli_query($conn, $check_query);
		$num_rows = mysqli_num_rows($run_check_query);
		if($num_rows == 0)
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
			$time_now = time();
			$delete_query = "DELETE FROM payments WHERE pid = $pid";
			if(mysqli_query($conn, $delete_query))
			{	
			?>
				<div class="alert alert-success" role="alert" width="200" height="60">
                <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">x</span>
                </button>
                <ul>
                    <li>Request deleted successfully.</li>
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
                    <li>Something went wrong</li>
                </ul>
                </div>
				<?php
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
                    <li><p class="text-muted">Something went wrong</p></li>
                </ul>
                </div>
                <?php
	}
}
?>
</div>
<h3 style="padding-top:10px;"> Pending Orders </h3>
</div>
	<div class="content">
    	<div class="panel panel-default">
        	<table class="table table-hover">
            <thead>
                     <tr>
                     <th> Account ~ Balance</th>
                     <th> Email </th>
                     <th colspan="2"> Action </th> 
                     </tr>
                     </thead>
            	<tbody>
                <?php
				$select_query = "SELECT * FROM payments WHERE status = 0";
				$run_select_query = mysqli_query($conn, $select_query);
				while($rows = mysqli_fetch_assoc($run_select_query))
				{
					$uid = $rows['uid'];
					$get_username_query = "SELECT username from registered_users WHERE uid = $uid";
					$run_username_query = mysqli_query($conn, $get_username_query);
					$username_rows = mysqli_fetch_assoc($run_username_query);
					$username = $username_rows['username'];
					$get_b = "SELECT balance FROM balance WHERE uid = $uid";
					$run_b = mysqli_query($conn, $get_b);
					$row_b = mysqli_fetch_assoc($run_b);
					$my_balance = $row_b['balance'];
					$comission = ($my_balance/10);
					$my_balance = $my_balance - $comission;
					?>
                    <tr>
                    <td><div style="padding:12px;"><span class="glyphicon glyphicon-bullhorn"></span>&nbsp;&nbsp;<a href="userinfo.php?username=<?php echo $username; ?>"><?php echo $username; ?></a> ~ <span style="color:green;">$<?php echo $my_balance ;?></span></div></td>
                    <td><div style="padding:12px;"><img src="uploads/pp.png" width="17" height="22">&nbsp;<?php echo $rows['pp_email']; ?></div></td>
                    <form method="post" action="payments">
                     <td><div style="padding-top:5px;"><button class="btn btn-success" name="mark">Mark Paid</button></div> </td>
					<td><div style="padding-top:5px;"><button class="btn btn-warning" name="delete">Delete Request</button></div></td>
                    <input type="hidden" name="bal" value="<?php echo $my_balance; ?>">
                     <input type="hidden" name="pid" value="<?php echo $rows['pid']; ?>">
                    </form>
                    
                    </tr>
                    <?php
				}
				?>
                </tbody>
            </table>
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
	header('Location: index.php');
}
?>