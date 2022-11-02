$(document).ready(function () {

	var curlhash = window.location.hash;
	var curlh = window.location.hash.substring(1);

	if (curlhash == "" || curlhash == null || curlhash == undefined) {
		$('div.info_inner').hide();
		$('.tab_link').css({'font-weight':'initial','opacity':'1'});
		$('a#profile').css({ 'font-weight': 'bold', 'opacity': '0.5' });
		$('div#profile').show();

		topFunction();
	} else {
		$('div.info_inner').hide();
		$('.tab_link').css({'font-weight':'initial','opacity':'1'});
		$('a#' + curlh + '').css({ 'font-weight': 'bold', 'opacity': '0.5' });
		$('div#' + curlh + '').show();

		topFunction();
	}

	$(document).on('click', 'a.tab_link', function () {

		var a_id = $(this).attr('id');

		$('div.info_inner').hide();
		$('.tab_link').css({'font-weight': 'initial','opacity':'1'});
		$(this).css({ 'font-weight': 'bold', 'opacity': '0.5' });
		$('div#' + a_id + '').show();

		topFunction();
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