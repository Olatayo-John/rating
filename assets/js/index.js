$(document).ready(function() {
	$('button.importemail').click(function() {
		var sel_conn= $('#email_select').attr('conn');
		if (sel_conn == "true") {
			var ans= confirm("Are you sure you want to import a new data? Your imported data will be cleared.");
			if (ans == true) {
				$('.email_options').remove();
				$('.emailmodal').show();
			}else{
				return false;
			}
		}else{
			$('.emailmodal').show();
		}
	});

	$('button.closebtn').click(function() {
		$('.emailmodal').hide();
	});

	$('.singlemailsend').click(function() {
		$('.email_options').remove();
		$('#email_select').attr('conn','false');
		$('#email_select').hide();
		$('#email').val('');
		$('#email').show();
		bseu= "<?php echo base_url('user/send_link'); ?>";
		$("#gen_link_form").attr('action', bseu);
	});
});