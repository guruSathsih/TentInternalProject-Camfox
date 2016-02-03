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