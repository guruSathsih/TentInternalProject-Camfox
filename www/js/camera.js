	var pictureSource;   // picture source
    var destinationType; // sets the format of returned value
	var mediaType;
    // Wait for PhoneGap to connect with the device
    //
    document.addEventListener("deviceready",onDeviceReady,false);

    // PhoneGap is ready to be used!
    //
    function onDeviceReady() {
		 pictureSource=navigator.camera.PictureSourceType;
        destinationType=navigator.camera.DestinationType;
		 mediaType = navigator.camera.MediaType;
		alert("device ready"); 
		
		var push = PushNotification.init({
			android: {
				senderID: "127422360909"
			},
			ios: {
				alert: "true",
				badge: "true",
				sound: "true"
			},
			windows: {}
		});

		push.on('registration', function(data) {
			// data.registrationId
			alert(data.registrationId);
			$.ajax({
				type:'POST',				
				url: getBaseURL()+"process/api.php?rquest=store_registrationId",	
				data: {reg : data.registrationId},				
				success:function(responseText){
						alert(responseText);
						if(responseText != 0)
						{													
							
						}						
						else {
							alert("In else part");							
						}
				}			
			});
		});

		push.on('notification', function(data) {
			// data.message,
			// data.title,
			// data.count,
			// data.sound,
			// data.image,
			// data.additionalData
		});

		push.on('error', function(e) {
			alert(e.message);
		});
    }

    // Called when a photo is successfully retrieved
    //
    function onPhotoDataSuccess(imageData) {
      // Uncomment to view the base64-encoded image data
      // console.log(imageData);
	  
		alert("photo data success");
      // Get image handle
      //
      var smallImage = document.getElementById('smallImage');

      // Unhide image elements
      //
      smallImage.style.display = 'block';

      // Show the captured photo
      // The in-line CSS rules are used to resize the image
      //
      smallImage.src = "data:image/jpeg;base64," + imageData;
    }	
	
	  function uploadPhoto(imageURI) { 
      var options = new FileUploadOptions();
	  options.fileKey = "file";
	  options.fileName = imageURI.substr(imageURI.lastIndexOf('/')+1);
	  options.mimeType = "image/jpeg";
	  
	  pictureSource = imageURI.substr(imageURI.lastIndexOf('/')+1);
	  //alert("Name:"+pictureSource);
	  //alert(imageURI);
	  var params = new Object();
      params.post_type = "image";
	  
      options.params = params;
      options.chunkedMode = false;// If it is not set the PHP server won't able to read this image'
	  var ft = new FileTransfer();
	  //alert("after file transfer class");
	  ft.upload(imageURI,getBaseURL()+"process/api.php?rquest=uploadImage",win,fail,options);
	  
	  //alert('completed uploading');
    }
    function win(r){
		//alert('success'); 
		alert("Response = " + r.response);
		alert("Sent = " + r.bytesSent);
		// var largeImage = document.getElementById('largeImage');
      // Unhide image elements
      //
      //largeImage.style.display = 'block';
      // Show the captured photo
      // The inline CSS rules are used to resize the image
      //
      //largeImage.src = getSiteURL()+"/process/uploads/images/"+pictureSource;
		
	}
	function fail(error){
		alert('Failed'+error);
	}

     
    // A button will call this function
   
	function getPhoto(source) 
	{
		//alert('getPhoto');
      // Retrieve image file location from specified source
      navigator.camera.getPicture(uploadPhoto, onFail, { quality: 50, 
        destinationType: destinationType.FILE_URI,
        sourceType: source });
    }
 

    // Called if something bad happens.
    // 
    function onFail(message) {
      alert('Failed because: ' + message);
    }
	
	// This is capturing audio files
	
	function captureSuccess(mediaFiles) {
		alert("inside success");
        var i, len;
        for (i = 0, len = mediaFiles.length; i < len; i += 1) {
           uploadAudio(mediaFiles[i]);
		   alert(mediaFiles[i].fullPath);
        }       
    }

    // Called if something bad happens.
    // 
    function captureError(error) {
        var msg = 'An error occurred during capture: ' + error.code;
        navigator.notification.alert(msg, null, 'Uh oh!');
    }

    // A button will call this function
    //
    function captureAudios() {
        // Launch device audio recording application, 
        // allowing user to capture up to 2 audio clips
		alert("inside capture");
        navigator.device.capture.captureAudio(captureSuccess, captureError, {limit: 1});
    }
	
	function uploadAudio(mediaFile) {
		alert("inside upload");
		
        var ftp = new FileTransfer();
        var path = mediaFile.fullPath;
        var name = mediaFile.name;
		var type = 'audio';
			
		//ftp.upload(path,getBaseURL()+"process/api.php?rquest=uploadAudio",win,fail,{ fileName: name, post_type: type});
			
      ftp.upload(path,
           getBaseURL()+"process/api.php?rquest=uploadAudio",
            function(result) {
                alert('Upload success: ' + result.response);
                alert(result.bytesSent + ' bytes sent');
            },
            function(error) {
                alert('Error uploading file ' + path + ': ' + error.message);
            },
            { post_type: type});  
    }

	
	function getVideo(source)
	{
		navigator.camera.getPicture(uploadVideo, onFail, {
		destinationType: destinationType.FILE_URI,
		mediaType: mediaType.VIDEO,
		sourceType: source
		});
	}
	
	function onPhotoURISuccess(imageURI) {
		alert(imageURI);
	}
	
	 function uploadVideo(imageURI) { 
      var options = new FileUploadOptions();
	  options.fileKey = "file";
	  options.fileName = imageURI.substr(imageURI.lastIndexOf('/')+1);
	  options.mimeType = "video/mpeg";
	  
	  pictureSource = imageURI.substr(imageURI.lastIndexOf('/')+1);
	  //alert("Name:"+pictureSource);
	  alert(imageURI);
	  var params = new Object();
      params.post_type = "video";
	  
      options.params = params;
      options.chunkedMode = true;// If it is not set the PHP server won't able to read this image'
	  var ft = new FileTransfer();
	  //alert("after file transfer class");
	  ft.upload(imageURI,getBaseURL()+"process/api.php?rquest=uploadVideo",win,fail,options);
	  
	  alert('completed uploading');
    }   
	