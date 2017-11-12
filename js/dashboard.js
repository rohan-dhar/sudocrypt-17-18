$(document).ready(function(){

	var iTop = $("#cont-det").css("top");

	window.cont = {
		current: "det",
		open: function(n){

			if(n == cont.current){return false;}

			var c = cont.current;
			cont.current = n;

			if(n == "det"){
				$("#cancel-extra").css("display", "none");
				$("#change-pass, #change-user").css("display", "inline-block");				
			}else{
				$("#cancel-extra").css("display", "inline-block");
				$("#change-pass, #change-user").css("display", "none");								
			}


			$("#cont-"+c).stop().velocity({
				"top": "0px",
				"opacity": "0",
				"scaleX": "0.89",
				"scaleY": "0.89",		
			}, {
				duration: 350,
				easing: "easeOutQuart"
			});
			
			setTimeout(function(){
				if(cont.current != c){
					$("#cont-"+c).css("display","none");
				}
			}, 350);

			$("#cont-"+cont.current).css("display", "block").stop().velocity({
				"top": iTop,
				"opacity": "1",
				"scaleX": "1",
				"scaleY": "1",
			}, {
				duration: 350,
				easing: "easeOutQuart"
			});
		}
	}

	function changePassword(){
		var pass = $("#pass-pass").val();
		var passC = $("#pass-pass-conf").val();
		
		if(pass.length < 1 || passC.length < 1){
			swal({
				title: "Whoops!",
				text: "Please enter all the required feilds to change your password.",
				type: "error",
			});				
			return false;			
		}else if(pass.length < 5){
			swal({
				title: "Whoops!",
				text: "The password needs to be longer than 5 characters.",
				type: "error",
			});				
			return false;			
		}if(pass !== passC){
			swal({
				title: "Whoops!",
				text: "The passwords do not match. Try again.",
				type: "error",
			});				
			return false;			
		}

		$.ajax({
			url: "api/changePassword.php",
			type: "post",
			data: {
				"pass": pass,
				"passC": passC,				
			},
			dataType: "json",
			beforeSend: function(){
				swal({
					title: "Changing your password...",
					text: "Please wait...",
				});
				swal.showLoading();				
			},
			success: function(d){					
				if(d[0]){
					swal({
						title: "Success!",
						html: "Your password was changed!",
						type: "success",
					});
					$("#pass-pass-conf").val(""); $("#pass-pass").val("");
					cont.open("det");
				}else if(d[1] == "LOGOUT"){
					swal({
						title: "Whoops!",
						html: "You have been signed out. Sign in and try again.",
						type: "error",
					}).then(function(){
						window.location.href = 'index.php';
					});
				}else{
					swal({
						title: "Whoops!",
						html: "An error occured. Try again.",
						type: "error",
					});
				}
			},
			error: function(){
				swal({
					title: "Whoops!",
					html: "You are not connected to the internet.",
					type: "error",
				});
			}
		});
	}

	function changeUserName(){
		
		var userName = $("#user-username").val().trim();		
		
		if(userName.length < 1){
			swal({
				title: "Whoops!",
				text: "Please enter all the required feilds to change your username.",
				type: "error",
			});				
			return false;			
		}

		$.ajax({
			url: "api/changeUserName.php",
			type: "post",
			data: {
				"userName": userName,			
			},
			dataType: "json",
			beforeSend: function(){
				swal({
					title: "Changing your username...",
					text: "Please wait...",
				});
				swal.showLoading();				
			},
			success: function(d){					
				if(d[0]){
					swal({
						title: "Success!",
						html: "Your username was changed! Your username now is <b> "+userName+" </b>",
						type: "success",
					});
					$("#det-box-user .det-data").text(userName);
					$("#user-username").val("");
					cont.open("det");
				}else if(d[1] == "ALREADY_USER"){
					swal({
						title: "Whoops!",
						html: "The username you have entered is already used. Enter another username and try again.",
						type: "error",
					});
				}else if(d[1] == "LOGOUT"){
					swal({
						title: "Whoops!",
						html: "You have been signed out. Sign in and try again.",
						type: "error",
					}).then(function(){
						window.location.href = 'index.php';
					});
				}else{
					swal({
						title: "Whoops!",
						html: "An error occured. Try again.",
						type: "error",
					});
				}
			},
			error: function(){
				swal({
					title: "Whoops!",
					html: "You are not connected to the internet.",
					type: "error",
				});
			}
		});

	}

	

	$("#change-pass").click(function(){ cont.open("pass"); });
	$("#change-user").click(function(){ cont.open("user"); });
	$("#cancel-extra").click(function(){ cont.open("det"); });
	$("#pass-go").click(changePassword);
	$("#user-go").click(changeUserName);

});