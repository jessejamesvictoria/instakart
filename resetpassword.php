<?php
@session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Reset Password </title>
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
<body>
<?php
include 'head.php';
include 'sqlconnect.php';
include 'navbar.php';
if(!isset($_SESSION['uid']))
{
?>
<div class="container">
     <div class="content" id="form-login">
                             <?php
							 include 'sqlconnect.php';
							  if(isset($_GET['username'])&&isset($_GET['code']))
							  {
								  if(!empty($_GET['username'])&&!empty($_GET['code']))
								  {
									  $username = addslashes(strip_tags($_GET['username']));
									  $username = mysqli_real_escape_string($conn, $username);
									  $code = addslashes(strip_tags($_GET['code']));
									  $code = mysqli_real_escape_string($conn, $code);
									  $select_code_query = "SELECT username, reset_code FROM registered_users WHERE username='$username' AND reset_code = '$code'";
									  $run_select_code_query = mysqli_query($conn, $select_code_query);
									  $num_of_rows = mysqli_num_rows($run_select_code_query);
									  if($num_of_rows == 1)
									  {
										  ?>
                       <div class="panel-header">
               					 <h2 class="text-center">
                 						   Reset Password
              					 </h2>
 						<div class="panel-body">
                         
                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
										         <form role="form" action="<?php echo "resetpassword.php?username=".$username."&code=".$code;?>" method="post" >
                    <div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-lock"></span> 
								   </div>
								   <input  type="password" class="form-control" name="password" placeholder="Password" minlength="3" maxlength="20"/>
						     </div>
                             </div>
                    <div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-lock"></span> 
								   </div>
								   <input  type="password" class="form-control" name="repeat-password" placeholder="Repeat password" minlength="3" maxlength="20"/ >
						     </div>
                             </div>
                             <p style="color:red">
                             <?php
							 if(isset($_POST['password'])&&isset($_POST['repeat-password'])&&isset($_POST['token']))
							 {	
								if(!empty($_POST['password'])&&!empty($_POST['repeat-password'])&&!empty($_POST['token']))
								{	
									$tokenr = addslashes(strip_tags($_POST['token']));
									$tokenr = mysqli_real_escape_string($conn, $tokenr);
									if($tokenr == $_SESSION['token'])
									{
								 	$password = addslashes(strip_tags($_POST['password']));
									$password = mysqli_real_escape_string($conn, $password );
									$repeat_password = addslashes(strip_tags($_POST['repeat-password']));
									$repeat_password = mysqli_real_escape_string($conn, $repeat_password);
									if($password == $repeat_password)
									{
										$password = md5($password);
										$update_pass_query = "UPDATE registered_users SET password = '$password' WHERE username = '$username'";
										$run_update_query = mysqli_query($conn, $update_pass_query);
										$update_code_query = "UPDATE registered_users SET reset_code = 0 WHERE username = '$username' ";
										$run_code_query = mysqli_query($conn, $update_code_query);
										echo "<p style='color:green'> Password has been updated Successfully ! You can login <a href='login.php'> HERE </a></p>";
									}
									else
									{
										echo "Passwords donot match <br>";
									}
									}
									else
									{
										echo "Something went wrong "."<br>";
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
                    	<button class="btn btn-success" name="submit">Submit</button>
							 </div>
                    

					</form>
</div>
</div>
</div>          
                                          
										  <?php
									  }
									  else
									  {
										  echo "<h2> OOPS, Something went Wrong </h2><br>";
									  }
								  }
								  else
								  {
									  echo "<h2> OOPS, Something went Wrong </h2><br>";
								  }
							  }
							  else
							  {
								  echo "<h2> OOPS, Something went Wrong </h2><br>";
							  }
							 
							 ?>
                        
                      

</div>
</div>

<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>

<?php
include 'footer.php';
}
else
{
	header('Location: dashboard.php');
}
?>
