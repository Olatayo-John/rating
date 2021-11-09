$(document).ready(function () {

	var curlhash = window.location.hash;
	var curlh = window.location.hash.substring(1);

	if (curlhash == "" || curlhash == null || curlhash == undefined) {
		$('.tab_link').css('border-bottom', 'none');
		$('a#as-email').css('border-bottom', '2px solid #294a63');
		$('.genform').hide();
		$('form.as-email').show();
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
		$('form.as-email').show();
	});

	$('a.sms_a').click(function (e) {
		// e.preventDefault();
		$('.tab_link').css('border-bottom', 'none');
		$(this).css('border-bottom', '2px solid #294a63');
		$('.genform').hide();
		$('form.as-sms').show();
	});

	$('button.closebtn').click(function () {
		$('.emailmodal').hide();
	});

	$('button.smsclosebtn').click(function () {
		$('.smsmodal').hide();
	});

});