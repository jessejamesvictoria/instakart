<?php
@session_start();
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
if(isset($_SESSION['admin_id']))
{
include 'adminheader.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Banuser </title>
</head>
<style>
body
{
padding-top:40px;
}
#ban-user
{
	padding-top:4%;
}

</style>
<body>
<div class="container">
     <div class="content" id="ban-user">
            <div class="panel-header">
                            <h2 class="text-center">
                    Ban User
                </h2>
             </div>

<div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    <form role="form" action="banuser" method="post" >
                    
                      	<div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-user"></span> 
								   </div>
								   <input  type="text" class="form-control" name="username" id="username" placeholder="Username" minlength="3"/ 		                                      maxlength="15">
						     </div>
						</div>
                    <p style="color:#006AF9">
                    	<?php
						if(isset($_POST['username'])&&isset($_POST['token'])&&isset($_POST['submit']))
						{
							if(!empty($_POST['username'])&&!empty($_POST['token']))
							{
								$tokenr = addslashes(strip_tags($_POST['token']));
								$tokenr = mysqli_real_escape_string($conn, $tokenr);
								if($tokenr == $_SESSION['token'])
								{
									$username = addslashes(strip_tags($_POST['username']));
									$username = mysqli_real_escape_string($conn, $username);
									$select_user_query = "SELECT login_ip FROM registered_users WHERE username = '$username'";
									$run_sel_query = mysqli_query($conn, $select_user_query);
									$num_r = mysqli_num_rows($run_sel_query);
									if($num_r == 0)
									{
										echo "Invalid Username specified.";
									}
									else
									{
									$fetch_rows = mysqli_fetch_assoc($run_sel_query);
									$user_ip = $fetch_rows['login_ip'];
									$check_ip_query = "SELECT * FROM banned_users WHERE banned_ip = '$user_ip'";
									$run_check_query = mysqli_query($conn, $check_ip_query);
									$no_of_rows = mysqli_num_rows($run_check_query);
									if($no_of_rows == 0)
									{
									$ban_query = "INSERT INTO banned_ip(banned_ip) VALUES('$user_ip') ";
									$run_ban_query = mysqli_query($conn, $ban_query);
									echo "User ".$username." banned successfully ";
									}
									else
									{
										echo "The specified user ip already exists <br>";
									}
									}
								}
								
								else
								{
									echo "Invalid token <br>";
								}
							}
							else
							{
								echo "All fields are required <br>";
							}
							
						}
                        ?>
					</p>
                         <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
                        <div class="modal-footer">
						<button class="btn btn-success" name="submit">Ban User</button>
                    </form>
                    </div>
                    </div>
                    </div>
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