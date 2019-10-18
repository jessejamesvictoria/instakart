<?php
@session_start();
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
include 'instagram.php';
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
                    Ban Instagram Account
                </h2>
             </div>

<div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    <form role="form" action="banig" method="post" >
                    
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
									if(instagram_id($username)==0)
									{
										echo "Username not found";
									}
									else
									{
										$user_id = instagram_id($username);
										$c_q = "SELECT * FROM banned_accounts WHERE user_id = $user_id";
										$r_c_q = mysqli_query($conn, $c_q);
										$num_rows = mysqli_num_rows($r_c_q);
										if($num_rows >= 1)
										{
											echo "Usernamed already banned.";
										}
										else
										{
											$c_exist_q = "SELECT * FROM ig_accounts WHERE username = '$username'";
											$run_c_q = mysqli_query($conn, $c_exist_q);
											$c_n_rows = mysqli_num_rows($run_c_q);
											if($c_n_rows >=1 )
											{
												$del_query = "DELETE FROM ig_accounts WHERE username = '$username'";
												mysqli_query($conn, $del_query);
											}
											$insert_query = "INSERT INTO banned_accounts (user_id) VALUES ('$user_id')";
											if(mysqli_query($conn, $insert_query))
											{
												echo "Username banned successfully";	
											}
											else
											{
												echo "Something went wrong.";	
											}
										}
									}
									
								}
								
								else
								{
									echo "Invalid token";
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
						<button class="btn btn-success" name="submit">Ban Account</button>
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