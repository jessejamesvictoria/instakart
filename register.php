<?php
@session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Register for Instakart </title>
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
</style>
<?php
include 'head.php';
include 'core.inc.php';
include 'sqlconnect.php';
include 'navbar.php';
if(!isset($_SESSION['uid']))
{
?>
<div class="container">
     <div class="content" id="form-login">
            <div class="panel-header">
                <h2 class="text-center">
                    Register for Instakart
                </h2>
                </div>
                
                <div class="panel-body">
                         
                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    <form role="form" action="register.php" method="post" >
                    	<div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-user"></span> 
								   </div>
								   <input  type="text" class="form-control" name="username" id="username" placeholder="Username" minlength="3"	maxlength="10">
						     </div>
						</div>
                        	<div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-envelope"></span> 
								   </div>
								   <input  type="email" class="form-control" name="email" placeholder="Email"/>
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
						<div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-lock"></span> 
								   </div>
								   <input  type="password" class="form-control" name="repeat-password" placeholder="Repeat Password" minlength="7"/>
						     </div>
						</div>
                       
                        <p style="color:red">
                        <?php
						include 'sqlconnect.php';
						if(isset($_POST['username'])&&isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['repeat-password'])&&isset($_POST['token'])&&isset($_POST['submit']))
						{
							if(!empty($_POST['username'])&&!empty($_POST['email'])&&!empty($_POST['password'])&&!empty($_POST['repeat-password'])&&!empty($_POST['token']))
							{
								$token = $_POST['token'];
								if($token == $_SESSION['token'])
								{
								$password = addslashes(strip_tags($_POST['password']));
								$repeat_password = addslashes(strip_tags($_POST['repeat-password']));
									if($password == $repeat_password)
									{
									$username = addslashes(strip_tags($_POST['username']));
									$username = mysqli_real_escape_string($conn, $username);
									$password = addslashes(strip_tags(md5($password)));
									$password = mysqli_real_escape_string($conn, $password);
									$email = addslashes(strip_tags($_POST['email']));
									$email = mysqli_real_escape_string($conn, $email);
									$reg_time = time();
									$join_date = date('Y/m/d', $reg_time);
									$mysqli_query = "SELECT username FROM registered_users WHERE username = '$username'";
									$run_query = mysqli_query($conn, $mysqli_query);
									$result_rows = mysqli_num_rows($run_query);
										if($result_rows == 0)
										{
											$email_check_query = "SELECT email FROM registered_users WHERE email = '$email' ";
											$run_email_check_query = mysqli_query($conn, $email_check_query);
											$result_emails_row = mysqli_num_rows($run_email_check_query);
											if( $result_emails_row == 0 )
											{	
												
												$last_ip = get_ip();
												#$insert_last_ip = "UPDATE registered_users SET login_ip = '$last_ip' WHERE username = '$username'";
												#$run_insert_last_ip = mysqli_query($conn, $insert_last_ip); 											
												mysqli_query($conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
												$confirm_code = md5(uniqid(mt_rand(),true));
												$insert_query = "INSERT INTO registered_users(username,email,password,confirm_code,join_date,login_ip) VALUES('$username','$email','$password','$confirm_code',cast('$join_date' AS DATE),'$last_ip') ";
												$run_insert_query = mysqli_query($conn, $insert_query);
												$to = $email;
												$subject = "Activate your account ";
												$headers = "From: Instakart ";
												$body = "Hello $username,\n\nYou need to register your account in order to use our products and Services.\nClick on the link below to register\nhttp://instakart.rf.gd/login.php?username=$username&code=$confirm_code";
												mail($to,$subject,$body,$headers);
												echo "<p style='color:green'>You are registered Successfully !\n Please check your email to activate the account.</p>";
											}
											else
											{
												echo "Email has been Already Registered "."<br>";
											}
										}
										else
										{
											echo "Username already taken"."<br>";
										}
									}
									else
									{
										echo "Passwords donot Match"."<br>";
									}
								}
							
							}
							
						//all fields required
							else
							{
							echo "All fields are required "."<br>";	
							}
						}
						?>
                        </p>
                        <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
                        <div class="modal-footer">
						<button class="btn btn-success" name="submit">Sign up</button>
					</div>
                    </form>
                    </div>
                </div>
            </div>
            </div>
            </div>
            
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</html>
<?php
include 'footer.php';
}
else
{
	header('Location: dashboard.php');
}
?>