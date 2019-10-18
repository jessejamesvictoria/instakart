<?php
@session_start();
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
if(isset($_SESSION['admin_id'])&&!empty($_SESSION['admin_id']))
{
include 'adminheader.php';
include 'instagram.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Account Approvals </title>
</head>
<style>
body
{
padding-top:40px;
}
#msg
{
	padding-top:25px;
}
</style>
<div class="col-md-10" id="msg">
<?php
									if(isset($_POST['account_id'])&&isset($_POST['approve']))
									{
									$account_id = addslashes(strip_tags($_POST['account_id']));
									$account_id = mysqli_real_escape_string($conn, $account_id);	
									$check_account_id_query = "SELECT * FROM ig_accounts WHERE aid = $account_id";
									$run_check_ac_query = mysqli_query($conn, $check_account_id_query);
									$num_of_account_ids = mysqli_num_rows($run_check_ac_query);
									if($num_of_account_ids == 0)
									{
										?>
                                        	<div class="col-md-8 col-md-offset-2">
                                            <div class="alert alert-danger" role="alert" width="200" height="60">
                                            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                                <span aria-hidden="true">x</span>
                                            </button>
                                            <ul>
                                                <li>Invalid account id.</li>
                                            </ul>
                                            </div>
                                            </div>
                                        <?php
									}
									else
									{
									  $approve_query = "UPDATE ig_accounts set confirmed =1 WHERE aid = $account_id";
									  $run_approve_query = mysqli_query($conn, $approve_query);
									  	?>
                                        <div class="col-md-8 col-md-offset-2">
                                            <div class="alert alert-success" role="alert" width="200" height="60">
                                            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                                <span aria-hidden="true">x</span>
                                            </button>
                                            <ul>
                                                <li>Account successfully Added.</li>
                                            </ul>
                                            </div>
                                            </div>
                                        <?php
									}
									
									}
									else if(isset($_POST['account_id'])&&isset($_POST['delete']))
										{
											$account_id = addslashes(strip_tags($_POST['account_id']));
											$account_id = mysqli_real_escape_string($conn, $account_id);	
											$check_account_id_query = "SELECT * FROM ig_accounts WHERE aid = $account_id";
											$run_check_ac_query = mysqli_query($conn, $check_account_id_query);
											$num_of_account_ids = mysqli_num_rows($run_check_ac_query);
												if($num_of_account_ids == 0)
											{
												?>
													<div class="col-md-8 col-md-offset-2">
													<div class="alert alert-danger" role="alert" width="200" height="60">
													<button class="close" aria-label="Close" data-dismiss="alert" type="button">
														<span aria-hidden="true">x</span>
													</button>
													<ul>
														<li>Invalid account id.</li>
													</ul>
													</div>
													</div>
												<?php
											}
												else
										{
										$delete_query = "DELETE FROM ig_accounts WHERE aid = $account_id";
										$run_delete_query = mysqli_query($conn, $delete_query);
										?>	
											
                                            <div class="col-md-8 col-md-offset-2">
                                            <div class="alert alert-success" role="alert" width="200" height="60">
                                            <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                                                <span aria-hidden="true">x</span>
                                            </button>
                                            <ul>
                                                <li>Account Deleted Successfully</li>
                                            </ul>
                                            </div>
                                            </div>
											
											<?php
										}
										}
									
									?>
                                    </div>
<?php
$rows_per_page = 20;
$rows_query = "SELECT * FROM ig_accounts WHERE confirmed = 0";
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
<style>
body
{
padding-top:40px;
}
#requests
{
	padding-top:4%;
}
#borderpanel
{
	padding:8px;
}

</style>
<body>
<div class="container">
     <div class="content" id="requests">
                   
                	 </div>  
                       
             <?php
				if($no_of_rows == 0)
				{
					echo "</br><h3> No Pending Requests </h3>";
				}
				else
				{
				?>
              <center>  <div class="col-md-10">
              
              <div style="clear:both">
                       <h2 class="text-center">
                   Pending Requests
                </h2>
                </div>
                <div class="panel panel-default" id="borderpanel">
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
				 $query = "SELECT * FROM ig_accounts WHERE confirmed = 0 LIMIT $limit, $rows_per_page";
				 $run_query = mysqli_query($conn, $query);
				 while($rows = mysqli_fetch_assoc($run_query))
				 {
				 ?>
                 <tr> 
                 <?php
				 $test_username = $rows['username'];
				 ?>
     			<td> <img src="<?php echo $rows['profile_pic'];?>" width="30" height="30" class="img-circle"><?php $user_name = $rows['username']; echo "<a href='reviewaccounts.php?username=$user_name'>@$user_name</a>"; ?> </td> 
				 <td> <?php echo ($rows['followers'])/1000;?>k</td>
                   <td> $<?php echo $rows['account_amount']; ?> </td>
                   <td> <form method="POST" action="requests"> 
                   <button class="btn btn-success btn-sm" name="approve">Approve</button>&nbsp;
                   <button class="btn btn-warning btn-sm" name="delete">Delete</button>
                    <?php
				   $username_for = $rows['username'];
				   $account_id_query = "SELECT aid FROM ig_accounts WHERE username= '$username_for' ";
				   $run_account_id_query = mysqli_query($conn, $account_id_query);
				   $result_row = mysqli_fetch_assoc($run_account_id_query);
                   ?>
                   <input type="hidden" name="account_id" value="<?php echo $result_row['aid'];?>"> 
                   </form>
                   </td>
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
                      <li><a href="requests.php?page=<?php echo $page-1?>">&laquo;</a></li>
                    <?php
				}
				else
				{
					?>
                    
                    <li class="disabled"><a href="requests.php?page=1">&laquo;</a></li>
                    <?php
				}
				
				?>
              
                	<?php
					if($no_of_pages > 1&&$no_of_pages<8)
					{
						for($b=1;$b<=$no_of_pages;$b++)
						{
						?>
						<li class="<?php if($page == $b){ echo "active";}?>"><a href="requests.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
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
										<li class="<?php if($page == $b){ echo "active";}?>"><a href="requests.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
										<?php	
										}
								?>
                                        <li class="disabled"><span>...</span></li>
                                        <li class="<?php if($no_of_pages == $page){echo "active";} ?>"><a href="requests.php?page=<?php echo $no_of_pages;?>"><?php echo $no_of_pages; ?></a></li>
								<?php
						}
						else if($page >= 6 && $page < $no_of_pages-5)
						{
							for($b=1;$b<=2;$b++)
										{
										?>
										<li class="<?php if($page == $b){ echo "active";}?>"><a href="requests.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
										<?php	
										}
								?>
                                        <li class="disabled"><span>...</span></li>
                                        <li ><a href="requests.php?page=<?php echo $page-1;?>"><?php echo $page-1; ?></a></li>
                                        <li class="<?php echo "active";?>"><a href="requests.php?page=<?php echo $page;?>"><?php echo $page; ?></a></li>
                                        <li><a href="requests.php?page=<?php echo $page+1;?>"><?php echo $page+1; ?></a></li>
                                        <li class="disabled"><span>...</span></li>
                                          <li ><a href="requests.php?page=<?php echo $no_of_pages-1;?>"><?php echo $no_of_pages-1; ?></a></li>
                                            <li ><a href="requests.php?page=<?php echo $no_of_pages;?>"><?php echo $no_of_pages; ?></a></li>
                                        
								<?php
						}
						else if($page >= $no_of_pages-5 )
						{
							for($b=1;$b<=2;$b++)
										{
										?>
										<li class="<?php if($page == $b){ echo "active";}?>"><a href="requests.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
										<?php	
										}
								?>
                                 <li class="disabled"><span>...</span></li>
                                <?php
								if($page <= $no_of_pages-5)
								{
									?>
                                        <li ><a href="requests.php?page=<?php echo $page-1;?>"><?php echo $page-1; ?></a></li>
                                        <li class="<?php echo "active";?>"><a href="requests.php?page=<?php echo $page;?>"><?php echo $page; ?></a></li>
                                        <li><a href="requests.php?page=<?php echo $page+1;?>"><?php echo $page+1; ?></a></li>
                                         <li class="disabled"><span>...</span></li>
                                         <li><a href="requests.php?page=<?php echo $no_of_pages-1 ?>"><?php echo $no_of_pages-1; ?></a></li>
                                         <li><a href="requests.php?page=<?php echo $no_of_pages ;?>"><?php echo $no_of_pages ; ?></a></li>
								<?php
								
								}
								else if($page >= $no_of_pages-5)
								{
								$l = $no_of_pages-5;
                                for($b=$l;$b<=$no_of_pages;$b++)
										{
										?>

										<li class="<?php if($page == $b){ echo "active";}?>"><a href="requests.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
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
                        <li><a href="requests.php?page=<?php echo $page+1;?>">&raquo;</a></li>
                        <?php	
						}
						else
						{
							?>
                             <li class="disabled"><a href="requests.php?page=<?php echo $no_of_pages?>">&raquo;</a></li>
                            <?php
						}
						?>
                        
                        </ul>
                      </div>  
                      </div>
                      <?php
				 }
				 ?>
                </div>
                </div></center>
                <?php
				}
				?>
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