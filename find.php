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
<title>Find Instagram Account </title>
</head>
<?php
include 'head.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'instagram.php';
?>
<style>
body
{
padding-top:40px;
}
.msgtouser
{
	color:#006AF9;
}
</style>
<body>
<div class="container">
<div class="page-header">
<h3 style="padding-top:50px;">Add account</h3>
</div>

<div class="container">
		<div class="panel panel-default">
            <div class="panel-body">       
                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                	 <form role="form" action="find" method="post" >
                        	<div class="form-group">
							<div class="input-group">
								   <div class="input-group-addon">
									<span class="glyphicon glyphicon-user"></span> 
								   </div>
								   <input  type="text" class="form-control" name="ig_username" placeholder="Instagram Username"/ >
						     </div>
                             </div>
                             <p style="color:#006AF9"> 
                             <?php
                             include 'sqlconnect.php';
							 if(isset($_POST['ig_username'])&&isset($_POST['submit'])&&isset($_POST['token']))
							 {
								if(!empty($_POST['ig_username'])&&!empty($_POST['token']))
								{
									$tokenr = addslashes(strip_tags($_POST['token']));
									$tokenr = mysqli_real_escape_string($conn, $tokenr);
									if($tokenr = $_SESSION['token'])
									{
										$ig_username = addslashes(strip_tags($_POST['ig_username']));
										$ig_username = mysqli_real_escape_string($conn, $ig_username );
										$check_username_query = "SELECT username FROM ig_accounts WHERE username = '$ig_username' AND confirmed = 0";
										$run_check_query = mysqli_query($conn, $check_username_query);
										$no_of__rows = mysqli_num_rows($run_check_query);
										if($no_of__rows == 0 )
										{	
												$another_query = "SELECT username FROM ig_accounts WHERE username = '$ig_username' AND confirmed = 1";
												$run_another_query = mysqli_query($conn, $another_query);
												$no_of_con_rows = mysqli_num_rows($run_another_query);
												if($no_of_con_rows == 0 )
												{
													if(instagram_id($ig_username)==0)
													{
														echo "<br>Specified User not found<br>";
													}
													else
													{	
														$instagram_id = instagram_id($ig_username);
														$check_query = "SELECT * FROM banned_accounts WHERE user_id = $instagram_id";
														$run_c_query = mysqli_query($conn, $check_query);
														$num_rows = mysqli_num_rows($run_c_query);
														if($num_rows >= 1)
														{
														 echo "<p class='msgtouser'>Specified instagram Account is banned.</p>";
														}
														else
														{
														header("Location: verify.php?username=$ig_username");
														}
													}
												}
												else
												{
													echo "<p class='msgtouser'>Account already registered</p>";
												}
											
										}
										else
										{
											echo "<p class='msgtouser'>Account is under review by Administrator</p>";
										}
										
									}
									else
									{
										echo "<p class='msgtouser'>Something went wrong</p>";
									}
								}
								else
								{
									echo "<p class='msgtouser'>All fields are required</p>";
								}
							 }
							 ?>
                             </p>
						</div>
                        <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
                        <div class="modal-footer">
						<button class="btn btn-success" name="submit">Find account</button>
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
<?php
include 'footer.php';
}
else
{
	header('Location: index.php');
}
?>