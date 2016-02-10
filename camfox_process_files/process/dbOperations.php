<?php
function getDBConnection()
{
	require 'camfoxconfig.php'; 
	$conn = mysql_connect("$db_host","$db_username","$db_password","$db_name");  
	$selected=mysql_select_db("$db_name");  
	return $conn;
}

function closeDBConnection($conn)
{
	mysql_close($conn);
}

function signup($username, $firstname, $surname, $email, $mobileNo, $password, $birth_date, $gender, $user_voice)
{
	$conn=getDBConnection();
	$current_date = date("Y-m-d H:i:s");
	$insertQuery="insert into users(user_name, first_name, 	sur_name, email_id, mobile_no, password, birth_date, gender, status, date_time, user_voice) values('$username','$firstname', '$surname', '$email', '$mobileNo', '$password', '$birth_date', '$gender', 'new', '$current_date', $user_voice)";
	if (!mysql_query($insertQuery,$conn))
	{
	  return $insertQuery;
  	}
	else
	{
		closeDBConnection($conn);
		return true;
	}
}

function isUser($username,$password)
{
	$conn=getDBConnection();
	$sql="select id from users where email_id='$username' and password='$password'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	return $row['id'];
}

function get_last_login($user_id)
{
	$conn=getDBConnection();
	$sql="select last_login from users where id = '$user_id'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	return $row['last_login'];
}

function update_last_login_date($user_id)
{
	$conn=getDBConnection();
	$current_date = date("Y-m-d H:i:s");
	$query = "update users set last_login = '$current_date' where id = '$user_id'";
	$retval = mysql_query( $query, $conn );
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error());
	}	
	closeDBConnection($conn);
}

function getFriendsList($user_id)
{
	$conn=getDBConnection();$i=0;
	$query=" select u.* from users u JOIN contacts c on u.id = c.child where c.parent='$user_id' and c.status = 'approved' and friends_status = 'Y'";
	$result = mysql_query($query, $conn) or die(mysql_error());
	$contacts=null;
	while( $row = mysql_fetch_array($result) )
	{
        $contacts[$i][0]  = $row['id'];
        $contacts[$i][1]  = $row['user_name'];
		$contacts[$i][2]  = $row['first_name'];
		$contacts[$i][3]  = $row['sur_name'];
		$contacts[$i][4]  = $row['email_id'];
		$contacts[$i][5]  = $row['mobile_no'];
		$contacts[$i][6]  = $row['birth_date'];
		$contacts[$i][7]  = $row['gender'];
		$contacts[$i][8]  = $row['status'];
		$contacts[$i][9]  = $row['date_time'];
		$contacts[$i][10]  = $row['picture'];
		$contacts[$i][11]  = $row['online_datetime'];
		$i++;
    }
	return $contacts;
}

function newPost($content, $user_id, $post_type)
{
	$conn=getDBConnection();
	$current_date = date("Y-m-d H:i:s");
	$insertQuery="insert into posts(content, user_id, status, date_time, total_comments, total_likes, post_type) values('$content', '$user_id', 'new', '$current_date', 0, 0, '$post_type')";
	if (!mysql_query($insertQuery,$conn))
	{
	  return 0;
  	}
	else
	{
		$new_postid = mysql_insert_id();
		closeDBConnection($conn);
		return $new_postid;
	}
}

function getPostContent($post_id)
{
	$conn=getDBConnection();$i=0;
	$query=" select p.*, u.first_name,u.picture from posts p join users u on u.id = p.user_id where p.user_id in ($post_id) order by p.date_time DESC ";
	$result = mysql_query($query, $conn) or die(mysql_error());
	$post_content=null;
	while( $row = mysql_fetch_array($result) )
	{
		$post_content[$i][0]  = $row['id'];
        $post_content[$i][1]  = $row['first_name'];
        $post_content[$i][2]  = $row['content'];
		$post_content[$i][3]  = $row['date_time'];
		$post_content[$i][4]  = $row['total_comments'];
		$post_content[$i][5]  = $row['total_likes'];
		$post_content[$i][6]  = $row['picture'];
		$post_content[$i][7]  = $row['post_type'];
		$i++;
    }
	return $post_content;
}

function getUserNameById($user_id)
{
	$conn=getDBConnection();
	$query="select first_name,picture from users where id='$user_id'";
	$result = mysql_query($query, $conn) or die(mysql_error());
	$user_details = null;
	while ($row = mysql_fetch_array($result))
	{
    	$user_details[0]=$row[0];
		$user_details[1]=$row[1];
	}
	return $user_details;
}

function getLikeorUnlike($post_id, $comment_id, $user_id)
{
	$conn=getDBConnection();
	$query="select user_id from likes where post_id='$post_id' and comment_id = '$comment_id'";
	$result = mysql_query($query, $conn) or die(mysql_error());
	$users = null; $i=0;
	while ($row = mysql_fetch_array($result))
	{
    	$users[$i]=$row[0];
		$i++;		
	}
	//return $users;
	if($users == null)
		return 'Like';
	if(in_array($user_id, $users))
		{
			//User had already liked the post
			$like_unlike='Unlike';
		}
		else
		{
			//User has not liked the post 
			$like_unlike='Like';
		}
	return $like_unlike;
}

function setPostLike($post_id, $user_id, $like_count)
{
	$conn=getDBConnection();
	$query = "update posts set total_likes = '$like_count' where id = '$post_id'";
	$retval = mysql_query( $query, $conn );
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error());
	}
	echo "Updated data successfully\n";	
	
	$current_date = date("Y-m-d H:i:s");
	$like_query = "insert into likes(post_id, comment_id, user_id, status, date_time) values ('$post_id', 0, '$user_id', 'new', '$current_date')";
	if (!mysql_query($like_query,$conn))
	{
		die('Could not insert data: ' . mysql_error());
  	}
	else
	{	
		closeDBConnection($conn);
		echo("Data inserted successfully");
	}	
}

function getUserForPost($post_id)
{
	$conn=getDBConnection();
	$sql="select user_id from posts where id = '$post_id'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	return $row['user_id'];
}

function removePostLike($post_id, $user_id, $like_count)
{
	$conn=getDBConnection();
	$query = "update posts set total_likes = '$like_count' where id = '$post_id'";
	$retval = mysql_query( $query, $conn );
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error());
	}
	echo "Updated data successfully\n";	
	
	$unlike_query = "delete from likes where post_id = '$post_id' and user_id = '$user_id'";
	if (!mysql_query($unlike_query,$conn))
	{
		die('Could not delete data: ' . mysql_error());
  	}
	else
	{	
		closeDBConnection($conn);
		echo("Data deleted successfully");
	}
}

function getShowComments($post_id, $user_id)
{
	$conn=getDBConnection();$i=0;
	$query=" select c.*, u.first_name,u.picture from comments c join users u on u.id = c.user_id where c.post_id = '$post_id' order by c.date_time ASC ";
	$result = mysql_query($query, $conn) or die(mysql_error());
	$post_comment=null;
	while( $row = mysql_fetch_array($result) )
	{
		$post_comment[$i][0]  = $row['id'];
        $post_comment[$i][1]  = $row['content'];
        $post_comment[$i][2]  = $row['first_name'];
		$post_comment[$i][3]  = $row['picture'];
		$post_comment[$i][4]  = $row['date_time'];
		$i++;
    }
	return $post_comment;
}

function push_new_comment($post_id, $comment, $user_id, $comment_count)
{
	$conn=getDBConnection();
	$query = "update posts set total_comments = '$comment_count' where id = '$post_id'";
	$retval = mysql_query( $query, $conn );
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error());
	  return 0;
	}
	//echo "Data Updated successfully\n";	
	
	$current_date = date("Y-m-d H:i:s");
	$like_query = "insert into comments(content, post_id, user_id, status, date_time) values ('$comment', '$post_id', '$user_id', 'new', '$current_date')";
	if (!mysql_query($like_query,$conn))
	{
		die('Could not insert data: ' . mysql_error());
		return 0;
  	}
	else
	{	
		$new_commentid = mysql_insert_id();
		closeDBConnection($conn);
		//echo("Data inserted successfully");
		return $new_commentid;
	}
}

function search_new_friends_byletters($user_id,$searchtext)
{
	$conn=getDBConnection();$i=0;
	$query=$searchtext;
	$result = mysql_query($query, $conn) or die(mysql_error());
	$new_friends=null;
	while( $row = mysql_fetch_array($result) )
	{
        $new_friends[$i][0]  = $row['id'];
        $new_friends[$i][1]  = $row['user_name'];
		$new_friends[$i][2]  = $row['first_name'];
		$new_friends[$i][3]  = $row['sur_name'];
		$new_friends[$i][4]  = $row['email_id'];
		$new_friends[$i][5]  = $row['mobile_no'];
		$new_friends[$i][6]  = $row['birth_date'];
		$new_friends[$i][7]  = $row['gender'];
		$new_friends[$i][8]  = $row['status'];
		$new_friends[$i][9]  = $row['date_time'];
		$new_friends[$i][10]  = $row['picture'];
		$i++;
    }
	return $new_friends;
}

function search_existing_friends($user_id)
{
	$conn=getDBConnection();$i=0;
	$query="select * from contacts where parent = '$user_id'";
	$result = mysql_query($query, $conn) or die(mysql_error());
	$ex_friends=null;
	while( $row = mysql_fetch_array($result) )
	{
        $ex_friends[$i][0]  = $row['child'];
        $ex_friends[$i][1]  = $row['status'];
		$ex_friends[$i][2]  = $row['friends_status'];
		$i++;
    }
	return $ex_friends;
}

function add_friend_request($friend_id, $user_id)
{
	$conn=getDBConnection();
	$current_date = date("Y-m-d H:i:s");
	$insertQuery="insert into contacts(parent, child, status, requested_date_time, notify_status, friends_status) values('$friend_id', '$user_id', 'pending', '$current_date', '0', 'N')";
	if (!mysql_query($insertQuery,$conn))
	{
	  return 0;
  	}
	else
	{	
		$insertQuery2="insert into contacts(parent, child, status, requested_date_time,  notify_status, friends_status) values('$user_id', '$friend_id', 'approved', '$current_date', '0', 'N')";
		if (!mysql_query($insertQuery2,$conn))
		{
		  return 0;
		}
		closeDBConnection($conn);
		return 1;
	}
}

function get_addfriends_notification_count($user_id, $last_login, $today_date)
{
	$conn=getDBConnection();
	$sql="SELECT count(*) as count FROM `contacts` WHERE (requested_date_time BETWEEN '$last_login' AND '$today_date') and status = 'pending' and notify_status = 0 and friends_status = 'N' and parent = '$user_id' ";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	closeDBConnection($conn);
	return $row['count'];
}

function remove_friends_notification($user_id, $last_login, $today_date)
{
	$conn=getDBConnection();
	$query = "update contacts set notify_status = '1' where (requested_date_time BETWEEN '$last_login' AND '$today_date') and status = 'pending' and notify_status = 0 and friends_status = 'N' and parent = '$user_id' ";
	$retval = mysql_query( $query, $conn );
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error());
	  return 0;
	}
	closeDBConnection($conn);
	return 1;
}

function get_requested_friends($user_id, $last_login, $today_date)
{
	$conn=getDBConnection();$i=0;
	$query=" select u.* from users u join contacts c on u.id = c.child where c.status = 'pending' and c.parent = '$user_id' order by c.requested_date_time DESC";
	$result = mysql_query($query, $conn) or die(mysql_error());
	$new_friends=null;
	while( $row = mysql_fetch_array($result) )
	{
        $new_friends[$i][0]  = $row['id'];
        $new_friends[$i][1]  = $row['user_name'];
		$new_friends[$i][2]  = $row['first_name'];
		$new_friends[$i][3]  = $row['sur_name'];
		$new_friends[$i][4]  = $row['email_id'];
		$new_friends[$i][5]  = $row['mobile_no'];
		$new_friends[$i][6]  = $row['birth_date'];
		$new_friends[$i][7]  = $row['gender'];
		$new_friends[$i][8]  = $row['status'];
		$new_friends[$i][9]  = $row['date_time'];
		$new_friends[$i][10]  = $row['picture'];
		$i++;
    }
	closeDBConnection($conn);
	return $new_friends;
}

function confirm_friend($user_id, $friend_id)
{
	$current_date = date("Y-m-d H:i:s");
	$conn=getDBConnection();
	$query = "update contacts set status = 'approved', approved_date_time = '$current_date', friends_status = 'Y' where parent = '$user_id' and child = '$friend_id'";
	$retval = mysql_query( $query, $conn );
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error());	 
	}
	$query2 = "update contacts set status = 'approved', approved_date_time = '$current_date', friends_status = 'Y' where parent = '$friend_id' and child = '$user_id'";
	$retval2 = mysql_query( $query2, $conn );
	if(! $retval2 )
	{
	  die('Could not update data: ' . mysql_error());	 
	}
	closeDBConnection($conn);	
}

function delete_friend($user_id, $friend_id)
{
	$conn=getDBConnection();
	$sql = "DELETE  FROM contacts WHERE parent = '$user_id' and child = '$friend_id'";
	if (mysql_query($sql, $conn)) {
		echo "Record deleted successfully";
	} else {
		die ("Error deleting record: " . mysql_error($conn));
	}
	$sql2 = "DELETE  FROM contacts WHERE parent = '$friend_id' and child = '$user_id'";
	if (mysql_query($sql2, $conn)) {
		echo "Record deleted successfully";
	} else {
		die ("Error deleting record: " . mysql_error($conn));
	}
	closeDBConnection($conn);	
}

function setDateTimeForOnline($user_id)
{
	$current_date = date("Y-m-d H:i:s");
	$conn=getDBConnection();
	$query = "update users set online_datetime = '$current_date' where id = '$user_id'";
	$retval = mysql_query( $query, $conn );
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error());	 
	}
	closeDBConnection($conn);	
}

function checkUserAvailableEvents($user_id)
{
	$conn=getDBConnection();
	$sql="select * from events where user_id = '$user_id'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	closeDBConnection($conn);
	$user = null;
	if($row != null)
	{
		$user[0]=$row['id'];
		$user[1]=$row['user_id'];
		$user[2]=$row['last_in'];
		$user[3]=$row['new_events_count'];
		
		return $user;
	}
	else	
		return 0;	
}

function insertUserintoEvents($user_id)
{
	$conn=getDBConnection();
	$current_date = date("Y-m-d H:i:s");
	$query = "insert into events(user_id, last_in, new_events_count) values ('$user_id', '$current_date', '0')";
	if (!mysql_query($query,$conn))
	{
		die('Could not insert data: ' . mysql_error());
		return 0;
  	}
	closeDBConnection($conn);	
}

function updateUserinEvents($user_id)
{
	$current_date = date("Y-m-d H:i:s");
	$conn=getDBConnection();
	$query = "update events set last_in = '$current_date', new_events_count = '0' where user_id = '$user_id'";
	$retval = mysql_query( $query, $conn );
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error());	 
	}
	closeDBConnection($conn);	
}

function increaseNewEventsCount($users)
{	
	$conn=getDBConnection();
	$query = "update events set new_events_count = new_events_count+1 where user_id in ($users)";
	$retval = mysql_query( $query, $conn );
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error());	 
	}
	closeDBConnection($conn);
}

function show_events_foruser($friends)
{
	$conn=getDBConnection(); 
	$sql="SELECT p.date_time as posted_on ,p.id as post , u.id as user ,u.*,p.* from users u, posts p where u.id = p.user_id and p.user_id in ($friends) order by p.date_time DESC ";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$user = null; $i =0;
	while($row = mysql_fetch_array($result))
	{
		$user[$i][0]=$row['user'];
		$user[$i][1]=$row['first_name'];
		$user[$i][2]=$row['posted_on'];
		$user[$i][3]=$row['picture'];
		$user[$i][4]=$row['gender'];
		$user[$i][5]=$row['post'];
		$i++;
	}	
		closeDBConnection($conn);
		return $user;
}

function getLikesbyFriendsForUserPost($user_id, $last_login_date_time)
{
	$conn=getDBConnection(); 	
	$current_date = date("Y-m-d H:i:s");
	$sql=" select l.date_time as liked_on,l.post_id ,u.* from users u join likes l on u.id = l.user_id where l.post_id in(select id from posts where user_id = '$user_id') and l.date_time between '$last_login_date_time' and '$current_date' ";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$user = null; $i =0;
	while($row = mysql_fetch_array($result))
	{
		$user[$i][0]=$row['id'];
		$user[$i][1]=$row['first_name'];
		$user[$i][2]=$row['liked_on'];
		$user[$i][3]=$row['picture'];
		$user[$i][4]=$row['gender'];
		$user[$i][5]=$row['post_id'];
		$i++;
	}
	closeDBConnection($conn);
	return $user;
}

function getPostDetails($post_id)
{
	$conn = getDBConnection();
	$sql = "SELECT u.*,p.* FROM users u join posts p on u.id = p.user_id WHERE p.id = '$post_id' ";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$post = null;
	while($row = mysql_fetch_array($result))
	{
		$post[0]  = $row['id'];
        $post[1]  = $row['first_name'];
        $post[2]  = $row['content'];
		$post[3]  = $row['date_time'];
		$post[4]  = $row['total_comments'];
		$post[5]  = $row['total_likes'];
		$post[6]  = $row['picture'];
	}
	closeDBConnection($conn);
	return $post;
}

function storePushNotificationId($reg_id, $user_id)
{
	$conn=getDBConnection();
	$query = "update users set push_notify_id = '$reg_id' where id in ($user_id)";
	$retval = mysql_query( $query, $conn );
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error());	 
	}
	closeDBConnection($conn);
}

function logoutUser()
{
	session_start();
	session_unset();
	session_destroy();
}

?>