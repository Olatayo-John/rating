$(document).ready(function () {

	var curlhash = window.location.hash;
	var curlh = window.location.hash.substring(1);

	if (curlhash == "" || curlhash == null || curlhash == undefined) {
		$('.tab_link').css('border-bottom', 'none');
		$('a#email').css('border-bottom', '2px solid #294a63');
		$('.genform').hide();
		$('form.email').show();
	}else{
		$('.tab_link').css('border-bottom', 'none');
		$('a#'+curlh+'').css('border-bottom', '2px solid #294a63');
		$('.genform').hide();
		$('form.'+curlh+'').show();
	}

	$('a.mail_a').click(function (e) {
		// e.preventDefault();
		$('.tab_link').css('border-bottom', 'none');
		$(this).css('border-bottom', '2px solid #294a63');
		$('.genform').hide();
		$('form.email').show();
	});

	$('a.sms_a').click(function (e) {
		// e.preventDefault();
		$('.tab_link').css('border-bottom', 'none');
		$(this).css('border-bottom', '2px solid #294a63');
		$('.genform').hide();
		$('form.sms').show();
	});

	$('button.closebtn').click(function () {
		$('.emailmodal').hide();
	});

	$('button.smsclosebtn').click(function () {
		$('.smsmodal').hide();
	});

});