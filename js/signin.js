$(document).ready(function(){

	function login(){
		var email = $("#log-email").val().trim();
		var pass = $("#log-pass").val();

		if(email.length < 1 || pass.length < 1){
			swal({
				title: "Whoops!",
				text: "Please provide both the email and password to login!",
				type: "error",
			});				
			return false;
		}

		$.ajax({
			url: "api/signIn.php",
			type: "post",
			data: {
				"email": email,
				"pass": pass,
			},
			dataType: "json",
			beforeSend: function(){
				swal({
					title: "Signing you in...",
					text: "Please wait while we sign you in...",
				});
				swal.showLoading();				
			},
			success: function(d){					
				if(d[0]){
					location = "dashboard.php";
				}else if(d[1] == "INC_EMAIL"){
					swal({
						title: "Whoops!",
						html: "The email entered is not correct. Try again.",
						type: "error",
					});
				}else if(d[1] == "INC_PASS"){
					swal({
						title: "Whoops!",
						html: "The password entered is not correct. Try again.",
						type: "error",
					});
				}else{
					swal({
						title: "Whoops!",
						html: "An error occured! Try again.",
						type: "error",
					});					
				}
			},
			error: function(){
				swal({
					title: "Whoops!",
					html: "You are not connected to the internet. Try again.",
					type: "error",
				});
			}
		});

	}

	$("#log-go").click(login);
});