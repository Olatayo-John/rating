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

	$('button.closebtn').click(function () {
		$('.emailmodal').hide();
	});

	$('button.smsclosebtn').click(function () {
		$('.smsmodal').hide();
	});

});