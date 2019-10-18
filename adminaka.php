<?php
@ob_start();
@session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Admin login </title>
</head>
<style>
body
{
padding-top:70px;
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
if(!isset($_SESSION['admin_id']))
{
?>
<body>
<div class="container">
     <div class="content" id="form-login">
            <div class="panel-header">
                <h2 class="text-center">
                    Welcome to Admin Login
                </h2>
                
                <div class="panel-body">
                         
                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    <form role="form" action="adminaka" method="post" >
                           	<div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-user"></span> 
								   </div>
								   <input  type="text" class="form-control" name="admin_username" id="username" placeholder="Username" minlength="3"/ 		                                      maxlength="15">
						     </div>
						</div>
						<div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-lock"></span> 
								   </div>
								   <input  type="password" class="form-control" name="admin_password" placeholder="Password" minlength="7"/>
						     </div>
							
						</div>
                        <p style="color:#006AF9">
                        <?php
						if(isset($_POST['admin_username'])&&isset($_POST['admin_password'])&&isset($_POST['submit'])&&isset($_POST['token']))
						{
							if(!empty($_POST['admin_username'])&&!empty($_POST['admin_password'])&&!empty($_POST['token']))
							{
								$tokenr = addslashes(strip_tags($_POST['token']));
								$tokenr = mysqli_real_escape_string($conn, $tokenr);
								if($tokenr == $_SESSION['token'])
								{
									$admin_username = addslashes(strip_tags($_POST['admin_username']));
									$admin_username = mysqli_real_escape_string($conn, $admin_username);
									$admin_password = addslashes(strip_tags($_POST['admin_password']));
									$admin_password = mysqli_real_escape_string($conn, $admin_password);
									$admin_password = md5($admin_password);
									$select_admin_query = "SELECT admin_id FROM adminsmo WHERE admin_username = '$admin_username' AND admin_password = '$admin_password' ";
									$run_admin_query = mysqli_query($conn, $select_admin_query);
									$no_of_admin_rows = mysqli_num_rows($run_admin_query);
									$admin_id_fetch = mysqli_fetch_assoc($run_admin_query);
									$admin_id = $admin_id_fetch['admin_id'];
									if($no_of_admin_rows == 1)
									{
									 $_SESSION['admin_id'] = $admin_id;
									 $login_ip = get_ip();
									 $insert_login_ip_query = "UPDATE adminsmo SET login_ip = '$login_ip' WHERE admin_id = ".$_SESSION['admin_id']." ";
									 $run_insert_query = mysqli_query($conn, $insert_login_ip_query);
									 header('Location: admindb');
									}
									else
									{
										echo "Invalid username or password <br>";
									}
								}
								else
								{
									echo "Invalid token <br>";
								}
							}
							else
							{
								echo "All fields are required";
							}
						}
						?>
                        </p>
                             <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
                        <div class="modal-footer">
						<button class="btn btn-success" name="submit">Sign in</button>
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
</body>
</html>
<?php
}
else
{
	header('Location: admindb');
}
?>