$(document).ready(function(){
	function register(){
		var user = {
			name: $("#reg-name").val().trim(), 
			email: $("#reg-email").val().trim(), 
			userName: $("#reg-user").val().trim(), 			
			pass: $("#reg-pass").val(),  
			passConf: $("#reg-pass-conf").val(), 
			ins: $("#reg-ins").val().trim(), 
			cnt: $("#reg-cnt").val(),
		}	
		if(!user.cnt){user.cnt = "";}
		
		for(i in user){
			if(user[i].length < 1){
				swal({
					title: "Whoops!",
					text: "Please enter all the required feilds to register.",
					type: "error",
				});				
				return false;
			}
		}
		if(!isEmail(user.email)){
			swal({
				title: "Whoops!",
				text: "Please enter a valid email to register.",
				type: "error",
			});				
			return false;
		}else if(user.pass.length < 5){
			swal({
				title: "Whoops!",
				text: "The password needs to be at least 5 characters long.",
				type: "error",
			});				
			return false;			
		}else if(user.pass !== user.passConf){
			swal({
				title: "Whoops!",
				text: "The entered passwords do not match. Enter the passwords again and try again.",
				type: "error",
			});				
			return false;			
		}

		$.ajax({
			url: "api/signUp.php",
			type: "post",
			data: {
				"name": user.name,
				"email": user.email,
				"userName": user.userName,				
				"pass": user.pass,
				"passC": user.passConf,				
				"organisation": user.ins,								
				"country": user.cnt,
			},
			dataType: "json",
			beforeSend: function(){
				swal({
					title: "Signing you up...",
					text: "Please wait while we sign you up...",
				});
				swal.showLoading();				
			},
			success: function(d){					
				if(d[0]){
					swal({
						title: "You have signed up!",
						html: "Sudocrypt will start at 00:00:00 on 20 November 2017 and will last till 11:59:59 on 21 November 2017. All the best!",
						type: "success",
					}).then(function(){
						window.location.href = 'index.php';
					});
				}else if(d[1] == "ALREADY"){
					swal({
						title: "Whoops!",
						html: "You have already signed up for Sudocrypt. Sudocrypt will start at 00:00:00 on 20 November 2017 and will last till 11:59:59 on 21 November 2017. All the best!",
						type: "error",
					}).then(function(){
						window.location.href = 'index.php';
					});
				}else if(d[1] == "INC_EMAIL"){
					swal({
						title: "Whoops!",
						html: "The email you've entered it not valid. Plese enter a valid email and try again.",
						type: "error",
					});
				}else if(d[1] == "ALREADY_USER"){
					swal({
						title: "Whoops!",
						html: "The username you have entered is already used. Enter another username and try again.",
						type: "error",
					});
				}else{
					swal({
						title: "Whoops!",
						html: "An error occured! Refresh and try again.",
						type: "error",
					}).then(function(){
						location.reload();
					});					
				}
			},
			error: function(){
				swal({
					title: "Whoops!",
					html: "You are not connected to the internet. Could not Sign you up.",
					type: "error",
				});
			}
		});



	}
	
	$("#reg-go").click(register);

});