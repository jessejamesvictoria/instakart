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
<title> Messages </title>
</head>
<style>
body
{
padding-top:40px;
}
</style>
<body>

<div class="container">
<div class="content">
<?php
if(isset($_POST['delete'])&&isset($_POST['id']))
{
	if(!empty($_POST['id']))
	{
		$id = addslashes(strip_tags($_POST['id']));
		$id = mysqli_real_escape_string($conn, $id);
		$check_id_query = "SELECT * FROM contacts WHERE id = $id";
		$run_check_id_query = mysqli_query($conn, $check_id_query);
		$num_rows = mysqli_num_rows($run_check_id_query);
		if($num_rows >= 1)
		{
			$del_query = "DELETE FROM contacts WHERE id = $id";
			mysqli_query($conn, $del_query);
		}
		else
		{
			?>
        <div class="alert alert-danger" role="alert" width="200" height="60">
        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
            <span aria-hidden="true">x</span>
        </button>
        <ul>
            <li>Invalid id specifoed.</li>
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

?>
<?php
$rows_per_page = 15;
$rows_query = "SELECT * FROM contacts";
$run_rows_query = mysqli_query($conn, $rows_query);
$no_of_rows= mysqli_num_rows($run_rows_query);
$no_of_pages = ceil($no_of_rows/$rows_per_page);
if($no_of_pages < 1)
{
	$no_of_pages = 1;
}
if(isset($_GET['page']))
{
	$page = preg_replace('#[^0-9]#','',$_GET['page']);
	$limit = floor(($page*$rows_per_page)-$rows_per_page);
}
else
{
	$page = 1;
}
if($page < 1)
{
	$page = 1;
	$limit = floor(($page*$no_of_pages)-$no_of_pages);
}
else if($page > $no_of_pages)
{
	$page = $no_of_pages;
	$limit = floor(($page*$no_of_pages)-$no_of_pages);
}
else if(!isset($_GET['page']))
{
$limit = floor(($page*$no_of_pages)-$no_of_pages);	
}
?>
<?php
				if($no_of_rows == 0)
				{
					echo "<h3>No Messages to show.</h3>";
				}
				else
				{
				?>
                 <div style="clear:both">
                       <h2 class="text-center">Received Messages</h2>
                       </div>
                         <table class="table table-hover">
                         <thead>
                 <tr>
                 <th> Username </th>
                 <th> Email </th>
                 <th> Time </th>
                 <th> IP </th>
                 <th> Message </th>
                 <th> Action </th>
                 </tr>
                 </thead>
                 <tbody>
                        <?php 
				 $query = "SELECT * FROM contacts LIMIT $limit, $rows_per_page";
				 $run_query = mysqli_query($conn, $query);
				 while($rows = mysqli_fetch_assoc($run_query))
				 {
				 ?>
                  <tr>      
                  <?php
				  $username = $rows['username'];
				  $email = $rows['email'];
				  $message = $rows['message'];
				  $ip = $rows['ip'];
				  $time = $rows['time'];
				  $time = date('Y-M-d',$time);
				  $id = $rows['id'];
				  ?>
                  <form method="post" action="messages">
                  <td><?php echo $username; ?></td>
                  <td><?php echo $email; ?></td>
                  <td><?php echo $time; ?></td>
                  <td><?php echo $ip; ?></td>
                  <td><?php echo $message; ?></td>
                  <td><button class="btn btn-warning" name="delete">Delete</button></td>
                  <input type="hidden" value="<?php echo $id; ?>" name="id">
                  </form>
                  </tr>
				 <?php
				 }
				 ?>
                        </tbody>
                         </table>
                        <?php
						if($no_of_pages > 1)
						{
							?>
              <div class="panel-footer text-center">
                <div style="clear:both">
                <ul class="pagination">
                <?php 
				if($page > 1)
				{
					?>
                      <li><a href="messages.php?page=<?php echo $page-1?>">&laquo;</a></li>
                    <?php
				}
				else
				{
					?>
                    
                    <li class="disabled"><a href="messages.php?page=1">&laquo;</a></li>
                    <?php
				}
				
				?>
              
                	<?php
					if($no_of_pages > 1&&$no_of_pages<8)
					{
						for($b=1;$b<=$no_of_pages;$b++)
						{
						?>
						<li class="<?php if($page == $b){ echo "active";}?>"><a href="messages.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
						<?php	
						}
					}
					else if($no_of_pages > 6 )
					{
						if($page < 6)
						{
									for($b=1;$b<=6;$b++)
										{
										?>
										<li class="<?php if($page == $b){ echo "active";}?>"><a href="messages.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
										<?php	
										}
								?>
                                        <li class="disabled"><span>...</span></li>
                                        <li class="<?php if($no_of_pages == $page){echo "active";} ?>"><a href="messages.php?page=<?php echo $no_of_pages;?>"><?php echo $no_of_pages; ?></a></li>
								<?php
						}
						else if($page >= 6 && $page < $no_of_pages-5)
						{
							for($b=1;$b<=2;$b++)
										{
										?>
										<li class="<?php if($page == $b){ echo "active";}?>"><a href="messages.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
										<?php	
										}
								?>
                                        <li class="disabled"><span>...</span></li>
                                        <li ><a href="messages.php?page=<?php echo $page-1;?>"><?php echo $page-1; ?></a></li>
                                        <li class="<?php echo "active";?>"><a href="messages.php?page=<?php echo $page;?>"><?php echo $page; ?></a></li>
                                        <li><a href="messages.php?page=<?php echo $page+1;?>"><?php echo $page+1; ?></a></li>
                                        <li class="disabled"><span>...</span></li>
                                          <li ><a href="messages.php?page=<?php echo $no_of_pages-1;?>"><?php echo $no_of_pages-1; ?></a></li>
                                            <li ><a href="messages.php?page=<?php echo $no_of_pages;?>"><?php echo $no_of_pages; ?></a></li>
                                        
								<?php
						}
						else if($page >= $no_of_pages-5 )
						{
							for($b=1;$b<=2;$b++)
										{
										?>
										<li class="<?php if($page == $b){ echo "active";}?>"><a href="messages.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
										<?php	
										}
								?>
                                 <li class="disabled"><span>...</span></li>
                                <?php
								if($page <= $no_of_pages-5)
								{
									?>
                                        <li ><a href="messages.php?page=<?php echo $page-1;?>"><?php echo $page-1; ?></a></li>
                                        <li class="<?php echo "active";?>"><a href="messages.php?page=<?php echo $page;?>"><?php echo $page; ?></a></li>
                                        <li><a href="messages.php?page=<?php echo $page+1;?>"><?php echo $page+1; ?></a></li>
                                         <li class="disabled"><span>...</span></li>
                                         <li><a href="messages.php?page=<?php echo $no_of_pages-1 ?>"><?php echo $no_of_pages-1; ?></a></li>
                                         <li><a href="messages.php?page=<?php echo $no_of_pages ;?>"><?php echo $no_of_pages ; ?></a></li>
								<?php
								
								}
								else if($page >= $no_of_pages-5)
								{
								$l = $no_of_pages-5;
                                for($b=$l;$b<=$no_of_pages;$b++)
										{
										?>

										<li class="<?php if($page == $b){ echo "active";}?>"><a href="messages.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
										<?php	
										}
										}
						}
					}
						?>
                        <?php
						if($page < $no_of_pages)
						{
						?>
                        <li><a href="messages.php?page=<?php echo $page+1;?>">&raquo;</a></li>
                        <?php	
						}
						else
						{
							?>
                             <li class="disabled"><a href="messages.php?page=<?php echo $no_of_pages?>">&raquo;</a></li>
                            <?php
						}
						?>
                        
                        </ul>
                      </div>  
                      </div>
                      
                      <?php
					  }}

?>

</div>
</div>
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