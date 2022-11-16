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

		$('.tab_link').css({'font-weight': 'initial','border-bottom':'initial'});
		$(this).css({ 'font-weight': '500', 'border-bottom': '2px solid #294a63' });

		$('.genform').hide();
		$('form.'+tabFormName+'').show();
	});

	$('.close_EmailModalBtn').click(function (e) {
		e.preventDefault();

		$('.emailmodal').modal('hide');
	});

	$('.close_SmsModalBtn').click(function (e) {
		e.preventDefault();

		$('.smsmodal').modal('hide');
	});

});