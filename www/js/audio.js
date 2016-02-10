	var pictureSource;   // picture source
    var destinationType; // sets the format of returned value

    // Wait for PhoneGap to connect with the device
    //
    document.addEventListener("deviceready",onDeviceReady,false);

    // PhoneGap is ready to be used!
    //
    function onDeviceReady() {
		 pictureSource=navigator.camera.PictureSourceType;
        destinationType=navigator.camera.DestinationType;
		alert("device ready"); 
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
           getBaseURL()+"process/api.php?rquest=uploadAudioforTest",
            function(result) {
                alert('Upload success: ' + result.response);
                alert(result.bytesSent + ' bytes sent');
            },
            function(error) {
                alert('Error uploading file ' + path + ': ' + error.message);
            },
            { post_type: type});  
    }	
	