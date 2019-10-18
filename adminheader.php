<?php
@session_start();
if(isset($_SESSION['admin_id']))
{
?>
<nav class="navbar navbar-inverse navbar-fixed-top" id="my-navbar">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="" class="navbar-brand">IGShoutouts</a>
		</div><!-- Navbar header -->
		<div class="collapse navbar-collapse" id="navbar-collapse">
		
			<ul class="nav navbar-nav navbar-right">
				
				<li><a href="admindb"><span class="glyphicon glyphicon-signal"> Dashboard </a></li>
                <li><a href="payments"><span class="glyphicon glyphicon-list"> Payments </a></li>
				<li><a href="ban"><span class="glyphicon glyphicon-eye-close"> Ban </a></li>
				<li><a href="logout"><span class="glyphicon glyphicon-log-out"></a></li>
		
			</ul>
		</div>
		
	</div><!-- End of the container -->
</nav><!-- End of the navbar -->
<?php
}
?>