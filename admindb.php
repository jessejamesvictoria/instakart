<?php
@session_start();
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
if(isset($_SESSION['admin_id']))
{
include 'adminheader.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Admin Dashboard </title>
</head>
<style>
body
{
padding-top:60px;
}
</style>
<body>
<div class="container">
     <div class="content">
            <div class="panel-header">
                <h2 class="text-center">
                    Dashboard
                </h2>
                <div class="panel-body">        
           		<div class="bg-success col-xs-12">
                <div class="col-xs-12 col-sm-6 text-center">
                <h2><span class="glyphicon glyphicon-user"></span>
                 <?php echo total_users() ?> </h2>
                <p class="text-muted"> Registered Users </p>
                <br>
                </div>
                 <div class="col-xs-12 col-sm-6 text-center">
                <h2> <span class="glyphicon glyphicon-camera"></span>
                 <?php echo total_accounts() ?> </h2>
                <p class="text-muted"> Total Accounts, <a href="requests"><?php echo need_approval()?> Needs Approval. </a></p>
                <br>
                </div>
                
                </div>
                <div class="bg-info col-xs-12">
                <div class="col-xs-12 col-sm-6 text-center">
                <h2><span class="glyphicon glyphicon-picture"></span>
                 <?php echo all_user_sales() ?> </h2>
                <p class="text-muted"> Total shoutouts sold </p>
                <br>
                </div>
                 <div class="col-xs-12 col-sm-6 text-center">
                <h2> <span class="glyphicon glyphicon-bullhorn"></span>
                 <?php echo total_messages() ?> </h2>
                <p class="text-muted"> Total Messages, <a href="messages">View All</a></p>
                <br>
                </div>
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
include 'footer.php';
}
else
{
	header('Location: index');
}
?>