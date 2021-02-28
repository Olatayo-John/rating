$(document).ready(function () {
	$('a.sms_a').click(function (e) {
		e.preventDefault();
		$(this).css('border-bottom', '2px solid #294a63');
		$('.sndasmailbtn').css('border-bottom', 'none');
		$('.sms_gen_link_form').show();
		$('.gen_link_form').hide();
	});

	$('a.mail_a').click(function (e) {
		e.preventDefault();
		$(this).css('border-bottom', '2px solid #294a63');
		$('.sndassmsbtn').css('border-bottom', 'none');
		$('.sms_gen_link_form').hide();
		$('.gen_link_form').show();
	});

	$('button.importemail').click(function () {
		var sel_conn = $('#email_select').attr('conn');
		if (sel_conn == "true") {
			var ans = confirm("Are you sure you want to import a new data? Your imported data will be cleared.");
			if (ans == true) {
				$('.email_options').remove();
				$('.emailmodal').show();
			} else {
				return false;
			}
		} else {
			$('.emailmodal').show();
		}
	});

	$('button.closebtn').click(function () {
		$('.emailmodal').hide();
	});

	$('button.smsimport').click(function () {
		var sel_conn = $('#sms_select').attr('conn');
		if (sel_conn == "true") {
			var ans = confirm("Are you sure you want to import a new data? Your imported data will be cleared.");
			if (ans == true) {
				$('.sms_options').remove();
				$('.smsmodal').show();
				$('#sms_select').attr('conn', 'false');
			} else {
				return false;
			}
		} else {
			$('.smsmodal').show();
		}
	});

	$('button.smsclosebtn').click(function () {
		$('.smsmodal').hide();
	});

});