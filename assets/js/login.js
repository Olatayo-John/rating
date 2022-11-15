$(document).ready(function() {
	$('button.loginbtn').click(function() {
		// e.preventDefault();
		
		var name= $('.uname').val();	
		var pass= $('.pwd').val();
		var err= null;

		if (name == "" || name == null) {
			return false;
		}

		if (pass == "" || pass == null) {
			return false;
		}
	});
});