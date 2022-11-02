$(document).ready(function() {
	$('button.loginbtn').click(function() {
		// e.preventDefault();
		
		var name= $('.uname').val();	
		var pass= $('.pwd').val();
		var err= null;

		if (name == "" || name == null) {
			err = true;
		}else{
			err = "";
		}

		if (pass == "" || pass == null) {
			err = true;
		}else{
			err = "";
		}

		if(err === true){
			return false;
		}
	});
});