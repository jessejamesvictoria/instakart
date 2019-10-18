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
<title>Verify your account</title>
</head>
<?php
include 'head.php';
include 'sqlconnect.php';
include 'instagram.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
?>
<style>
body
{
padding-top:40px;
}
.content
{
	padding-top:10%;
}
#ver
{
	clear:both;
}
</style>
<body>
<div class="container">
        <div class="content">
		<div class="panel panel-default">
            <div class="panel-body">  
 <?php
if(isset($_GET['username']))
{
	if(!empty($_GET['username']))
	{
		$ig_username = addslashes(strip_tags($_GET['username']));
		$ig_username = mysqli_real_escape_string($conn, $ig_username);
		$check_username_query = "SELECT username FROM ig_accounts WHERE username = '$ig_username' AND confirmed = 0";
		$run_username_query = mysqli_query($conn, $check_username_query);
		$result_username_rows = mysqli_num_rows($run_username_query);
		if($result_username_rows == 1)
		{
			echo "<h3>Account is under review by Administrator.</h3><br>";
		}
		else
		{	
			$another_query = "SELECT username FROM ig_accounts WHERE username = '$ig_username' AND confirmed = 1";
			$run_another_query = mysqli_query($conn, $another_query);
			$no_of_cons = mysqli_num_rows($run_another_query);
			if($no_of_cons == 1)
			{
				echo "Username already registered";
			}
			else
				{
				if(instagram_id($ig_username)==0)
						{
							echo "<h3> Specified User not found <h3>";
						}
						else
						{
				$instagram_id = instagram_id($ig_username);
				$check_query = "SELECT * FROM banned_accounts WHERE user_id = $instagram_id";
				$run_c_query = mysqli_query($conn, $check_query);
				$num_rows = mysqli_num_rows($run_c_query);
				if($num_rows >= 1)
				{
				?>
				<div class="panel-body">
				<h3 style="padding:5px;" class="text-muted">Specified instagram Account is banned.</h3>
				</div>
				<?php
					die();
				}
				else
				{
				$string = 'abcdefghijklmnopqurstuvwxyz1234567890';
				$string = str_shuffle($string);
				$place_string = substr($string, 0, 5);
						
				
			?>
			  <div class="col-xs-12 col-sm-6 col-sm-offset-3">
			 <?php
			 if(isset($_POST['verify'])&&isset($_POST['token']))
			 {
				 if(!empty($_POST['token']))
				 {
					$tokenr = addslashes(strip_tags($_POST['token']));
					$tokenr = mysqli_real_escape_string($conn, $tokenr);
					if($tokenr == $_SESSION['token'])
					{
						$array_user = biography($ig_username);
						$code = $_SESSION['code'];
						if(preg_match("/".$code."/",$array_user))
						{
							$_SESSION['ver_account'] = $ig_username;
							header('Location: addaccount');
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
								<li> Verification code not found.</li>
							</ul>
							</div>
							</div>
							<?php
						}
					}
					else
					{
						echo "<h3>Username already registered</h3>";
					}
				}
					else
					{
					echo "<h3>Invalid token</h3>";
					}
				  }
			 
			 ?>
			<form method="POST" action="verify.php?username=<?php echo $ig_username?>">
			 <h2 class="text-center" id="ver"> Verify @<span style="color:#006AF9"><?php echo $ig_username; ?></span></h2>
			 <center><img src="<?php echo profile_pic($ig_username)?>" class="img-circle"/></center>
			<h3 class="text-center"> <?php echo $ig_username; ?> </h3>
			<center> <strong><?php echo followers($ig_username) ?></strong><p> followers </p></center>
		   
			<div class="alert alert-warning" role="alert" width="200" height="60">
			Please verify this account by placing "<?php echo $place_string; ?>" in your instagram bio section, then click Verify.
			</div>
			  <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
							<?php
							$_SESSION['code'] = $place_string;
							?>
					  <center><a href="find" class="btn btn-warning">Cancel</a>
							<button class="btn btn-success" name="verify">Verify</button></center>
			
	</div>
			</form>
			<?php
						
						
						}
					}
		}
		}
	}
	else
	{
	echo "<h3>Something went wrong</h3>";
	}
}
else
{
	echo "<h3>Something went wrong</h3>";
}
?>
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