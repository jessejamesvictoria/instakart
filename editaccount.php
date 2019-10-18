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
<title>Add Account </title>
</head>
<?php
include 'head.php';
include 'sqlconnect.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
include 'instagram.php';
?>
<style>
body
{
padding-top:40px;
}
</style>
<body>

<?php
if((isset($_POST['account_id'])&&isset($_POST['edit']))||isset($_SESSION['account_id']))
{
	if(!empty($_POST['account_id'])||!empty($_SESSION['account_id']))
	{
		$uid = $_SESSION['uid'];
		if(!isset($_POST['account_id'])&&!isset($_POST['edit']))
		{
			$account_id = $_SESSION['account_id'];
		}
		else
		{
		$account_id = addslashes(strip_tags($_POST['account_id']));
		$account_id = mysqli_real_escape_string($conn, $account_id);
		$_SESSION['account_id'] = $account_id;
		}
		$validate_query = "SELECT * FROM ig_accounts WHERE uid = $uid AND aid= $account_id";
		$run_validate_query = mysqli_query($conn, $validate_query);
		$no_of_rows = mysqli_num_rows($run_validate_query);
		$user_row = mysqli_fetch_assoc($run_validate_query);
		$instagram_username = $user_row['username'];
		if($no_of_rows == 0)
		{
			?>
            <d
			iv class="container">
            
			 <div class="content">
             <div class="page-header">
            <h3 style="padding-top:50px;">Invalid account id.</h3>
             </div>
            </div>
            </div>
            <?php
		}
		else
		{
			?>
            <div class="container">
             <div class="content">
             <?php 
			 if(instagram_id($instagram_username)==0)
					 {
						?>
                          <div class="page-header">               
                     	   <h3 style="padding-top:50px;">Invalid Account</h3>
                        </div>
                        <?php
					 }else
					 {
			 ?>
             <div class="page-header">               
            <h3 style="padding-top:50px;">Edit Account @<span style="color:#006AF9" ><?php echo $instagram_username; ?></span></h3>
            </div>
                <div class="panel-body">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                         <form role="form" action="editaccount" method="post">
                  <center>       <?php
			 if(isset($_POST['update'])&&isset($_POST['token'])&&isset($_POST['account_description'])&&isset($_POST['account_amount'])&&isset($_POST['account_time'])&&isset($_POST['account_category']))
			 {
				 if(!empty($_POST['token'])&&!empty($_POST['account_description'])&&!empty($_POST['account_amount'])&&!empty($_POST['account_time'])&&!empty($_POST['account_category']))
				 {
					 $tokenr = addslashes(strip_tags($_POST['token']));
					 $tokenr = mysqli_real_escape_string($conn, $tokenr);
					 if($_SESSION['token'] == $tokenr )
					 { 		
						 $account_description = addslashes(strip_tags($_POST['account_description']));
						 $account_description = mysqli_real_escape_string($conn, $account_description);
						 $account_amount = addslashes(strip_tags($_POST['account_amount']));
						 $account_amount = mysqli_real_escape_string($conn, $account_amount);
						 $account_time = addslashes(strip_tags($_POST['account_time']));
						 $account_time = mysqli_real_escape_string($conn, $account_time);
						 $account_category = addslashes(strip_tags($_POST['account_category']));
						 $account_category = mysqli_real_escape_string($conn, $account_category);
						 if(strlen($account_description) > 300 )
						 {
							 ?>
                     
							<div class="alert alert-danger" role="alert" width="200" height="60">
							<button class="close" aria-label="Close" data-dismiss="alert" type="button">
								<span aria-hidden="true">x</span>
							</button>
							<ul>
								<li>Account Description must be less than 300 characters.</li>
							</ul>
							</div>
					
                             <?php
						 }
						 else
						 {
							 if(is_numeric($account_amount))
							 {
								 	if($account_amount > 999)
										{
											?>
                                
										<div class="alert alert-danger" role="alert" width="200" height="60">
                                            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                                <span aria-hidden="true">x</span>
                                            </button>
                                            <ul>
                                                <li>Account price must be less than $ 999.</li>
                                            </ul>
                                            </div>
                                    
                                            <?php
										}
										else if($account_amount < 1)
										{
											?>
                                         
										<div class="alert alert-danger" role="alert" width="200" height="60">
                                            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                                <span aria-hidden="true">x</span>
                                            </button>
                                            <ul>
                                                <li>Account price must be atleast $ 1.</li>
                                            </ul>
                                            </div>
                                     
                                            <?php
										}
										else
										{
											if(is_numeric($account_time))
												{	
													if($account_time > 168)
													{
														?>
                                        
										<div class="alert alert-danger" role="alert" width="200" height="60">
                                            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                                <span aria-hidden="true">x</span>
                                            </button>
                                            <ul>
                                                <li>Time must be less than 168 hours.</li>
                                            </ul>
                                            </div>
                                        
                                                        <?php
													}
													else if($account_time < 1)
													{
														?>
										<div class="alert alert-danger" role="alert" width="200" height="60">
                                            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                                <span aria-hidden="true">x</span>
                                            </button>
                                            <ul>
                                                <li>Time must be atleast 1 hour.</li>
                                            </ul>
                                            </div>
                                            <?php
                                            }
											else
											{
													if($account_category!='meme'&&$account_category!='fashion'&&$account_category!='sports'&&$account_category!='text'&&$account_category!='cars'&&$account_category!='travel'&&$account_category!='food'&&$account_category!='animals'&&$account_category!='lifestyle'&&$account_category!='personal'&&$account_category!='tech'&&$account_category!='science')
														{
															?>
                                         
										<div class="alert alert-danger" role="alert" width="200" height="60">
                                            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                                <span aria-hidden="true">x</span>
                                            </button>
                                            <ul>
                                                <li>Invalid Category.</li>
                                            </ul>
                                            </div>
                                      
                                                            <?php
														}
														
														else
														{
															mysqli_query($conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
														 	$update_query = "UPDATE ig_accounts SET account_description ='$account_description', account_amount = $account_amount, account_time = $account_time, category = '$account_category' WHERE uid = 	$uid AND aid = $account_id ";
															$run_update_query = mysqli_query($conn, $update_query);
															?>
                                                            <div class="alert alert-success" role="alert" width="200" height="60">
                                                        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                                            <span aria-hidden="true">x</span>
                                                        </button>
                                                        <ul>
                                                            <li>Account updated successfully.</li>
                                                        </ul>
                                                        </div>
                                                            <?php
														}
											}
												}
												else
												{
													?>
										
										<div class="alert alert-danger" role="alert" width="200" height="60">
                                            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                                <span aria-hidden="true">x</span>
                                            </button>
                                            <ul>
                                                <li>Time should be in decimal only eg. 4, 10, 24.</li>
                                            </ul>
                                            </div>
              
												<?php
                                                }
										}
							 }
							 else
							 {
								?>
                                    <div class="col-md-12 col-md-offset-2" style="clear:both">
							<div class="alert alert-danger" role="alert" width="200" height="60">
							<button class="close" aria-label="Close" data-dismiss="alert" type="button">
								<span aria-hidden="true">x</span>
							</button>
							<ul>
								<li>Account amount must be numeric.</li>
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
                          <div class="col-md-12 col-md-offset-2" style="clear:both">
							<div class="alert alert-danger" role="alert" width="200" height="60">
							<button class="close" aria-label="Close" data-dismiss="alert" type="button">
								<span aria-hidden="true">x</span>
							</button>
							<ul>
								<li>Invalid token.</li>
							</ul>
							</div>
							</div>
                         <?php
					 }
				 }
				 else
				 {?>
					 <div class="col-md-12 col-md-offset-2" style="clear:both">
							<div class="alert alert-danger" role="alert" width="200" height="60">
							<button class="close" aria-label="Close" data-dismiss="alert" type="button">
								<span aria-hidden="true">x</span>
							</button>
							<ul>
								<li>All fields are required.</li>
							</ul>
							</div>
							</div>
				 <?php
                 }
			 }
			 ?></center>
             <?php
			 $validate_query = "SELECT * FROM ig_accounts WHERE uid = $uid AND aid= $account_id";
		$run_validate_query = mysqli_query($conn, $validate_query);
		$no_of_rows = mysqli_num_rows($run_validate_query);
		$user_row = mysqli_fetch_assoc($run_validate_query);
		$instagram_username = $user_row['username'];
			 ?>
                                <div class="form-group">
                 <center><img src="<?php echo profile_pic($instagram_username); ?>" class="img-circle" alt="Profie Picture" style="width:25%; height:17%"></center><br>
                 <textarea class="form-control" rows="5" name="account_description" placeholder="Account Description" maxlength="300" ><?php echo $user_row['account_description'];?></textarea>
           						</div>
            <div class="form-group">
				<input  type="number" class="form-control" name="account_amount" placeholder="Amount in USD $ eg. 5, 10 ,45" maxlength="3" value="<?php echo $user_row['account_amount'];?>">
			</div>	
            <div class="form-group">
				<input  type="number" class="form-control" name="account_time" placeholder="Duration for Post in hours eg. 4, 24, 48 " maxlength="3" value="<?php echo $user_row['account_time'];?>">
			</div>	
            <?php
			$category = $user_row['category'];
			?>
            <div class="form-group">
  <label for="sel1">Select Category:</label>
  <select class="form-control" id="sel1" name="account_category" >
    <option value="meme" <?php if($category == 'meme'){ echo "selected";}?>>Humor & Memes</option>
    <option value="fashion" <?php if($category == 'fashion'){ echo "selected";}?>>Fashion & Style</option>
    <option value="sports" <?php if($category == 'sports'){ echo "selected";}?>>Sports & Fitness</option>
    <option value="text" <?php if($category == 'text'){ echo "selected";}?>>Quotes & Text</option>
    <option value="cars" <?php if($category == 'cars'){ echo "selected";}?>>Cars & Bikes</option>
    <option value="travel" <?php if($category == 'travel'){ echo "selected";}?>>Travel & People</option>
    <option value="food" <?php if($category == 'food'){ echo "selected";}?>>Food & Health</option>
    <option value="animals" <?php if($category == 'animal'){ echo "selected";}?>>Animals & Pets</option>
    <option value="lifestyle" <?php if($category == 'lifestyle'){ echo "selected";}?>>Lifestyle & Model</option>
    <option value="personal" <?php if($category == 'personal'){ echo "selected";}?>>Personal & Skills</option>
    <option value="tech" <?php if($category == 'tech'){ echo "selected";}?>>Computer & Technology</option>
    <option value="science" <?php if($category == 'science'){ echo "selected";}?>>Science & Education</option>
  </select>
</div>
 <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
<div class="modal-footer">
<a href="find" class="btn btn-warning">Cancel</a>
			<button class="btn btn-success" name="update">Update</button>
	</div>

                        </form>
                    </div>
                </div>
                <?php
					 }
					 ?>
            </div>
            </div>

            <?php
		}
	}
	else
	{
		echo "<h3> Invalid Account id </h3>";
	}
	
}
?>
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
