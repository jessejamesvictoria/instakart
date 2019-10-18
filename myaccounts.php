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
<title>My Accounts</title>
</head>
<?php
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'instagram.php';
?>
<style>
body
{
padding-top:40px;
}
#user_acs
{
	padding-top:4%;
}
#borderpanel
{
	padding:8px;
}
#acc
{
	clear:both;
}
</style>
<body>
<div class="container">
     <div class="content" id="user_acs">
         <div class="col-md-10">
          		 <div style="clear:both">
                 <?php 
				 	if(isset($_POST['account_id'])&&isset($_POST['delete']))
					{
						if(!empty($_POST['account_id']))
						{	
							$uid = $_SESSION['uid'];
							$account_id = addslashes(Strip_tags($_POST['account_id']));
							$account_id = mysqli_real_escape_string($conn, $account_id);
							$validate_query = "SELECT * FROM ig_accounts WHERE uid = $uid AND aid= $account_id";
							$run_validate_query = mysqli_query($conn, $validate_query);
							$no_of_rows = mysqli_num_rows($run_validate_query);
							if($no_of_rows == 0)
							{
								?>
                                <div class="col-md-8 col-md-offset-2">
                                <div class="alert alert-danger" role="alert" width="200" height="60">
                                <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true">x</span>
                                </button>
                                <ul>
                                    <li> Invalid Account id.</li>
                                </ul>
                                </div>
                                </div>
                                <?php
							}
							else
							{
								$delete_account = "DELETE FROM ig_accounts WHERE aid = $account_id ";
								if($run_delete_query = mysqli_query($conn, $delete_account))
								{
									?>
                                         <div class="col-md-8 col-md-offset-2">
                                <div class="alert alert-success" role="alert" width="200" height="60">
                                <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true">x</span>
                                </button>
                                <ul>
                                    <li> Account deleted successfully !</li>
                                </ul>
                                </div>
                                </div>
                                    <?php
								}
							}
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
								<li> Invalid Account id.</li>
							</ul>
							</div>
							</div>
                            <?php
						}
					}
				 ?>
                       <h2 class="text-center" id="acc">My Accounts</h2>
                        <div class="panel panel-default" id="borderpanel">
                        <?php 
						$user_accounts_query = "SELECT * FROM ig_accounts WHERE uid =$uid AND confirmed = 1";
						$run_user_accounts_query = mysqli_query($conn, $user_accounts_query);
						$num_of_user_accounts = mysqli_num_rows($run_user_accounts_query);
						if($num_of_user_accounts == 0)
						{
							echo "<h4> You don't have any accounts yet. </h4>";
						}
						else
						{
						?>
                 			<table class="table">
                            	 <thead>
                                 <tr>
                                 <th> Account </th>
                                 <th> Followers </th>
                                 <th> Price </th>
                                 <th> Action </th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 <?php
								  	$uid = $_SESSION['uid'];
									while($account_rows = mysqli_fetch_assoc($run_user_accounts_query))
									{
										?>	
										<tr>
                                        <?php
											 $test_username = $account_rows['username'];
											 ?>
                                        <td><img src="<?php echo $account_rows['profile_pic'];?>" width="30" height="30" class="img-circle"><?php $user_name = $account_rows['username']; echo "<a href='accounts.php?username=$user_name'>@$user_name</a>"; ?></td>
                                        <td> <?php echo ($account_rows['followers'])/1000; ?>k</td>
                                        <td> $<?php echo $account_rows['account_amount']; ?></td>
                                        <td> 
                                        <form method="post" action="editaccount" style="float:left;">
                                        <?php $_SESSION['edit_acc']=true;?>
                                        <button class="btn btn-success btn-sm" name="edit">Edit</button>&nbsp; 
                                        <input type="hidden" name="account_id" value="<?php echo $account_rows['aid']; ?>">
                                        </form></nobr>
                                        <form method="post" action="myaccounts">
                                        <button class="btn btn-warning btn-sm" name="delete" >Delete</button>
                                        <input type="hidden" name="account_id" value="<?php echo $account_rows['aid']; ?>">
                                        </form>
                                        </td>
                                        </tr>
                                 	<?php
									}
								 ?>
                                 </tbody>  
                            </table>
                          
                            <?php
								}
								?>
                               
                            </div>   
                               <a href="find" class="btn btn-success">Add Account </a>
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