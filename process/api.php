<?php		
	//print_r(phpinfo());die;
	date_default_timezone_set('UTC');
	session_start();
	require_once("Rest.inc.php");
	include 'camfoxconfig.php';
	include 'dbOperations.php';
	//include 'message.php';
	
	class API extends REST {		
	
		public function processApi(){
			
			$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));			
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);				
				
			/*$func = trim(str_replace("/","",$_SERVER['REQUEST_URI']));
			$func = trim(str_replace("restcomicapp","",$func));
			$func = trim(explode("?",$func)[0]);*/
	
		}
		
		
		public function register(){		
			require 'camfoxconfig.php';
				$username = $_REQUEST['uname'];		
				$firstname = $_REQUEST['fname'];
				$surname = $_REQUEST['sname'];
				$email = $_REQUEST['email'];
				$mobileNo = $_REQUEST['mobno'];
				$password = $_REQUEST['password'];
				//$birth_date = $_REQUEST['b_date'];
				$gender = $_REQUEST['gender'];
				$year = $_REQUEST['year'];
				$month = $_REQUEST['month'];
				$day = $_REQUEST['day'];
				$birth_date = $year.'-'.$month.'-'.$day;
				
				$result = signup($username, $firstname, $surname, $email, $mobileNo, $password, $birth_date, $gender);
				if($result)
				{						
					$this->http_response(1,200);
				}
				else
					{					
					$this->http_response(0,200);
				}
				
		}
		
		public function login()
		{
			require 'camfoxconfig.php';
				$username = $_REQUEST['username'];		
				$password = $_REQUEST['userpassword'];
				
					$id=isUser($username,$password);
					
				if($id>0)
				{
					$last_login = get_last_login($id);
					
					$_SESSION['user_id'] = $id;
					//$_SESSION['last_login'] = $last_login;
					
					update_last_login_date($id);
					
					$user = checkUserAvailableEvents($_SESSION['user_id']);
					if($user == 0)
					{
						insertUserintoEvents($_SESSION['user_id']);
					}
					else{
						updateUserinEvents($_SESSION['user_id']);
					}
					
					$_SESSION['new_event_count'] = $user[3];
					$_SESSION['last_login'] = $user[2];
					
					/* $email_id=getUserEmailById($id);
					//echo $email_id;
					
					$_SESSION['email_id'] = $email_id;
					$_SESSION['user_id'] = $id;
					$username =  $_SESSION['email_id'];
					/* if(in_array($email_id,$hr_email))
						header("Location:hr_panel.php");	
					else
						header("Location:home.php"); */
						
					/*	$pending_requests=get_my_pending_requests($_SESSION['email_id']);
						
						if((isset($_SESSION['first_time']) && $_SESSION['first_time'] =='yes') || $pending_requests == null || !is_approver($_SESSION['email_id']))
						{
							$status=0;
						}
						else
						{
							$status=1;
							$_SESSION['first_time']='yes';
						}
						
						if(in_array($email_id,$hr_email))
							$this->http_response(2,200);
						else
							$this->http_response(1,200);
						 */
						$this->http_response($id,200);
				}
				else
				{
					$message="Incorrect Credentials";
					$username=$_POST['username'];
					$password=$_POST['password'];
					// header("Location:index.php?error=$message&username=$username&password=$password");
					
					$this->http_response(0,200);
				}
				
		}

		public function checkUserSession()
		{
			if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
			{	
				$user = checkUserAvailableEvents($_SESSION['user_id']);
				if($user == 0)
				{
					insertUserintoEvents($_SESSION['user_id']);
				}
				else{
					updateUserinEvents($_SESSION['user_id']);
				}
				$_SESSION['new_event_count'] = $user[3];
				$_SESSION['last_login'] = $user[2];
				$this->http_response(0,200);
			}
			else{
				$this->http_response(1,200);}
		}
		
		public function userProfile()
		{
			if(isset($_SESSION['user_id']))
			$user_id = $_SESSION['user_id'];
			else
			$user_id = 0;
			$userdetails = getUserNameById($user_id);
			if($userdetails[1] != null)
			{
				$result = "";
				$result.= '<img class="ui-li-thumb" src="'.$userdetails[1].'">';
				$this->http_response($result,200);
			}
			else
			{
				$result = "";
				$result.= '<img class="ui-li-thumb" src="images/profile_pic.jpg">';
				$this->http_response($result,200);
			}
		}
		
		public function setDateTimeForEveryMinute()
		{	
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
			setDateTimeForOnline($user_id);
			$this->http_response(1,200);
		}
		
		public function getFriends()
		{
			if(isset($_SESSION['user_id']))
			$user_id = $_SESSION['user_id'];
			else
			$user_id = 0;
			$friends = getFriendsList($user_id);
			$current_datetime = date("Y-m-d H:i:s");
			$todaydatetime = strtotime($current_datetime);
			if($friends != null)
			{
				$result = "";
				$result = '<ul class="ui-listview" data-role="listview">';
				foreach($friends as $value)
				{
					//$result.= '<li><a href=" ">'.$value[$i].'</a></li>';
					$result.= '<li class="ui-btn ui-li-has-arrow ui-li ui-li-has-thumb ui-btn-up-c" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c">';
					$result.= '<div class="ui-btn-inner ui-li">';
					$result.= '<div class="ui-btn-text">';
					$result.= '<a class="ui-link-inherit" href="#">';
					if($value[10] != null)
						$result.= '<img class="ui-li-thumb" src="'.$value[10].'" style="height:3em; width:3em">';
					else
						$result.= '<img class="ui-li-thumb" src="images/profile_pic.jpg" style="height:3em; width:3em">';
					$result.= '<p class="ui-li-desc">'.$value[2].'</p>';
					$usersonlie_time = strtotime($value[11]);
					$usersonlie_time = $todaydatetime - $usersonlie_time;
					if($usersonlie_time > 60)
						$result.= '<div class="online_circle" > </div>';
					else	
						$result.= '<div class="online_circle" style="background-color: #308014;" > </div>';
					$result.= '</a></div> </div> </li>';
				}	
				$result.='</ul>';				
				$this->http_response($result,200);				
			}
			else
			{
				$this->http_response(0,200);
			}			
		}
		private function getFriendsids($friendslist)
		{
			$friends = "";
			if($friendslist != null)
			{
				for($i=0; $i<count($friendslist); $i++ )
				{
					$friends.= $friendslist[$i][0];
					if($i == (count($friendslist)-1))
						$friends.=" ";
					else
						$friends.=",";
				}
			}
			return $friends;
		}
		
		public function new_post()
		{
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
			
			$post_content = $_POST['post'];
			$post_id = newPost($post_content, $user_id);
			
			$friendslist = getFriendsList($user_id);
			$friends = $this->getFriendsids($friendslist);
			
			increaseNewEventsCount($friends);
			
			$user_details = getUserNameById($user_id);
			$result = "";
			if($post_id != 0)
			{
				$result.= '<div  class="post_wrap"><a id="'.$post_id.'" onClick="show_post_detail(this)">';
					$result.= '<div class="post_wrap_author_profile_picture">';
						if($user_details[1] != null)
							{$result.= '<img src="'.$user_details[1].'" style="width: 100%;max-height: 30px; " />';}
						else{
							$result.= '<img src="images/profile_pic.jpg" />';}
					$result.= '</div>';
					$result.= '<div class="post_details"> ';
						$result.= '<div class="post_author"> '.$user_details[0].' </div>';
						if(strlen($post_content) > 15)
							$result.= '<div class="post_text"> '.substr($post_content,0,10).'...<a id="'.$post_id.'" style="font-size: 11px; color: #197700 !important;  margin: -17px 6px -2px 17px;" name="'.$post_id.'_readmore" onclick="show_post_detail(this) ">Read More </a></div>';
						else
							$result.= '<div class="post_text"> '.$post_content.' </div>';
					$result.= '</div>';
				$result.= '</a></div> ';
				$result.= ' <div class="comments_wrap">';
					$result.= '<span> <span><img src="images/like.png" /></span>';
					$result.= '<span class="post_feedback_like_unlike" id=""  onclick=""> Like</span>';		
        			$result.= ' <span class="post_feedback_count" id=""> 0</span></span>';  
					$result.= '<span><span class="post_feedback_comment"> <img src="images/comment.png" /> Comment</span>';
                    $result.= '<span class="post_feedback_count" id=""> 0</span></span>';
					$result.= '<span class="post_timestamp">  </span> ';
					$result.= ' <div class="comment" id=" ">';
						if($user_details[1] != null)
							{ $result.= '<div class="comment_author_profile_picture"> <img src="'.$user_details[1].'" /></div>';}
						else{
							$result.= '<div class="comment_author_profile_picture"> <img src="images/profile_pic.jpg" /></div>';}								
        				$result.= '<div class="comment_text">';
						$result.= '<textarea placeholder="Write a comment..." id="" onKeyPress="" ></textarea>';
       		   	$result.= '</div></div></div>';
			}
			$this->http_response($result,200);
		}
		
		public function show_post_content()
		{
			$result = "";
			if(isset($_SESSION['user_id']))
			$user_id = $_SESSION['user_id'];
			else
			$user_id = 0;
			$timezone = $_POST['timezone'];
			$friends = getFriendsList($user_id);
			$user_details = getUserNameById($user_id);
			$post_ids = "";			
			if($friends != null)
			{
				foreach($friends as $value)
				{
					$post_ids.= $value[0];
					$post_ids.=",";
				}
			}
			$post_ids.= $user_id;
			$post_content = getPostContent($post_ids);
			
			if($post_content != null)
			{
				foreach($post_content as $post){
					$result.= '<div  class="post_wrap"><a id="'.$post[0].'" onClick="show_post_detail(this)">';
						$result.= '<div class="post_wrap_author_profile_picture">';
							if($post[6] != null)
								{$result.= '<img src="'.$post[6].'" style="width: 100%;max-height: 30px;" />';}
							else{
								$result.= '<img src="images/profile_pic.jpg" />';}
						$result.= '</div>';
						
						$tz = $_POST['timezone'];						
						$tz = new DateTimeZone($tz);
						$date = new DateTime($post[3]);
						$date->setTimezone($tz);
						
						$result.= '<div class="post_details"> ';
							$result.= '<div class="post_author"> '.$post[1].'<span class="post_timestamp" id="comment_date"> '.$this->date_format($date->format('Y-m-d H:i:s'),$tz).' ago</span>  </div>';
							if(strlen($post[2]) > 15)
								$result.= '<div class="post_text"> '.substr($post[2],0,10).'...<a id="'.$post[0].'" style="font-size: 11px; color: #197700 !important;  margin: -17px 6px -2px 5px;" name="'.$post[0].'_readmore" onclick="show_post_detail(this) ">Read More </a></div>';
							else
								$result.= '<div class="post_text"> '.$post[2].' </div>';
						$result.= '</div>';
					$result.= '</a></div> ';
					
					$result.= ' <div class="comments_wrap">';
						$result.= '<span> <span><img src="images/like.png" /></span>';						
						$result.= '<span class="post_feedback_like_unlike" id="'.$post[0].'_like_'.$post[5].'"  onclick="post_like(this,'.$user_id.')">'.getLikeorUnlike($post[0], 0, $user_id).'</span>';		
						$result.= ' <span class="post_feedback_count" id="'.$post[0].'_like_count"> '.$post[5].'</span></span>';  
						
						$result.= '<span><span class="post_feedback_comment" onclick="show_comments('.$post[0].','.$user_id.')"> <img src="images/comment.png" /> Comment</span>';
						$result.= '<span class="post_feedback_count" id="'.$post[0].'_comment_count"> '.$post[4].'</span></span>';
						
						$result.=	'<div class="comment" id="'.$post[0].'_comment" >';
						$result.=	'</div>';
						
						$result.= ' <div class="comment" id="'.$post[0].'_self_comment">';
						if($user_details[1] != null)
							{ $result.= '<div class="comment_author_profile_picture"> <img src="'.$user_details[1].'" /></div>';}
						else{
							$result.= '<div class="comment_author_profile_picture"> <img src="images/profile_pic.jpg" /></div>';}			
							
							$result.= '<div class="comment_text">';
							$result.= '<textarea placeholder="Write a comment..." id="'.$post[0].'_comment_text_box" onKeyPress="return new_comment(this,event,'.$user_id.')" ></textarea>';
					$result.= '</div></div></div>';
				}
			}
			$this->http_response($result,200);
		}
		
		public function post_like()
		{
			$post_id = $_POST['post_id'];
			$user_id = $_POST['user_id'];
			$like_count = $_POST['count'];
			setPostLike($post_id, $user_id, $like_count);
			$posted_user = getUserForPost($post_id);
			increaseNewEventsCount($posted_user);
			//addLikeCountEvents
		}
		
		public function post_unlike()
		{
			$post_id = $_POST['post_id'];
			$user_id = $_POST['user_id'];
			$like_count = $_POST['count'];
			removePostLike($post_id, $user_id, $like_count);
		}
		
		public function show_comments()
		{
			$post_id = $_POST['post_id'];
			$user_id = $_POST['user_id'];
			$timezone = $_POST['timezone'];
			$post_comments = getShowComments($post_id, $user_id);
			$result = "";
			if($post_comments != null){
				foreach ($post_comments as $comment){
					$result.=	'<div class="comment" id="'.$comment[0].'">';
						   
						$result.=	'<div class="comment_author_profile_picture">';
						if($comment[3]!= null)
							$result.=	'<img src="'.$comment[3].'"/>';
						else
							$result.=	'<img src="images/profile_pic.jpg"/>';
						$result.=	'</div>';
						$result.=	'<div class="comment_details">';
							$tz = $_POST['timezone'];
							$tz = new DateTimeZone($tz);
							$date = new DateTime($comment[4]);
							$date->setTimezone($tz);
							
							$result.=	'<div class="comment_author" > <span class="post_timestamp" id="comment_date"> '.$this->date_format($date->format('Y-m-d H:i:s'),$tz).' ago</span> ';
								$result.=	$comment[2];
							$result.=	'</div>';
								
							$result.=	'<div class="comment_text" >';
								$result.=	$comment[1];
							$result.=	'</div>';
						$result.=	'</div>';
					$result.=   '</div>';
				}
			}
			$this->http_response($result,200);			
		}
		
		public function new_comment()
		{
			$result = "";
			$post_id = $_POST['post_id'];
			$user_id = $_POST['user_id'];			
			$comment_text = $_POST['comment_text'];
			$comment_count = $_POST['count'];
			$user_details = getUserNameById($user_id);
			$comment_id = push_new_comment($post_id, $comment_text, $user_id, $comment_count);
			if($comment_id != 0) {
			$result.=	'<div class="comment" id="'.$comment_id.'">';
        		$result.=	'<div class="comment_author_profile_picture">';
				if($user_details[1]!= null)
					$result.=	'<img src="'.$user_details[1].'"/>';
				else
					$result.=	'<img src="images/profile_pic.jpg"/>';
        		$result.=	'</div>';
			     $result.=	'<div class="comment_details">';
                    $result.=	'<div class="comment_author" >';
			             $result.=	$user_details[0];
			         $result.=	'</div>';
			         $result.=	'<div class="comment_text" >';
			              $result.=	$comment_text;
			         $result.=	'</div>';
			     $result.=	'</div>';
			$result.=	'</div>';
			}
			$this->http_response($result,200);
		}

		private function date_format($time, $timezone)
		{			
			$time = strtotime($time);			
			$date = new DateTime();
			$date->setTimezone($timezone);
			$today_date = $date->format('Y-m-d H:i:s');
			$todaydatetime = strtotime($today_date);
			
			$time = $todaydatetime - $time; // to get the time since that moment					
			$time = ($time<1)? 1 : $time;
			$tokens = array (
				31536000 => 'year',
				2592000 => 'month',
				604800 => 'week',
				86400 => 'day',
				3600 => 'hour',
				60 => 'minute',
				1 => 'second'
			);

			foreach ($tokens as $unit => $text) {
				if ($time < $unit) continue;
				$numberOfUnits = floor($time / $unit);
				return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
			}
		}
		
		public function search_friends_byletters()
		{
			//$searchtext = $_POST['searchvalue'];
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
			$searchvalue="";
			$searchtext="";
			if(isset($_POST['mobile'])){
				$searchvalue = $_POST['mobile'];
				$searchtext = " select * from users where mobile_no like '%$searchvalue%' and id not in ($user_id) order by id ";
			}
			else if(isset($_POST['email'])){
				$searchvalue = $_POST['email'];
				$searchtext = " select * from users where email_id like '%$searchvalue%' and id not in ($user_id) order by id ";
			}				
			else{
				$searchvalue = $_POST['text'];
				$searchtext = " select * from users where first_name like '%$searchvalue%' and id not in ($user_id) order by id ";
			}
				
			$new_friends_list = search_new_friends_byletters($user_id,$searchtext);
			$ex_friends_list = search_existing_friends($user_id);
			$friends_ids = array();
			foreach($ex_friends_list as $ex_value)
			{
				array_push($friends_ids, $ex_value[0]);
			}
			if($new_friends_list != null)
			{				
				$result = "";
				$result = '<ul class="ui-listview" data-role="listview">';
				foreach($new_friends_list as $value)
				{
					//$result.= '<li><a href=" ">'.$value[$i].'</a></li>';
					$result.= '<li id="'.$value[0].'_friends_li_item" class="ui-btn  ui-li-has-arrow ui-li ui-li-has-thumb ui-btn-up-c" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c">';
					$result.= '<div class="ui-btn-inner ui-li">';
					$result.= '<div class="ui-btn-text">';
					$result.= '<a class="ui-link-inherit" href="#">';
					if($value[10] != null)
					$result.= '<img class="ui-li-thumb" src="'.$value[10].'" style="width:3em; height:3em;">';
					else
					$result.=	'<img class="ui-li-thumb" src="images/profile_pic.jpg" style="width:3em; height:3em;"/>';
					$result.= '<p class="ui-li-desc">'.$value[2].'</p>';
					if (is_array($ex_friends_list) || is_object($ex_friends_list))
					{
						foreach($ex_friends_list as $ex_value)
						{
							
							if($value[0] == $ex_value[0] && $ex_value[1] == "approved" && $ex_value[2] == "N"){
								$result.= '<span id="'.$value[0].'_replace_addfriend" ><p style= "margin: -31px 9px -6px 160px; color: #808080;">Friend Request Sent</p> </span>';
								}
							
							else if($value[0] == $ex_value[0] && $ex_value[1] == "approved" && $ex_value[2] == "Y"){
								$result.= '<span id="'.$value[0].'_replace_addfriend" ><p style= "margin: -31px 9px -6px 180px; color: #0000ff;">Friends</p> </span>';
								}
							
							else if($value[0] == $ex_value[0] && $ex_value[1] == "pending" && $ex_value[2] == "N"){
								$result.= '<span id="'.$value[0].'_confirm_friend" ><input type="button" id="'.$value[0].'" onClick="" name="'.$value[0].'_addfriend" value="confirm" style="background-color: #197700 !important;  border-radius: 0.00125em; color: #ddd !important; border-style: solid; margin: -62px 9px 7px 156px; font-size: 12px;" > </input> </span>';
								$result.= '<span id="'.$value[0].'_notnow_friend" ><input type="button" id="'.$value[0].'" onClick="" name="'.$value[0].'_addfriend" value="Delete" style="background-color: #808262 !important;  border-radius: 0.00125em; color: #ddd !important; border-style: solid; margin: -49px 10px -6px -8px;font-size: 12px; " > </input> </span>';
								}							
								
							else if(!in_array($value[0], $friends_ids)){
								$result.= '<span id="'.$value[0].'_replace_addfriend" ><input type="button" id="'.$value[0].'" onClick="return add_new_friend(this)" name="'.$value[0].'_addfriend" value="Add friend" style="background-color: #197700 !important; font-size: 12px; border-radius: 0.00125em; color: #ddd !important; border-style: solid; margin: -52px 9px -6px 180px;" > </input> </span>';
								break;}
						}
					}
					else
					{
						$result.= '<span id="'.$value[0].'_replace_addfriend" ><input type="button" id="'.$value[0].'" onClick="return add_new_friend(this)" name="'.$value[0].'_addfriend" value="Add friend" style="background-color: #197700 !important; font-size: 12px;  border-radius: 0.00125em; color: #ddd !important; border-style: solid; margin: -52px 9px -6px 180px;" > </input> </span>';
					}
					$result.= '</a></div> </div> </li>';
				}	
				$result.='</ul>';
				//$result = json_encode($result);
				$this->http_response($result,200);
				
			}
			else
			{
				$this->http_response(0,200);
			}
		}
		
		public function send_friend_request()
		{
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
			$friend_id = $_POST['value'];
			$status = add_friend_request($friend_id, $user_id);
			//show_requests_to_user();
			$this->http_response($status,200);
		}
		
		public function show_addfriends_notification()
		{
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
				
			if(isset($_SESSION['last_login']))
				$last_login = $_SESSION['last_login'];
			else
				$last_login = 0;
				
			$today_date = date("Y-m-d H:i:s");			
			$friend_request_count = get_addfriends_notification_count($user_id, $last_login, $today_date);
			if($friend_request_count > 0 )
				$result = '<div class="circle" > '.$friend_request_count.' </div>';
			
			else
				$result = "";		
			
			$this->http_response($result, 200);
		}
		
		public function show_events_notification()
		{
			if(isset($_SESSION['new_event_count']) && $_SESSION['new_event_count'] != 0){
				$events = $_SESSION['new_event_count'];
				$result = '<div class="circle" > '.$events.' </div>';
				}
			else
			{
				$events = 0;
				$result="";
			}			
			$this->http_response($result, 200);		
		}
		
		public function remove_addfriends_notification()
		{
			$result = "";
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
				
			if(isset($_SESSION['last_login']))
				$last_login = $_SESSION['last_login'];
			else
				$last_login = 0;
				
			$today_date = date("Y-m-d H:i:s");	
			$result = remove_friends_notification($user_id, $last_login, $today_date);
			if($result == 1)
				$result = "";
				
			$this->http_response($result, 200);	
		}
		
		public function remove_events_notification()
		{
			if(isset($_SESSION['new_event_count']) && $_SESSION['new_event_count'] != 0){
				$_SESSION['new_event_count'] = 0;
				$result = "";
				}
			else
			{				
				$result="";
			}			
			$this->http_response($result, 200);		
		}
		
		public function show_requested_friends()
		{
			$result = "";
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
				
			if(isset($_SESSION['last_login']))
				$last_login = $_SESSION['last_login'];
			else
				$last_login = 0;
				
			$today_date = date("Y-m-d H:i:s");			
			$requested_list = get_requested_friends($user_id, $last_login, $today_date);
			if($requested_list != null )
			{
				$result = '<ul class="ui-listview" data-role="listview">';
				foreach($requested_list as $value)
				{
					//$result.= '<li><a href=" ">'.$value[$i].'</a></li>';
					$result.= '<li id="'.$value[0].'_friends_li_item" class="ui-btn  ui-li-has-arrow ui-li ui-li-has-thumb ui-btn-up-c" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c">';
					$result.= '<div class="ui-btn-inner ui-li">';
					$result.= '<div class="ui-btn-text">';
					$result.= '<a class="ui-link-inherit" href="#">';
					if($value[10] != null)
					$result.= '<img class="ui-li-thumb" src="'.$value[10].'" style="width:3em; height:3em;">';
					else
					$result.=	'<img class="ui-li-thumb" src="images/profile_pic.jpg" style="width:3em; height:3em;"/>';
					$result.= '<p class="ui-li-desc">'.$value[2].'</p>';
					$result.= '<span id="'.$value[0].'_confirm_friend" ><input type="button" id="'.$value[0].'" onClick="return confirm_friend_request(this)" name="'.$value[0].'_addfriend" value="confirm" style="background-color: #197700 !important;  border-radius: 0.00125em; color: #ddd !important; border-style: solid; margin: -62px 9px 7px 156px; font-size: 12px;" > </input> </span>';
					$result.= '<span id="'.$value[0].'_notnow_friend" ><input type="button" id="'.$value[0].'" onClick="return delete_friend_request(this)" name="'.$value[0].'_addfriend" value="Delete" style="background-color: #808262 !important;  border-radius: 0.00125em; color: #ddd !important; border-style: solid; margin: -49px 10px -6px -8px; font-size: 12px; " > </input> </span>';
					$result.= '</a></div> </div> </li>';
				}	
				$result.='</ul>';				
			}
			else
				$result = "";		
			
			$this->http_response($result, 200);	
		}
		
		public function show_events()
		{
			$result = "";
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
			
			if(isset($_SESSION['last_login']))
				$last_login = $_SESSION['last_login'];
			else
				$last_login = 0;
			$likes_byfriends = getLikesbyFriendsForUserPost($user_id,$last_login);	
			
			$friendslist = getFriendsList($user_id);
			$friends = $this->getFriendsids($friendslist);
			
			$requested_list = show_events_foruser($friends);//for new post added by friends
			
			$result = '<ul class="ui-listview" data-role="listview">';
			if($likes_byfriends != null)
			{	
				foreach($likes_byfriends as $list)
				{
					$result.= '<li id="'.$list[0].'_'.$list[5].'_liked_user" style="border-style:none" class="ui-btn  ui-li-has-arrow ui-li ui-li-has-thumb ui-btn-up-c" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c">';
					$result.= '<div class="ui-btn-inner ui-li">';
					$result.= '<div class="ui-btn-text">';
					$result.= '<a class="ui-link-inherit" href="#" id="'.$list[5].'" onclick="show_post_detail(this) ">';
					if($list[3] != null)
						$result.= '<img class="ui-li-thumb" src="'.$list[3].'" style="width:3em; height:2em;">';
					else
						$result.=	'<img class="ui-li-thumb" src="images/profile_pic.jpg" style="width:3em; height:2em;"/>';
					if($list[4] == 'female')
						$result.= '<p class="ui-li-desc"><span style="font-weight:900; color:#333; font-size:1.2em">'.$list[1].'</span> liked your post</p>';
					else	
						$result.= '<p class="ui-li-desc"><span style="font-weight:900; color:#333; font-size:1.2em">'.$list[1].'</span> liked your post</p>';
					
					$tz = $_POST['timezone'];						
					$tz = new DateTimeZone($tz);
					$date = new DateTime($list[2]);
					$date->setTimezone($tz);
					
					$result.= '<span class="event_changed" id="comment_date"> '.$this->date_format($date->format('Y-m-d H:i:s'),$tz).' ago</span> ';
						
					$result.= '</a></div> </div> </li>';
				}					
			}
			if($requested_list != null )
			{
				
				foreach($requested_list as $value)
				{					
					$result.= '<li id="'.$value[0].'_friends_li_item" style="border-style:none" class="ui-btn  ui-li-has-arrow ui-li ui-li-has-thumb ui-btn-up-c" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c">';
					$result.= '<div class="ui-btn-inner ui-li">';
					$result.= '<div class="ui-btn-text">';
					$result.= '<a class="ui-link-inherit" href="#" id="'.$value[5].'" onclick="show_post_detail(this) " >';
					if($value[3] != null)
						$result.= '<img class="ui-li-thumb" src="'.$value[3].'" style="width:3em; height:2em;">';
					else
						$result.=	'<img class="ui-li-thumb" src="images/profile_pic.jpg" style="width:3em; height:2em;"/>';
					if($value[4] == 'female')
						$result.= '<p class="ui-li-desc"><span style="font-weight:900; color:#333; font-size:1.2em">'.$value[1].'</span> updated her states</p>';
					else	
						$result.= '<p class="ui-li-desc"><span style="font-weight:900; color:#333; font-size:1.2em">'.$value[1].'</span> updated his states</p>';
					
					$tz = $_POST['timezone'];						
					$tz = new DateTimeZone($tz);
					$date = new DateTime($value[2]);
					$date->setTimezone($tz);
					
					$result.= '<span class="event_changed" id="comment_date"> '.$this->date_format($date->format('Y-m-d H:i:s'),$tz).' ago</span> ';
						
					$result.= '</a></div> </div> </li>';
				}				
			}
			$result.='</ul>';
			$this->http_response($result, 200);	
		}
		
		public function confirm_friend_request()
		{
			$result = "";
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
			$friend_id = $_POST["id"];
			confirm_friend($user_id, $friend_id);
			$result.= '<p style= "margin: -31px 9px -6px 180px; color: #0000ff;">Friends</p>';
			$this->http_response($result, 200);	
		}
		
		public function delete_friend_request()
		{
			$result = "";
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
			$friend_id = $_POST["id"];	
			delete_friend($user_id, $friend_id);
			$this->http_response($result, 200);
		}
		
		public function show_post_detail()
		{
			$result = "";
			if(isset($_SESSION['user_id']))
				$user_id = $_SESSION['user_id'];
			else
				$user_id = 0;
			$post_id = $_POST["id"];
			$user_details = getUserNameById($user_id);
			$post_details = getPostDetails($post_id);
			$post_comments = getShowComments($post_id, $user_id);
			$result = "";
			if($post_details != null)
			{
				$result.= '<div class="post_wrap" id="'.$post_details[0].'">';
						$result.= '<div class="post_wrap_author_profile_picture">';
							if($post_details[6] != null)
								{$result.= '<img src="'.$post_details[6].'" style="width: 100%;max-height: 30px;" />';}
							else{
								$result.= '<img src="images/profile_pic.jpg" />';}
						$result.= '</div>';
						$result.= '<div class="post_details"> ';
								$tz = $_POST['timezone'];						
								$tz = new DateTimeZone($tz);
								$date = new DateTime($post_details[3]);
								$date->setTimezone($tz);
						
							$result.= '<div class="post_author"> '.$post_details[1].' <span class="post_timestamp" id="comment_date"> '.$this->date_format($date->format('Y-m-d H:i:s'),$tz).' ago</span> </div>';
							
							$result.= '<div class="post_text"> <span style="word-wrap: break-word;">'.$post_details[2].' </span></div>';
						$result.= '</div>';
					$result.= '</div> ';
					
					$result.= ' <div class="comments_wrap" style="width: 100%">';
						$result.= '<span> <span><img src="images/like.png" /></span>';						
						$result.= '<span class="post_feedback_like_unlike" id="'.$post_details[0].'_like_'.$post_details[5].'"  onclick="post_like(this,'.$user_id.')">'.getLikeorUnlike($post_details[0], 0, $user_id).'</span>';		
						$result.= ' <span class="post_feedback_count" id="'.$post_details[0].'_like_count"> '.$post_details[5].'</span></span>';  
						
						$result.= '<span><span class="post_feedback_comment" onclick="show_comments('.$post_details[0].','.$user_id.')"> <img src="images/comment.png" /> Comment</span>';
						$result.= '<span class="post_feedback_count" id="'.$post_details[0].'_post_comment_count"> '.$post_details[4].'</span></span>';
						
						$result.=	'<div class="comment" id="'.$post_details[0].'_comment" >';
						$result.=	'</div>';
						
						$result.= ' <div class="comment" id="'.$post_details[0].'_post_self_comment">';
						if($user_details[1] != null)
							{ $result.= '<div class="comment_author_profile_picture"> <img src="'.$user_details[1].'" /></div>';}
						else{
							$result.= '<div class="comment_author_profile_picture"> <img src="images/profile_pic.jpg" /></div>';}			
							
							$result.= '<div class="comment_text">';
							$result.= '<textarea placeholder="Write a comment..." id="'.$post_details[0].'_comment_full_text_box" onKeyPress="return new_comment_forpost(this,event,'.$user_id.')" ></textarea>';
					$result.= '</div></div></div>';
			}
			if($post_comments != null){
				foreach ($post_comments as $comment){
					$result.=	'<div class="comment" id="'.$comment[0].'">';
						   
						$result.=	'<div class="comment_author_profile_picture">';
						if($comment[3]!= null)
							$result.=	'<img src="'.$comment[3].'"/>';
						else
							$result.=	'<img src="images/profile_pic.jpg"/>';
						$result.=	'</div>';
						$result.=	'<div class="comment_details">';
								
							$tz = $_POST['timezone'];
							$tz = new DateTimeZone($tz);
							$date = new DateTime($comment[4]);
							$date->setTimezone($tz);
							
							$result.=	'<div class="comment_author" > <span class="post_timestamp" id="comment_date"> '.$this->date_format($date->format('Y-m-d H:i:s'),$tz).' ago</span>';
								$result.=	$comment[2];
							$result.=	'</div>';
							
							$result.=	'<div class="comment_text"  style= "word-wrap: break-word;">';
								$result.=	$comment[1];
							$result.=	'</div>';	
						$result.=	'</div>';
					$result.=   '</div>';
				}
			}
			$this->http_response($result, 200);
		}
		
		public function logout()
		{
			//logoutUser();
			session_unset();
			session_destroy();
			$this->http_response(1,200);
		}
		
	}
	$api = new API;
	$api->processApi();
?>
