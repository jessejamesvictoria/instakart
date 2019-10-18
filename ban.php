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
<title> Ban User / Instagram Account</title>
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
<div class="panel-body">   
<center>
<div class=" col-xs-12">
                    <div class="col-xs-12 col-sm-6 text-center">
                    <a href="banuser"><h1><span class="glyphicon glyphicon-user"></span></h1>
                    <p class="text-muted"> Ban User </p>
                    </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 text-center">
                    <a href="banig"><h1><span class="glyphicon glyphicon-camera"></span></h1>
                    <p class="text-muted"> Ban Instagram Account </p>
                    </a>
                    </div>
                    </div></center>
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