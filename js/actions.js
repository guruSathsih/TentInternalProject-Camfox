
function getBaseURL() {
    var url = location.href;  // entire url including querystring - also: window.location.href;
    var baseURL = url.substring(0, url.indexOf('/', 14));

    if (baseURL.indexOf('http://localhost') != -1) {
        // Base Url for localhost
        var url = location.href;  // window.location.href;
        var pathname = location.pathname;  // window.location.pathname;
        var index1 = url.indexOf(pathname);
        var index2 = url.indexOf("/", index1 + 1);
        var baseLocalUrl = url.substr(0, index2);
      return baseLocalUrl + "/";
    }    
    else {        
		return "http://creatustent.com/camfox/";
    }
}

function getTimeZoneG() {
    //return /\((.*)\)/.exec(new Date().toString())[1];
	var zone = jstz.determine();
	return zone.name();
}

function getTimezone()
{
	var visitortime = new Date();
	var visitortimezone = "GMT " + -visitortime.getTimezoneOffset()/60;
	/*$.ajax({
		type: "GET",
		url: "http://domain.com/timezone.php",
		data: 'time='+ visitortimezone,
		success: function(){
			location.reload();
		}
	}); */
	return visitortimezone;
}

function to_search(e)
{
	window.location.href= 'http://localhost/camfoxgit/home.html#search_new_friends';
}

function search_friends(e) {
	var searchtb = document.getElementById("search-new-friends");	
    if (e.keyCode == 13) {        
        //alert(searchtb.value);
		searchtb = searchtb.value;
		var mobile = ""; var email = ""; var text = "";
		 var phoneno = /^\d{10}$/;  
		 var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
		  if(searchtb.match(phoneno))  
		  {  
			 // mobile = searchtb;  
			  $.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=search_friends_byletters",	
				data: {mobile : searchtb},				
				success:function(responseText){
						//alert(responseText);
						if(responseText != 0)
						{													
							document.getElementById("new_friends_list").innerHTML=responseText;
						}						
						else {
							alert("No results found...");							
						}
				}			
			});
		  }  
		  else if(searchtb.match(mailformat)){
			 email = searchtb;
			 $.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=search_friends_byletters",	
				data: {email : searchtb},				
				success:function(responseText){
						//alert(responseText);
						if(responseText != 0)
						{													
							document.getElementById("new_friends_list").innerHTML=responseText;
						}						
						else {
							alert("No results found...");							
						}
				}			
			});
		  }
		  else
		  {
			$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=search_friends_byletters",	
				data: {text : searchtb},				
				success:function(responseText){
						//alert(responseText);
						if(responseText != 0)
						{													
							document.getElementById("new_friends_list").innerHTML=responseText;
						}						
						else {
							alert("No results found...");							
						}
				}			
			});
		  }		
        return false;
    }	
}

function add_new_friend(add_friend_btn)
{
	var friend_id = add_friend_btn.id;
	//alert(friend_id);
	if(friend_id == 0)
		return false;
	$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=send_friend_request",	
				data: {value : friend_id},				
				success:function(responseText){
						alert(responseText);
						if(responseText != 0)
						{	alert("comming");												
							document.getElementById(friend_id+"_replace_addfriend").innerHTML='<p style= "margin: -31px 9px -6px 160px; color: #808080;">Friend Request Sent</p>';
						}						
						else {
							alert("No results found...");							
						}
				}			
		});
}

function register()
{
		if($.trim($('#uname').val()) == '')	
			{				
				$('#uname').select();
				return false;
			}			
		else if( ($.trim($('#password').val()) == '' ||  $.trim($('#password').val()) == 'password') ){				
				$('#password').select();
				return false;
		}
		else if($.trim($('#fname').val()) == '')	
			{				
				$('#fname').select();
				return false;
			}
		else if($.trim($('#email').val()) == '')	
			{				
				$('#email').select();
				return false;
			}
		else if($.trim($('#mobno').val()) == '')	
			{				
				$('#mobno').select();
				return false;
			}		
		else {
			$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=register",	
				data: $("#signup_form").serialize(),				
				success:function(responseText){
						//alert(responseText);
						if(responseText == 1)
						{													
							jQuery('#registerdialog').click();
						}						
						else {
							alert("Invalid User Credentials");
							window.location.href= 'http://localhost/camfoxgit/#register';	
						}
				}			
			});
			return false;
		}
}
	
function dologin()
{		
		if($.trim($('#username').val()) == '')	
			{	
				alert("Enter Username");
				$('#username').select();
				return false;
			}			
		else if( ($.trim($('#userpassword').val()) == '' ||  $.trim($('#userpassword').val()) == 'userpassword') ){				
				$('#userpassword').select();
				alert("Enter password");
				return false;
		}
		else {
			$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=login",	
				data: $("#signin_form").serialize(),				
				success:function(responseText){
						//alert(responseText);
						if(responseText > 0)
						{
						  // jQuery('#signindialog').click();						 
						  window.location.href= 'home.html';	
						}						
						else {
							alert("Invalid User Credentials");
							window.location.href= '#signin';							
						}
				}			
			});
			return false;
		}
}

function user_profile()
{
	$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=userProfile",	
				//data: {user: userid},				
				success:function(responseText){						
						if(responseText != 0)
						{							
							document.getElementById("user_pic").innerHTML=responseText;
						}						
						else {
							alert("Error on getting friends list.");
						}
				}			
			});
}

function getFriends()
{
	$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=getFriends",	
				//data: {user: userid},				
				success:function(responseText){						
						if(responseText != 0)
						{							
							document.getElementById("contact_list").innerHTML=responseText;
						}						
						else {
							document.getElementById("contact_list").innerHTML="";
							//alert("Error on getting friends list.");
						}
				}			
			});
}

function logout_function()
{
	$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=logout",	
				//data: $("#signin_form").serialize(),				
				success:function(responseText){		
							//alert(responseText);
						   window.location.href= 'index.html';							
				}			
			});
}

function check_user_session()
{
	$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=checkUserSession",	
				//data: $("#signin_form").serialize(),				
				success:function(responseText){		
						//alert(responseText);
						if(responseText == 0){
						   window.location.href= 'home.html'; 
						   }
						 else{							
							window.location.href= '#signin';	
							}
				}			
			});
}

function new_post()
{
	var post_value = document.getElementById("post_textarea").value;
	$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=new_post",	
				data: {post: post_value},				
				success:function(responseText){						
						if(responseText != null)
						{	
							document.getElementById("post_textarea").value="";
							document.getElementById("new_post_stream").innerHTML=responseText;
						}						
						else {
							alert("Error on posting a text.");
						}
				}			
			});
}

function post_content()
{
	var user_time_zone = getTimeZoneG();
	$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=show_post_content",	
				data: {timezone: user_time_zone},				
				success:function(responseText){						
						if(responseText != null)
						{	
							document.getElementById("post_stream").innerHTML=responseText;
						}						
						else {
							alert("Error on posting a text.");
						}
				}			
			});
}

function post_like(post_id_like_unlike, user)
{
	var type = ($('#'+(post_id_like_unlike.id)).html());
    //Splitting post_id_like_unlike to get the post id for which the user clicked Like/Unlike
	//alert(type);
	var post_id_of_like_unlike= ((post_id_like_unlike.id).split("_")) [0];
    //Getting the span id which shows post's like count
	//alert(post_id_of_like_unlike);
    var post_id_like_count = post_id_of_like_unlike+'_like_count';
	//alert(post_id_like_count);
	var like_count = $('#'+(post_id_like_count)).html();
	//alert('like_count'+like_count);
	if (type == 'Like')
    {
        //Ajax POST request to call post_like.php
        //Sends Post ID and User ID as parameter
		like_count = like_count+1;
    	$.post(getBaseURL()+"process/api.php?rquest=post_like",{post_id:post_id_of_like_unlike,user_id:user, count:like_count},function(output){
                $('#'+(post_id_like_unlike.id)).html('Unlike');
                //Increasing the previous like count by 1
                $('#'+(post_id_like_count)).html(
            	parseInt($('#'+(post_id_like_count)).html())+1
            	);
	       });
     }
	 else 
    {
        //Ajax POST request to call post_unlike.php
        //Sends Post ID and User ID as parameter
		like_count = like_count-1
    	$.post(getBaseURL()+"process/api.php?rquest=post_unlike",{post_id:post_id_of_like_unlike,user_id:user, count:like_count},function(output){
            	$('#'+(post_id_like_unlike.id)).html('Like');
                //Decreasing the previous like count by 1
            	$('#'+(post_id_like_count)).html(
            	parseInt($('#'+(post_id_like_count)).html())-1
            	);
    	   });
    }
    
}

function show_comments(post_id_of_comment, user)
{
	if($('#'+post_id_of_comment+'_comment').html() == "")
	{
	var user_time_zone = getTimeZoneG();
	//alert(user_time_zone);
	$.post(getBaseURL()+"process/api.php?rquest=show_comments",{post_id:post_id_of_comment, user_id:user, timezone:user_time_zone},function(output){
           $('#'+post_id_of_comment+'_comment').html(output);   
			//$('#'+post_id_of_comment+'_self_comment').html("");
	  });
	}
	else
		$('#'+post_id_of_comment+'_comment').html("");
}

//Function to insert new comment
function new_comment(comment_box_id,return_key_event,user_session_id)
{
	//if condition to check if the user clicked Enter
	if(return_key_event && return_key_event.keyCode == 13)
       {
            //if condition to ckeck if the user has not entered blank comment
        	if(!$.trim($('#'+(comment_box_id.id)).val()))
        	{
        	    alert("Please enter some text in the comment");
        		return;	
        	} 
    	    
            //Getting comment text
    	    var new_comment_text= $('#'+(comment_box_id.id)).val();
            //Getting post id of the post on which the user has commented
    	    var post_id_of_comment= ((comment_box_id.id).split("_")) [0];
            //Getting span id which shows the comment count
            var post_comment_count = post_id_of_comment+'_comment_count';
            
			var comments_count = parseInt($('#'+(post_comment_count)).html())+1;
            //Ajax POST request to call new_comment.php
            //Sends Post ID, Comment text and User ID as parameter	
            $.post(getBaseURL()+"process/api.php?rquest=new_comment",{post_id:post_id_of_comment,comment_text:new_comment_text,user_id:user_session_id, count:comments_count},function(output){
                    //placing the new comment before the last self-comment box
                	$('#'+post_id_of_comment+'_self_comment').before(output);
                    //increasing number of comments by 1
                	$('#'+(post_comment_count)).html(
                	parseInt($('#'+(post_comment_count)).html())+1
                	);
                    //clearing comment text in the textarea
                	$('#'+(comment_box_id.id)).val(null);
        	}); 	
      }	
};

function new_comment_forpost(comment_box_id,return_key_event,user_session_id)
{
	//if condition to check if the user clicked Enter
	if(return_key_event && return_key_event.keyCode == 13)
       {
            //if condition to ckeck if the user has not entered blank comment
        	if(!$.trim($('#'+(comment_box_id.id)).val()))
        	{
				alert("Please enter some text in the comment");
        		return;	
        	} 
    	    
            //Getting comment text
    	    var new_comment_text= $('#'+(comment_box_id.id)).val();
            //Getting post id of the post on which the user has commented
    	    var post_id_of_comment= ((comment_box_id.id).split("_")) [0];
            //Getting span id which shows the comment count
            var post_comment_count = post_id_of_comment+'_post_comment_count';
            
			var comments_count = parseInt($('#'+(post_comment_count)).html())+1;
            //Ajax POST request to call new_comment.php
            //Sends Post ID, Comment text and User ID as parameter	
            $.post(getBaseURL()+"process/api.php?rquest=new_comment",{post_id:post_id_of_comment,comment_text:new_comment_text,user_id:user_session_id, count:comments_count},function(output){
                    //placing the new comment before the last self-comment box
                	$('#'+post_id_of_comment+'_post_self_comment').after(output);
                    //increasing number of comments by 1
                	$('#'+(post_comment_count)).html(
                	parseInt($('#'+(post_comment_count)).html())+1
                	);
                    //clearing comment text in the textarea
                	$('#'+(comment_box_id.id)).val(null);
        	}); 	
      }	
};

function get_friend_notification()
{
	$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=show_addfriends_notification",
				success:function(responseText){						
						if(responseText != null)
						{	
							var x = document.getElementsByClassName("friReq_notify");
							x[0].innerHTML = responseText;
							x[1].innerHTML= responseText;
							//document.getElementById("friReq_notify").innerHTML=responseText;
						}						
						else {
							alert("Error on showing friends notifications.");
						}
				}			
			});
}

function get_events_notification()
{
	$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=show_events_notification",
				success:function(responseText){						
						if(responseText != null)
						{	
							var x = document.getElementsByClassName("events_notify");
							x[0].innerHTML = responseText;
							x[1].innerHTML= responseText;
							x[2].innerHTML= responseText;							
						}						
						else {
							alert("Error on showing events notifications.");
						}
				}			
			});
}

function remove_friend_notification()
{
	$.ajax({
			type:'POST',				
			url: getBaseURL()+"process/api.php?rquest=remove_addfriends_notification",
			success:function(responseText){
						var x = document.getElementsByClassName("friReq_notify");
						x[0].innerHTML = responseText;
						x[1].innerHTML= responseText;
						//document.getElementById("friReq_notify").innerHTML=responseText;
			}			
		});
}

function remove_event_notification()
{
	$.ajax({
			type:'POST',				
			url: getBaseURL()+"process/api.php?rquest=remove_events_notification",
			success:function(responseText){
					var x = document.getElementsByClassName("events_notify");
					x[0].innerHTML= responseText;
					x[1].innerHTML= responseText;
					x[2].innerHTML= responseText;
			}			
		});	
}

function show_requested_friends()
{
	$.ajax({
			type:'POST',				
			url: getBaseURL()+"process/api.php?rquest=show_requested_friends",
			success:function(responseText){						
					if(responseText != null)
					{	
						document.getElementById("requested_friends_list").innerHTML=responseText;
					}						
					else {
						alert("Error on showing friends notifications.");
					}
			}			
		});
}

function show_events()
{
	var user_time_zone = getTimeZoneG();
	$.ajax({
			type:'POST',				
			url: getBaseURL()+"process/api.php?rquest=show_events",
			data: {timezone: user_time_zone},	
			success:function(responseText){						
					if(responseText != null)
					{	
						document.getElementById("friends_states_main").innerHTML=responseText;
					}						
					else {
						alert("Error on showing event news.");
					}
			}			
		});
}

function confirm_friend_request(confirm_element)
{
	var friend_id = confirm_element.id;
	var confirm_remove_id = friend_id+"_confirm_friend";
	var delete_remove_id = friend_id+"_notnow_friend";
	$.ajax({
			type:'POST',				
			url: getBaseURL()+"process/api.php?rquest=confirm_friend_request",
			data: {id : friend_id},
			success:function(responseText){						
					if(responseText != null)
					{	
						document.getElementById(confirm_remove_id).innerHTML="";
						document.getElementById(delete_remove_id).innerHTML=responseText;
						//document.getElementById(friend_id+"_confirm_friend_unfrs").innerHTML ="";
						//document.getElementById(friend_id+"_notnow_friend_unfrs").innerHTML = responseText;
					}						
					else {
						alert("Error on showing friends label.");
					}
			}			
		});
}

function delete_friend_request(remove_element)
{
	var friend_id = remove_element.id;
	var element = friend_id+"_friends_li_item";
	$.ajax({
			type:'POST',				
			url: getBaseURL()+"process/api.php?rquest=delete_friend_request",
			data: {id : friend_id},
			success:function(responseText){						
					if(responseText != null)
					{	
						document.getElementById(element).remove();
					}						
					else {
						alert("Error on showing friends label.");
					}
			}			
		});
}

function show_post_detail(readmore_element)
{
	var user_time_zone = getTimeZoneG();
	var post_id = readmore_element.id;
	$.ajax({
			type:'POST',				
			url: getBaseURL()+"process/api.php?rquest=show_post_detail",
			data: {id : post_id,timezone: user_time_zone},
			success:function(responseText){						
					if(responseText != null)
					{						
						window.location.href= 'home.html#post_fullview';
						document.getElementById("post_details").innerHTML=responseText;
					}						
					else {
						alert("Error on showing post detail.");
					}
			}			
		});
}