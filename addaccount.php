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
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid'])&&isset($_SESSION['ver_account']))
{
	include 'instagram.php';
	$ig_username = $_SESSION['ver_account'];
?>
<style>
body
{
padding-top:40px;
}
.msg
{
	padding-top:30px;
}
</style>
<body>
<div class="container">
<div class="msg">
<?php
if(isset($_POST['account_description'])&&isset($_POST['account_amount'])&&isset($_POST['account_time'])&&isset($_POST['account_category'])&&isset($_POST['addaccount_button'])&&isset($_POST['token']))
{
 if(!empty($_POST['account_description'])&&isset($_POST['account_amount'])&&isset($_POST['account_time'])&&isset($_POST['account_category'])&&!empty($_POST['token']))
 {
	 $tokenr = addslashes(strip_tags($_POST['token']));
	 $tokenr = mysqli_real_escape_string($conn, $tokenr);
	 if($tokenr == $_SESSION['token'])
	 {
		 $account_description = addslashes(strip_tags($_POST['account_description']));
		 $account_description = mysqli_real_escape_string($conn, $account_description);
		 $account_amount = addslashes(strip_tags($_POST['account_amount']));
		 $account_amount = mysqli_real_escape_string($conn, $account_amount);
		 $account_time = addslashes(strip_tags($_POST['account_time']));
		 $account_time = mysqli_real_escape_string($conn, $account_time);
		 $account_category = addslashes(strip_tags($_POST['account_category']));
		 $account_category = mysqli_real_escape_string($conn, $account_category);
		 if(strlen($account_description) > 300)
		 {
			 ?>
             <div class="alert alert-danger" role="alert" width="200" height="60">
            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                <span aria-hidden="true">x</span>
            </button>
            <ul>
                <li>Account Description cannot be greater than 300 characters.</li>
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
                        <li>Account amount cannot be greater than $ 999.</li>
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
                            <li>Account amount cannot be in negative.</li>
                        </ul>
                        </div>
                    <?php
				}
				else
				{
				 	if(is_numeric($account_time))
					{
						if($account_time < 1)
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
						else if($account_time > 168)
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
							$user_id = instagram_id($ig_username);		
							$uid = $_SESSION['uid'];
							$followers = followers($ig_username);
							$profile_pic = profile_pic($ig_username);	
							mysqli_query($conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");	
							$insert_query = "INSERT INTO ig_accounts(username,category,account_amount,account_time,account_description,user_id,uid,followers,profile_pic) VALUES('$ig_username','$account_category',$account_amount,$account_time,'$account_description','$user_id',$uid,$followers,'$profile_pic') ";
							$run_insert_query = mysqli_query($conn, $insert_query);
							unset($_SESSION['ver_account']);
							$_SESSION['red_success']=true;
							header('Location: success');
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
                            <li>Time must be in decimal only eg. 4, 10, 24.</li>
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
                <li>price can only be in decimal.</li>
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
            <li>Invalid token.</li>
        </ul>
        </div>
         <?php
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
        <li>All fields are required.</li>
    </ul>
    </div>
    <?php
 }
}
?>
</div>
<div class="page-header">
<h3 style="padding-top:50px;">Add Account Info for @<span style="color:#006AF9" ><?php echo $ig_username; ?></span></h3>
</div>
    <div class="content">
		<div class="panel panel-default">
            <div class="panel-body">
            	 <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                 <form role="form" action="addaccount" method="post">
                 	<div class="form-group">
			 <center><img src="<?php echo profile_pic($ig_username); ?>" class="img-circle" alt="Profie Picture" style="width:25%; height:17%"></center><br>
			 <textarea class="form-control" rows="5" name="account_description" placeholder="Account Description" maxlength="300"></textarea>
		</div>
        			<div class="form-group">
				<input  type="number" class="form-control" name="account_amount" placeholder="Amount in USD $ eg. 5, 10 ,45" maxlength="3">
			</div>	
			<div class="form-group">
				<input  type="number" class="form-control" name="account_time" placeholder="Duration for Post in hours eg. 4, 24, 48 " maxlength="3">
			</div>	
			
			<div class="form-group">
  <label for="sel1">Select Category:</label>
  <select class="form-control" id="sel1" name="account_category" >
    <option value="meme">Humor & Memes</option>
    <option value="fashion">Fashion & Style</option>
    <option value="sports">Sports & Fitness</option>
    <option value="text">Quotes & Text</option>
    <option value="cars">Cars & Bikes</option>
    <option value="travel">Travel & People</option>
    <option value="food">Food & Health</option>
    <option value="animals">Animals & Pets</option>
    <option value="lifestyle">Lifestyle & Model</option>
    <option value="personal">Personal & Skills</option>
    <option value="tech">Computer & Technology</option>
    <option value="science">Science & Education</option>
  </select>
</div>
 <input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
<div class="modal-footer">
<a href="find" class="btn btn-warning">Cancel</a>
			<button class="btn btn-success" name="addaccount_button">Submit</button>
	</div>
                    
                 </form>
                 </div>
                 </div>
                 </div>
                 </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<?php
include 'footer.php';
}
else
{
	header('Location: index');
}
?>