$(document).ready(function () {

	var curlhash = window.location.hash;
	var curlh = window.location.hash.substring(1);

	if (curlhash == "" || curlhash == null || curlhash == undefined) {
		$('div.info_inner').hide();
		$('.tab_link').css({'font-weight':'initial','border-bottom':'initial'});
		$('a#profile').css({ 'font-weight': '500', 'border-bottom': '2px solid #294a63' });
		$('div#profile').show();

		// topFunction();
	} else {
		$('div.info_inner').hide();
		$('.tab_link').css({'font-weight':'initial','border-bottom':'initial'});
		$('a#' + curlh + '').css({ 'font-weight': '500', 'border-bottom': '2px solid #294a63' });
		$('div#' + curlh + '').show();

		// topFunction();
	}

	$(document).on('click', 'a.tab_link', function () {

		var a_id = $(this).attr('id');

		$('div.info_inner').hide();
		$('.tab_link').css({'font-weight': 'initial','border-bottom':'initial'});
		$(this).css({ 'font-weight': '500', 'border-bottom': '2px solid #294a63' });
		$('div#' + a_id + '').show();

		// topFunction();
	});

	$("button.genpwdbtn").click(function () {
		$('.genptext').show();
		$('.genptext,.n_pwd,.rtn_pwd').val(returnPassword());
	});

});