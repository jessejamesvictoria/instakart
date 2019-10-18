<?php
@ob_start();
@session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Login to Shoutsmeout </title>
</head>
<style>
body
{
padding-top:40px;
}
#form-login
{
	padding-top:4%;
}
</style><?php
include 'head.php';
include 'sqlconnect.php';
include 'navbar.php';
include 'core.inc.php';
if(!isset($_SESSION['uid']))
{
?>
<body>
<div class="container">
     <div class="content" id="form-login">
            <div class="panel-header">
                <h2 class="text-center">
                    Login to Instakart
                </h2>
                
                <div class="panel-body">

                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    <form role="form" action="login" method="post" >
                    	<div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-user"></span> 
								   </div>
								   <input  type="text" class="form-control" name="username" id="username" placeholder="Username" minlength="3"/ 		                                      maxlength="15">
						     </div>
						</div>
						<div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-lock"></span> 
								   </div>
								   <input  type="password" class="form-control" name="password" placeholder="Password" minlength="7"/>
						     </div>
							
						</div>
                        <p style="color:red">
                        <?php
						if(isset($_GET['username'])&&isset($_GET['code']))
						{
							if(!empty($_GET['username'])&&!empty($_GET['code']))
							{
								$username = strip_tags(addslashes($_GET['username']));
								$username = mysqli_real_escape_string($conn, $username);
								$code = strip_tags(addslashes($_GET['code']));
								$code = mysqli_real_escape_string($conn, $code);
								$select_code_query = "SELECT confirmed FROM registered_users WHERE username='$username'";
								$run_code_query = mysqli_query($conn, $select_code_query);
								$result_code_query = mysqli_fetch_assoc($run_code_query);
								$confirmed_code = $result_code_query['confirmed'];
								if($confirmed_code == 1)
								{
									echo "<p style='color:green'> Your account is already Activated </p> "."<br>";	
								}
								else
								{
									$select_query = "SELECT confirm_code FROM registered_users WHERE username='$username' ";
									$run_select_query = mysqli_query($conn, $select_query);
									$result_select = mysqli_fetch_assoc($run_select_query);
									$code_from_db = $result_select['confirm_code'];
									if($code == $code_from_db )
									{
									$activate_query = "UPDATE registered_users SET confirmed =1 WHERE username = '$username'";
									$run_activate_query = mysqli_query($conn, $activate_query);
									echo "<p style='color: green'> Your account is activated successfully </p>";	
									}
									else
									{
										echo "There was an Error while activating an account"."<br>";
									}
								}
							}
							else
							{
								echo "There was an Error while activating an account"."<br>";
							}
						}
						else if(isset($_POST['submit']))
						{
							if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['token']))
							{	
								if(!empty($_POST['username'])&&!empty($_POST['password'])&&!empty($_POST['token']))
								{
									//$tokenr = $_POST['token'];
									if(1==1)
										{
								$username = strip_tags(addslashes($_POST['username']));
								$username = mysqli_real_escape_string($conn, $username);
								$password_get = strip_tags(addslashes($_POST['password']));
								$password_get = mysqli_real_escape_string($conn, $password_get);
								$password = md5($password_get);
								$validate_query = "SELECT username, password FROM registered_users WHERE username = '$username' AND password = '$password' ";
								$run_validate_query = mysqli_query($conn, $validate_query);
								$no_validate = mysqli_num_rows($run_validate_query);
									if($no_validate == 1)
									{
										$select = "SELECT confirmed FROM registered_users WHERE username = '$username'";
										$run_confirm_query = mysqli_query($conn, $select);
										$result_confirm_query = mysqli_fetch_assoc($run_confirm_query);
										$confirmed_result = $result_confirm_query['confirmed'];	
										if($confirmed_result == 1)
										{	
											$select_uid_query = "SELECT uid FROM registered_users WHERE username = '$username' ";
											$run_uid_query = mysqli_query($conn, $select_uid_query);
											$fetch_rows = mysqli_fetch_assoc($run_uid_query);
											$uid_row = $fetch_rows['uid'];
											//got the userid in the $uid_row
											$last_login_ip = get_ip();
											//got the last login ip here in $last_login_ip
											$check_valid_ip = "SELECT banned_ip FROM banned_ip WHERE banned_ip = '$last_login_ip'";
											$run_check_valid_query = mysqli_query($conn, $check_valid_ip);
											$num_of_ips = mysqli_num_rows($run_check_valid_query);
											if($num_of_ips == 0)
											{
											$_SESSION['uid'] = $uid_row;
											//session uid initialized 
											$last_time = time();
											$last_date = date('Y/m/d', $last_time);
											$insert_last_login_query = "UPDATE registered_users SET last_login = CAST('$last_date' AS DATE) where uid = ".$_SESSION['uid']." ";
											$run_last_login_query = mysqli_query($conn, $insert_last_login_query);
											$last_ip = get_ip();
											$last_ip = addslashes(strip_tags($last_ip));
											$last_ip = mysqli_real_escape_string($conn, $last_ip);
											$insert_last_ip = "UPDATE registered_users SET login_ip = '$last_ip' WHERE uid= ".$_SESSION['uid']." ";
											$run_insert_last_ip = mysqli_query($conn, $insert_last_ip); 
											header('Location: dashboard');
											}
											else
											{
												echo "You are banned by admninistrator <br>";
											}
										}
										else
										{
											echo "You need to confirm your email before loggin in"."<br>";
										}
										
									}
									else
									{
									echo "Username or Password is incorrect"."<br>";	
									}
									
										}
									else
									{
										echo "Something went wrong";
									}
								}
								
							
								else
								{
									echo "Username or Password cannot be empty "."<br>";
								}
							}
						
						}
						?>
                        </p>
                        <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
                        <div class="modal-footer">
						<button class="btn btn-success" name="submit">Sign in</button>
					</div>
                    </form>
                    <p style="color: #006AF9"> <a href="reset"> Forgot Password ? </a> </p>
                     <p style="color: #006AF9"> <a href="register"> Don't have accont ? Register here </a> </p>
                    </div>
                </div>
            </div>
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
	header('Location: dashboard.php');
}
?>