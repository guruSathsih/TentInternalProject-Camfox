
$(document).delegate('#signindialog', 'click', function() {
			  $(this).simpledialog({
				'mode' : 'bool',
				'prompt' : 'You are successfully loged in...',
				'useModal': true,
				'buttons' : {
				  'OK': {
					click: function () {
						window.location.href= 'http://localhost/camfox/home.html';
					}
				  },
				  'Cancel': {
					click: function () {
					  //$('#dialogoutput').text('Cancel');
					},
					icon: "delete",
					theme: "c"
				  }
				}
			  })
			});
			
			
	$(document).delegate('#registerdialog', 'click', function() {
			  $(this).simpledialog({
				'mode' : 'bool',
				'prompt' : 'You are successfully registered...',
				'useModal': true,
				'buttons' : {
				  'OK': {
					click: function () {
						window.location.href= 'http://localhost/camfox/#signin';
					}
				  },
				  'Cancel': {
					click: function () {
					  //$('#dialogoutput').text('Cancel');
					},
					icon: "delete",
					theme: "c"
				  }
				}
			  })
			});		