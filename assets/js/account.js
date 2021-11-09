$(document).ready(function () {

	var curlhash = window.location.hash;
	var curlh = window.location.hash.substring(1);

	if (curlhash == "" || curlhash == null || curlhash == undefined) {
		$('div.info_inner').hide();
		$('.tab_link').css('font-weight', 'initial');
		$('a#profile').css('font-weight', 'bold');
		$('div#profile').show();
	}else{
		$('div.info_inner').hide();
		$('.tab_link').css('font-weight', 'initial');
		$('a#'+curlh+'').css('font-weight', 'bold');
		$('div#'+curlh+'').show();
	}


	$(document).on('click', 'a#profile', function (e) {
		// e.preventDefault();
		$('div.info_inner').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div#profile').show();
	});

	$(document).on('click', 'a#websites', function (e) {
		// e.preventDefault();
		$('div.info_inner').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div#websites').show();
	});

	$(document).on('click', 'a#plan', function (e) {
		// e.preventDefault();
		$('div.info_inner').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div#plan').show();
	});

	$(document).on('click', 'a#resetPassword', function (e) {
		// e.preventDefault();
		$('div.info_inner').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div#resetPassword').show();
	});

	$(document).on('click', 'a#account', function (e) {
		// e.preventDefault();
		$('div.info_inner').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div#account').show();
	});

	$("button.genpwdbtn").click(function () {

		var length = 10;
		var charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		var val = "";

		for (var i = 0, n = charset.length; i < length; ++i) {
			val += charset.charAt(Math.floor(Math.random() * n));
		}

		$('.genptext').show();
		$('.genptext,.n_pwd,.rtn_pwd').val(val);
	});

});