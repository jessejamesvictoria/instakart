<?php
//here goes the account
//$my_account = 'messi'; // you can use post method
//returns a big old hunk of JSON from a non-private IG account page.
function scrape_insta($username) {
	@$insta_source = file_get_contents('http://instagram.com/'.$username);
	$shards = explode('window._sharedData = ', $insta_source);
	@$insta_json = explode(';</script>', $shards[1]); 
	$insta_array = json_decode($insta_json[0], TRUE);
	return $insta_array;
}
function scrape_insta_post($post) {
	@$insta_source = file_get_contents('http://instagram.com/p/'.$post);
	$shards = explode('window._sharedData = ', $insta_source);
	@$insta_json = explode(';</script>', $shards[1]); 
	$insta_array = json_decode($insta_json[0], TRUE);
	return $insta_array;
}

function followers($username)
{	
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user'];
	return $followers = $latest_array['edge_followed_by']['count'];
}
function profile_pic($username)
{	
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user'];
	return $profile_pic = $latest_array['profile_pic_url'];
}
function exploredata($username)
{
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	//profile pic
	$profile_pic_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user'];
	$followers_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user'];
	$ig_id_array = $results_array['entry_data'];
	$followers = $followers_array['edge_followed_by']['count'];
	$profile_pic = $profile_pic_array['profile_pic_url_hd'];
	if($ig_id_array == NULL)
	{
		$status = 0;
	}
	else
	{
		$status = 1;
	}
	return $data = array('followers'=>$followers,'profile_pic'=>$profile_pic, 'status'=>$status);
}
function instagram_id($username)
{
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	#print_r(json_encode($results_array['entry_data']['ProfilePage'][0]['graphql']['user']['id']));
	if($results_array['entry_data'] == NULL)
	{
		return 0;
	}
	else
	{
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user'];
	return $latest_array['id'];
	}
}
function biography($username)
{
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user'];
	return $biography = $latest_array['biography']."<br>";
}function posts($username)
{
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user'];
	return $posts = $latest_array['edge_owner_to_timeline_media']['count']."<br>";
}
function follows($username)
{	
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user'];
	return $followers = $latest_array['edge_follow']['count']."<br>";
}
function latest_post_array($username)
{	
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	for($i=0;$i<=9;$i++)
	{
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'][$i];
	return $latest_post_array = '<a href="http://instagram.com/p/'.$latest_array['code'].'"><img src="'.$latest_array['display_src'].'"></a></br>';
	}
}
function latest_post_six($username)
{	
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	for($i=0;$i<6;$i++)
	{
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'][$i];
	$latest_post_array = $latest_array['node']['thumbnail_resources'][0]['src'];
			if($latest_array == NULL)
			{
				continue;
			}
			else
			{
	?>
		<div class="col-sm-6 col-xs-4">
   			 <img class="img-rounded img-responsive" src="<?php echo $latest_post_array;?>" width="250" height="250" style="margin:0 0 1em 0; ">
             </nobr>
        </div>
    <?php
			}
	}
}
function latest_post_likes($username)
{	
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'][0];
	return $post_like = $latest_array['likes']['count'];
}
function latest_post_comments($username)
{	
	$my_account = $username; 
	$results_array = scrape_insta($my_account);
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'][0];
	return $comments_count = $latest_array['comments']['count'];
}
function latest_post($username)
{	
	$my_account = $username;
	$results_array = scrape_insta($my_account);
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'][0];
	return $latest_post = '<a href="http://instagram.com/p/'.$latest_array['code'].'"><img src="'.$latest_array['display_src'].'"></a></br>';
}
//reserved for trackings
function latest_post_array_links($order_id)
{	
	$oid = $order_id;
	$my_account = $username;
	@include 'sqlconnect.php';
	$oid = $order_id;
	$get_order_query = "SELECT * FROM orders WHERE oid = $oid";
	$run_order_query = mysqli_query($conn, $get_order_query);
	$order_rows = mysqli_fetch_assoc($run_order_query);
	$ordered_account = $order_rows['ordered_account'];
	$content = $order_rows['content'];
	$results_array = scrape_insta($ordered_account);
	$found = 0 ;
	for($i=0;$i<=10;$i++)
	{
	$latest_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'][$i]['node']['edge_media_to_caption']['edges'][0]['node'];
	$caption = $latest_array['text'];
		if(preg_match("/".$content."/",$caption))
		{
			$code = $results_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'][$i]['node']['shortcode'];
			$found = 1;
			break;
		}
	}
	if($found == 1)
	{
		$update_query = "UPDATE orders SET shoutout_link = '$code' WHERE oid = $oid";
		$run_update_query = mysqli_query($conn, $update_query);
		return true;
	}
	else if($found == 0)
	{
		return false;	
	}
}
function get_likes_by_link($link)
{
	$link_code = $link;
	$results_array = scrape_insta_post($link_code);
	if($results_array['entry_data']==NULL)
	{
		return false;
	}
	else
	{
	return $results_array['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_media_preview_like']['count'];
	}
}
function get_comments_by_link($link)
{
	$link_code = $link;
	$results_array = scrape_insta_post($link_code);
	if($results_array['entry_data'] == NULL)
	{
		return false;
	}
	else
	{
	return $results_array['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_media_to_parent_comment']['count'];
	}
}
function check_content_again($order_id)
{
	@include 'sqlconnect.php';
	$oid = $order_id;
	$get_link_query = "SELECT content, shoutout_link FROM orders WHERE oid = $oid";
	$run_get_link = mysqli_query($conn, $get_link_query);
	$link_row = mysqli_fetch_assoc($run_get_link);
	$link_code = $link_row['shoutout_link'];
	$content = $link_row['content'];
	$results_array = scrape_insta_post($link_code);
	$latest_array = $results_array['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_media_to_caption']['edges'][0]['node'];
	$caption = $latest_array['text'];
	if(preg_match("/".$content."/",$caption))
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>
