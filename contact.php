<?php 
@session_start();
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'loggedinheader.php';
}
else if(isset($_SESSION['admin_id'])&&!empty($_SESSION['admin_id']))
{
	include 'adminheader.php';
}
else
{
	include 'navbar.php';
}
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Contact Us</title>
</head>
<style>
body
{
padding-top:40px;
}
#contact
{
margin-top:30px;	
}
#label
{
	padding-top:7px;
	text-align:right;
}
#spacing
{
	padding-top:35px;
}
</style>
<body>
<div class="container">
<div class="content">
<div id="spacing">
</div>
<?php
if(isset($_POST['username'])&&isset($_POST['email'])&&isset($_POST['message'])&&isset($_POST['token'])&&isset($_POST['submit']))
{
	if(isset($_POST['g-recaptcha-response']))
	{
		$captcha=$_POST['g-recaptcha-response'];
		$secretKey = "6Ld9XSETAAAAANbV2ajGdE6YdtkhoeMjNx25b_hZ";
		$ip = $_SERVER['REMOTE_ADDR'];
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
		$responseKeys = json_decode($response,true);
		if(intval($responseKeys["success"]) !== 1) {
          ?>
          <div class="alert alert-danger" role="alert" width="200" height="60">
        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
            <span aria-hidden="true">x</span>
        </button>
        <ul>
            <li>Please check the captcha box.</li>
        </ul>
        </div>
          <?php
        } else 
		{
        $tokenr = addslashes(strip_tags($_POST['token']));
		$tokenr = mysqli_real_escape_string($conn, $tokenr);
		if($_SESSION['token']==$tokenr)
		{
			if(!empty($_POST['username'])&&!empty($_POST['email'])&&!empty($_POST['message']))
			{
		  $username = addslashes(strip_tags($_POST['username']));
		  $username = mysqli_real_escape_string($conn, $username);
		  $email = addslashes(strip_tags($_POST['email']));
		  $email = mysqli_real_escape_string($conn, $email);
		  $message = addslashes(strip_tags($_POST['message']));
		  $message = mysqli_real_escape_string($conn, $message);
		  $ip = get_ip();
		  $time = time();
		  mysqli_query($conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
		  $query  = "INSERT INTO contacts (username, email, message, time, ip) VALUES ('$username', '$email', '$message', '$time', '$ip')";
		  if(mysqli_query($conn, $query))
		  {
			  ?>
              <div class="alert alert-success" role="alert" width="200" height="60">
        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
            <span aria-hidden="true">x</span>
        </button>
        <ul>
            <li>Thanks for contacting us.</li>
        </ul>
        </div>
        <?php
		  }
		  else
		  {
			  ?>
              <div class="alert alert-warning" role="alert" width="200" height="60">
        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
            <span aria-hidden="true">x</span>
        </button>
        <ul>
            <li>Something went wrong.</li>
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
		else
		{
			?>
            <div class="alert alert-danger" role="alert" width="200" height="60">
        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
            <span aria-hidden="true">x</span>
        </button>
        <ul>
            <li>Something went wrong.</li>
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
            <li>Please check the captcha box.</li>
        </ul>
        </div>
        <?php
	}
}
?>
<div class="panel-header">
<h2 class="text-center">
    Contact us
</h2>
</div>
<form method="post" action="contact">
<div class="panel panel-default" id="contact">

<div class="panel-heading" >Contact Support</div>
<div class="panel-body">
<div class="form-group">
<label class="col-sm-3 control-label" for="username" id="label">Name</label>
<div class="col-sm-9">
    <input type="text" class="form-control" name="username">
</div>
</div><br><br>
<div class="form-group">
<label class="col-sm-3 control-label" for="email" id="label">Email</label>
<div class="col-sm-9">
    <input type="email" class="form-control" name="email">
</div>
</div><br><br>
<div class="form-group">
<label class="col-sm-3 control-label" for="message" id="label">Message</label>
<div class="col-sm-9">
    <textarea name="message" class="form-control"></textarea>
</div><br><br>
</div><br>
<div class="form-group">
<div class="col-sm-3"></div>
<div class="col-sm-9">
<div class="g-recaptcha" data-sitekey="6Ld9XSETAAAAAEJQMjHBlTsTwC0pbKUZMkdJo7i5"></div>
</div>
</div><br><br>
<br><br>
<input type="hidden" value="<?php echo $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true)); ?>" name="token">
						<div class="col-sm-3"></div>
                        <div class="col-sm-9">
                        <button class="btn btn-success" name="submit">Submit</button>
                        </div>
                    </form>
</div>
</div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> 
</body>
</html>
<?php
include 'footer.php';
?>