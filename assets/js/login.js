$(document).ready(function() {
	$('button.loginbtn').click(function() {
		var name= $('.uname').val();	
		var pass= $('.pwd').val();

		if (name == "" || name == null) {
			$('.uname').css('border','2px solid red');
			return false;
		}else{
			$('.uname').css('border','0 solid red');
		}
		if (pass == "" || pass == null) {
			$('.pwd').css('border','2px solid red');
			return false;
		}else{
			$('.pwd').css('border','0 solid red');
		}
	});
});