<?php
@session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title> Pending Orders </title>
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
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
?>
<body>
<div class="container">
<div class="page-header">
<h3 style="padding-top:50px;"> Pending Orders </h3>
</div>
	<div class="content">
    	<div class="panel panel-default">
    	<table class="table table-hover">
        	<tbody>
            <?php
			$uid = $_SESSION['uid'];
			$select_query = "SELECT * FROM orders WHERE seller_id = $uid ORDER BY oid DESC";
			$run_select_query = mysqli_query($conn, $select_query);
			while($rows = mysqli_fetch_assoc($run_select_query))
			{
				$buyer_id = $rows['buyer_id'];
				$get_buyer_username_query = "SELECT username FROM registered_users WHERE uid = $buyer_id";
				$run_buyer_username_query = mysqli_query($conn, $get_buyer_username_query);
				$buyer_row = mysqli_fetch_assoc($run_buyer_username_query);
				$buyer_username = $buyer_row['username'];
				$ordered_account = $rows['ordered_account'];
			?>
            <tr><td><div style="padding:15px;">    
             <?php 
			if($rows['track_status']==0 || $rows['track_status']==1)
			{
			?>
            <span class="glyphicon glyphicon-bullhorn"></span>
            <?php
			}
			else if($rows['track_status']==2)
			{
			?>
            <span class="glyphicon glyphicon-ok"></span>
            <?php
			}
			else if($rows['track_status']==3)
			{
				?>
           <span class="glyphicon glyphicon-remove"></span>
                <?php
			}
			else if($rows['track_status']==4)
			{
				?>
           <span class="glyphicon glyphicon-remove"></span>
                <?php
			}
			?>
            
            &nbsp;&nbsp;<?php echo $buyer_username; ?> has Ordered a shoutout for account <?php echo $ordered_account; ?></div></td>
            <td><form method="post" action="orders">
            <div style="padding:8px;"><button class="btn btn-success" name="view">View</button></div>
            <input type="hidden" name="oid" value="<?php echo $rows['oid']; ?>">
            </form>
            </td>
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
}
else
{
	header('Location: index');
}
?>
</html>
