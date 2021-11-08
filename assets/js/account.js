$(document).ready(function () {

	$(document).on('click', 'a.prof_a', function (e) {
		e.preventDefault();
		$('div.web_div,div.qu_div,div.ac_div,div.rp_div').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div.prof_div').show();
	});

	$(document).on('click', 'a.web_a', function (e) {
		e.preventDefault();
		$('div.prof_div,div.qu_div,div.ac_div,div.rp_div').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div.web_div').show();
	});

	$(document).on('click', 'a.qu_a', function (e) {
		e.preventDefault();
		$('div.prof_div,div.ac_div,div.web_div,div.rp_div').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div.qu_div').show();
	});

	$(document).on('click', 'a.rp_a', function (e) {
		e.preventDefault();
		$('div.prof_div,div.qu_div, div.web_div, div.ac_div').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div.rp_div').show();
	});

	$(document).on('click', 'a.ac_a', function (e) {
		e.preventDefault();
		$('div.prof_div,div.qu_div, div.web_div,div.rp_div').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div.ac_div').show();
	});

});