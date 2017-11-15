window.isEmail = function(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}		

$(document).ready(function(){
	window.menu = {
		status: false,
		open: function(){				
			if(window.innerWidth >= 760){
				return false;
			}			
			this.status = true;

			$(".ui-header-menu-open").addClass("ui-header-menu-open-active");

			$("header").css("overflow", "initial");

			$(".ui-header-mobile-menu").css("display", "block").stop().velocity({
				"opacity": "1"
			}, 500);

			$(".ui-menu-item").css("display", "block").stop().velocity({
				"opacity": "1"				
			}, 500);
		},

		close: function(){
			if(window.innerWidth >= 760){
				return false;
			}		
			this.status = false;	
			
			$(".ui-header-menu-open").removeClass("ui-header-menu-open-active");			
			$(".ui-header-mobile-menu").stop().velocity({
				"opacity": "0"
			}, 500);

			setTimeout(function(){			
				if(!this.status){
					$("header").css("overflow", "hidden");
					$(".ui-header-mobile-menu").css("display", "none");
				}
			}, 500);

		}
	};


	$(".ui-header-menu-open").click(function(){
		if(menu.status){
			menu.close();
		}else{
			menu.open();
		}
	});
});