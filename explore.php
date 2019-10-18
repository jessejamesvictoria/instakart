<?php
@session_start();
include 'head.php';
include 'sqlconnect.php';
include 'core.inc.php';
include 'instagram.php';
if(isset($_SESSION['uid'])&&!empty($_SESSION['uid']))
{
	include 'loggedinheader.php';
}
else if(isset($_SESSION['admin_id']))
{
	include 'adminheader.php';
}
else
{
	include 'navbar.php';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Explore </title>
</head>
<style>
body
{
padding-top:10px;
}
#main-content
{
	padding-top:6%;
}
</style>
<body>
<div class="container">
     <div class="content" id="main-content">
		<?php
		if(isset($_POST['submit'])&&isset($_POST['cat'])&&isset($_POST['sort_by']))
		{		
			$cat = $_POST['cat'];
			$no = count($cat);
			if($no > 12)
			{
				die ("<h3> Invalid Category specified </h3>");
			}
			else
			{
				for($i=0;$i<$no;$i++)
				{
					$category[$i] = addslashes(strip_tags($cat[$i]));
					$category[$i] = mysqli_real_escape_string($conn, $category[$i]);
					if($category[$i]!='meme'&&$category[$i]!='fashion'&&$category[$i]!='sports'&&$category[$i]!='text'&&$category[$i]!='cars'&&$category[$i]!='travel'&&$category[$i]!='food'&&$category[$i]!='animals'&&$category[$i]!='lifestyle'&&$category[$i]!='personal'&&$category[$i]!='tech'&&$category[$i]!='science')
					{
						die("Invalid Category specified");
					}
				}
				$sortby = $_POST['sort_by'];
				if($sortby != 'none'&& $sortby != 'followers' && $sortby != 'price' && $sortby != 'score')
				{
					die("Invalid Category");
				}
				if($sortby == 'none')
				{	
					unset($_SESSION['sort']);
				}
				else
				{
					$_SESSION['sort']=$sortby;
				}
				$_SESSION['cat'] = $category;
				$_SESSION['filter']=true;
			
			}
			
		}
		
		?>
        
     <div class="page-header">
     <h2> Explore Instagram Shoutouts </h2>
     <h4> Promote your content on best Instagram accounts </h4>
     </div>
     <form method="post" action="explore">
        <div class="col-md-3">
        	<div class="panel panel-default">
                    <div class="panel-body">
                        <a href="#" class="navbar-toggle" data-toggle="collapse" data-target="#fademeout" style="float:none;margin:0px;padding:0px;color:#666666;" aria-expanded="false"><span class="glyphicon glyphicon-th-list"> </span></a>
                        <strong>Refine your search</strong>
                    </div>
                </div>
     <div id="fademeout" class="collapse navbar-collapse" style="padding:0px;" >
  
     	<div class="panel panel-default">
        	<div class="panel-heading">
             	Category.
            </div>
           
            <ul class="list-group">
            	<li class="list-group-item">
                <?php
				$check_cat = $_SESSION['cat'];
				$n = count($check_cat);
				?>
                <label>
                <input type="checkbox" name="cat[]" value="meme" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='meme'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Humor & Memes
              	</label>
                </li>
                <li class="list-group-item">
                <label>
                <input type="checkbox" name="cat[]" value="fashion" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='fashion'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Fashion & Style
              	</label>
                </li>
                <li class="list-group-item" name="cat[]">
                <label>
                <input type="checkbox" name="cat[]" value="sports" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='sports'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Sports & Fitness
              	</label>
                </li>
                <li class="list-group-item">
                <label>
                <input type="checkbox" name="cat[]" value="text" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='text'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Quotes & Text
              	</label>
                </li>
                <li class="list-group-item">
                <label>
                <input type="checkbox" name="cat[]" value="cars" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='cars'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Cars & Bikes
              	</label>
                </li>
                <li class="list-group-item">
                <label>
                <input type="checkbox" name="cat[]" value="travel" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='travel'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Travel & People
              	</label>
                </li>
                <li class="list-group-item">
                <label>
                <input type="checkbox" name="cat[]" value="food" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='food'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Food & Health
              	</label>
                </li>
                <li class="list-group-item">
                <label>
                <input type="checkbox" name="cat[]" value="animals" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='animals'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Animals & Pets
              	</label>
                </li>
                <li class="list-group-item">
                <label>
                <input type="checkbox" name="cat[]" value="lifestyle" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='lifestyle'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Lifestyle & Model
              	</label>
                </li>
                  <li class="list-group-item">
                <label>
                <input type="checkbox" name="cat[]" value="personal" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='personal'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Personal & Skills
              	</label>
                </li>
                  <li class="list-group-item">
                <label>
                <input type="checkbox" name="cat[]" value="tech" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='tech'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Computer & Technology
              	</label>
                </li>
                  <li class="list-group-item">
                <label>
                <input type="checkbox" name="cat[]" value="science" <?php if(isset($_SESSION['cat'])){for($i=0;$i<=$n;$i++){if($check_cat[$i]=='science'){echo "checked";}}}else if(!isset($_SESSION['cat'])){echo "checked";}?>> Science & Education
              	</label>
                </li>       
            </ul>
           
             <div class="panel-heading">
            	Sort By.
            </div>
            <div class="panel-body">
            	 <select class="form-control" id="sel1" name="sort_by" >
                 	 <option value="none" name="none" <?php if(isset($_SESSION['sort'])&&$_SESSION['sort']=='none'){echo "selected";}?>><i>None</i></option>
                 	 <option value="followers" name="followers"  <?php if(isset($_SESSION['sort'])&&$_SESSION['sort']=='followers'){echo "selected";}?>>Followers</option>
                      <option value="price" name="price"  <?php if(isset($_SESSION['sort'])&&$_SESSION['sort']=='price'){echo "selected";}?>>Price</option>
                      <option value="score" name="score"  <?php if(isset($_SESSION['sort'])&&$_SESSION['sort']=='score'){echo "selected";}?>>Score</option>
                 </select>
            </div>
       <center> <input type="submit" class="btn btn-success" name="submit"></center><br>
        </div>
        </div>
        </form>  
     </div>
     <div class="col-md-9">
     	<div class="panel panel-default">
        	<div class="panel-body">
            	 <table class="table">
                     <thead>
                     <tr>
                     <th> Account </th>
                     <th> Followers </th>
                     <th> Price </th> 
					  <th> Score </th>
                     </tr>
                     </thead>
                     <tbody>
                     <?php
						if(!isset($_SESSION['filter']))
						{	
							$rows_per_page = 20;
							$rows_query = "SELECT * FROM ig_accounts WHERE confirmed = 1  ORDER BY aid DESC";
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
								$query = "SELECT * FROM ig_accounts WHERE confirmed = 1  ORDER BY aid DESC LIMIT $limit, $rows_per_page";
								$run_query = mysqli_query($conn, $query);
								 while($rows = mysqli_fetch_assoc($run_query))
				 				{
									$user_name = $rows['username'];
									?>
                                    <tr>
                                    <td><img src="<?php echo $rows['profile_pic']?>" width="30" height="30" class="img-circle"><a href="accounts.php?username=<?php echo $user_name?>">@<?php echo $user_name; ?> </a></td>
                                    <td> <?php echo ($rows['followers'])/1000;?>k</td>
                                    <td> $<?php echo $rows['account_amount']; ?> </td>
                                    <td> <?php if($rows['score']==0){echo "<p class='text-muted'>N/A</p>";}else{ echo $rows['score']; } ?> </td>
                                    </tr>
                                    <?php				
								}
						}
						else if(isset($_SESSION['filter']))
						{
							$category = $_SESSION['cat'];
							$in = join("','", $category);
							$rows_per_page = 20;
							$rows_query = "SELECT * FROM ig_accounts WHERE confirmed = 1 AND category IN ('$in')";
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
								if(isset($_SESSION['cat'])&&isset($_SESSION['sort']))
								{	
									$sortby = $_SESSION['sort'];
									$query = "SELECT * FROM ig_accounts WHERE confirmed = 1 AND category IN ('$in')";
									$run_query = mysqli_query($conn, $query);
									$m=0;
											while($row = mysqli_fetch_assoc($run_query))
										{
											$username = $row['username'];
											$aid = $row['aid'];
											$account_amount = $row['account_amount'];
											$account_time   = $row['account_time'];
											$score = $row['score'];
											$followers = $row['followers'];
											$followers = ($followers)/1000;
											$profile_pic = $row['profile_pic'];
											$array[$m] = array('username'=>$username,'aid'=>$aid,'account_time'=>$account_time,'account_amount'=>$account_amount,'followers'=>$followers, 'score'=>$score, 'profile_pic'=>$profile_pic);
											$m++;
										}
										$l = $m;
												if($sortby == 'followers')
											{
												for($j=0;$j<$l;$j++)
												{
													for($p=0;$p<$l;$p++)
													{
														if($array[$p]['followers'] < $array[$p+1]['followers'])
															{	
																$temp = $array[$p];
																$array[$p] = $array[$p+1];
																$array[$p+1] = $temp;
															}
													}
												}
											}
											else if($sortby == 'price')
											{
												for($j=0;$j<$l;$j++)
												{
													for($p=0;$p<$l;$p++)
													{
														if($array[$p+1]['account_amount'] > $array[$p]['account_amount'])
															{	
																$temp = $array[$p+1];
																$array[$p+1] = $array[$p];
																$array[$p] = $temp;
															}
													}
												}
											}
											else if($sortby == 'score')
											{
												for($j=0;$j<$l;$j++)
												{
													for($p=0;$p<$l;$p++)
													{
														if($array[$p+1]['score'] > $array[$p]['score'])
															{	
																$temp = $array[$p+1];
																$array[$p+1] = $array[$p];
																$array[$p] = $temp;
															}
													}
												}
											}
										 $end = $rows_per_page+$limit;
										 if($end > $l)
										 {
											 $end = $l;
										 }
										for($i=$limit;$i<($end);$i++)
										{
											$user_name = $array[$i]['username'];
											?>
											<tr>
											<td><img src="<?php echo $array[$i]['profile_pic']; ?>" width="30" height="30" class="img-circle"><a href="accounts.php?username=<?php echo $user_name; ?>">@<?php echo $user_name; ?> </a></td>
											<td> <?php echo ($array[$i]['followers'])/1000; ?>k</td>
											<td> $<?php echo $array[$i]['account_amount']; ?> </td>
                                            <td> <?php if($array[$i]['score']==0){ echo "<p class='text-muted'><small>N/A</small></p>";}else {echo $array[$i]['score'];} ?> </td>
											</tr>
											<?php	
										}	
								}
								else if(isset($_SESSION['cat']))
								{
									$query = "SELECT * FROM ig_accounts WHERE confirmed = 1 AND category IN ('$in') LIMIT $limit, $rows_per_page";
										$run_query = mysqli_query($conn, $query);
									 while($rows = mysqli_fetch_assoc($run_query))
									{
										$user_name = $rows['username'];
										?>
										<tr>
										<td><img src="<?php echo $rows['profile_pic']?>" width="30" height="30" class="img-circle"><a href="accounts.php?username=<?php echo $user_name?>">@<?php echo $user_name; ?> </a></td>
										<td> <?php echo ($rows['followers'])/1000; ?>k</td>
										<td> $<?php echo $rows['account_amount']; ?> </td>
                                        <td> <?php if($rows['score']==0){echo "<p class='text-muted'><small>N/A</small></p>";}else{ echo $rows['score'];} ?> </td>
										</tr>
										<?php	
									}
									
								}
								$_SESSION['filter']=true;
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
                      <li><a href="explore.php?page=<?php echo $page-1?>">&laquo;</a></li>
                    <?php
				}
				else
				{
					?>
                    
                    <li class="disabled"><a href="explore.php?page=1">&laquo;</a></li>
                    <?php
				}
				
				?>
              
                	<?php
					if($no_of_pages > 1&&$no_of_pages<8)
					{
						for($b=1;$b<=$no_of_pages;$b++)
						{
						?>
						<li class="<?php if($page == $b){ echo "active";}?>"><a href="explore.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
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
										<li class="<?php if($page == $b){ echo "active";}?>"><a href="explore.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
										<?php	
										}
								?>
                                        <li class="disabled"><span>...</span></li>
                                        <li class="<?php if($no_of_pages == $page){echo "active";} ?>"><a href="explore.php?page=<?php echo $no_of_pages;?>"><?php echo $no_of_pages; ?></a></li>
								<?php
						}
						else if($page >= 6 && $page < $no_of_pages-5)
						{
							for($b=1;$b<=2;$b++)
										{
										?>
										<li class="<?php if($page == $b){ echo "active";}?>"><a href="explore.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
										<?php	
										}
								?>
                                        <li class="disabled"><span>...</span></li>
                                        <li ><a href="explore.php?page=<?php echo $page-1;?>"><?php echo $page-1; ?></a></li>
                                        <li class="<?php echo "active";?>"><a href="explore.php?page=<?php echo $page;?>"><?php echo $page; ?></a></li>
                                        <li><a href="explore.php?page=<?php echo $page+1;?>"><?php echo $page+1; ?></a></li>
                                        <li class="disabled"><span>...</span></li>
                                          <li ><a href="explore.php?page=<?php echo $no_of_pages-1;?>"><?php echo $no_of_pages-1; ?></a></li>
                                            <li ><a href="explore.php?page=<?php echo $no_of_pages;?>"><?php echo $no_of_pages; ?></a></li>
                                        
								<?php
						}
						else if($page >= $no_of_pages-5 )
						{
							for($b=1;$b<=2;$b++)
										{
										?>
										<li class="<?php if($page == $b){ echo "active";}?>"><a href="explore.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
										<?php	
										}
								?>
                                 <li class="disabled"><span>...</span></li>
                                <?php
								if($page <= $no_of_pages-5)
								{
									?>
                                        <li ><a href="explore.php?page=<?php echo $page-1;?>"><?php echo $page-1; ?></a></li>
                                        <li class="<?php echo "active";?>"><a href="explore.php?page=<?php echo $page;?>"><?php echo $page; ?></a></li>
                                        <li><a href="explore.php?page=<?php echo $page+1;?>"><?php echo $page+1; ?></a></li>
                                         <li class="disabled"><span>...</span></li>
                                         <li><a href="explore.php?page=<?php echo $no_of_pages-1 ?>"><?php echo $no_of_pages-1; ?></a></li>
                                         <li><a href="explore.php?page=<?php echo $no_of_pages ;?>"><?php echo $no_of_pages ; ?></a></li>
								<?php
								
								}
								else if($page >= $no_of_pages-5)
								{
								$l = $no_of_pages-5;
                                for($b=$l;$b<=$no_of_pages;$b++)
										{
										?>

										<li class="<?php if($page == $b){ echo "active";}?>"><a href="explore.php?page=<?php echo $b; ?>" style="text-decoration:none;"><?php echo $b; ?></a></li>
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
                        <li><a href="explore.php?page=<?php echo $page+1;?>">&raquo;</a></li>
                        <?php	
						}
						else
						{
							?>
                             <li class="disabled"><a href="explore.php?page=<?php echo $no_of_pages?>">&raquo;</a></li>
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
        </div>
     </div>
     </div>
     </div>
 <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> 
</body>
</html>
