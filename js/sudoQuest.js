$(document).ready(function(){

	var inRequest = false;

	function checkQuestAnswer(){
		var answer = $("#level-answer").val().trim();
		if(answer.length < 1){
			$("#status").css("display", "inline-block").text("Please enter an answer to submit");
			return false;
		}
			
		$.ajax({
			url: "api/checkQuestAnswer.php",
			type: "post",
			data: {
				"answer": answer,			
				"level": window.questLevel
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
						html: "The answer was correct! You've completed this SudoQuest.",
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
				}else if(d[1] == "NO_LEVEL"){
					swal({
						title: "Whoops!",
						html: "The level is no longer available.",
						type: "error",
					});
					setTimeout(function(){
						location.reload();
					}, 3000);
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


	$("#level-go").click(checkQuestAnswer);
	$("#level-answer").keydown(function(e){		
		if(e.keyCode == 13 && !inRequest){
			checkQuestAnswer()();
		}
	});

});