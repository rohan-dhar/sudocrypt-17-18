$(document).ready(function(){

	var inRequest = false;

	function checkGameAnswer(){
		var answer = $("#level-answer").val().trim();
		if(answer.length < 1){
			$("#status").css("display", "inline-block").text("Please enter an answer to submit");
			return false;
		}
			
		$.ajax({
			url: "api/checkGameAnswer.php",
			type: "post",
			data: {
				"answer": answer,			
			},
			dataType: "json",
			beforeSend: function(){
				$("#status").css("display", "none");
				$("#level-load").css("display", "block");
				$("#level-go").prop('disabled', true);
				inRequest = true;

			},
			complete: function(){
				$("#level-load").css("display", "none");			
		 		$("#level-go").prop('disabled', false);
		 		inRequest = false;
			},
			success: function(d){					
				if(d[0]){
					swal({
						title: "Success!",
						html: d[1],
						type: "success",
					}).then(function(){
						location.reload();
					});
					
				}else if(d[1] == "LOGOUT"){
					swal({
						title: "Whoops!",
						html: "You have been signed out. Sign in and try again.",
						type: "error",
					}).then(function(){
						window.location.href = 'index.php';
					});
				}else if(d[1] == "DQ"){
					swal({
						title: "Whoops!",
						html: "You have been disqualified.",
						type: "error",
					});
					setTimeout(function(){
						location.href = "dq.php";
					}, 4000);
				}else{
					$("#status").css("display", "inline-block").text(d[1]);
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


	$("#level-go").click(checkGameAnswer);
	$("#level-answer").keydown(function(e){		
		if(e.keyCode == 13 && !inRequest){
			checkGameAnswer();
		}
	});

});