$(document).ready(function () {

	var curlhash = window.location.hash;
	var curlh = window.location.hash.substring(1);

	// if (curlhash == "" || curlhash == null || curlhash == undefined) {
	// 	$('.genform').hide();
	// 	$('form.as-email').show();
	// }else{
	// 	$('.genform').hide();
	// 	$('form.'+curlh+'').show();
	// }

	$('.tab_link').click(function (e) {
		e.preventDefault();

		var tabFormName = $(this).attr("tabFormName");

		$('.genform').hide();
		$('form.'+tabFormName+'').show();
	});

	$('button.close_EmailModalBtn').click(function (e) {
		e.preventDefault();

		$('.emailmodal').hide();
	});

	$('button.close_SmsModalBtn').click(function (e) {
		e.preventDefault();

		$('.smsmodal').hide();
	});

});