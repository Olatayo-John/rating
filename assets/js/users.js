$(document).ready(function () {

	$(document).on('click', 'a.prof_a', function (e) {
		e.preventDefault();
		$('div.web_div,div.rr_div,div.ls_div,div.ac_div').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div.prof_div').show();
	});

	$(document).on('click', 'a.web_a', function (e) {
		e.preventDefault();
		$('div.prof_div,div.rr_div,div.ls_div,div.ac_div').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div.web_div').show();
	});

	$(document).on('click', 'a.rr_a', function (e) {
		e.preventDefault();
		$('div.prof_div,div.web_div,div.ls_div,div.ac_div').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div.rr_div').show();
	});

	$(document).on('click', 'a.ls_a', function (e) {
		e.preventDefault();
		$('div.prof_div,div.web_div,div.rr_div,div.ac_div').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div.ls_div').show();
	});

	$(document).on('click', 'a.ac_a', function (e) {
		e.preventDefault();
		$('div.prof_div,div.rr_div,div.ls_div,div.web_div').hide();
		$('.tab_link').css('font-weight', 'initial');
		$(this).css('font-weight', 'bold');
		$('div.ac_div').show();
	});

	$(".rspwd").keyup(function () {
		var pwdval = $('.rspwd').val();
		if (pwdval == "" || pwdval == null) {
			$('i.fa-eye').hide();
			$('i.fa-eye-slash').hide();
		} else {
			$('i.fa-eye').show();
			$('i.fa-eye-slash').hide();
		}
	});

	$("button.genpwdbtn").click(function () {
		var length = 10;
		var charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		var val = "";

		for (var i = 0, n = charset.length; i < length; ++i) {
			val += charset.charAt(Math.floor(Math.random() * n));
		}
		var pwd = $('.rspwd').val(val);
		$('i.fa-eye').show();
		$('i.fa-eye-slash').hide();
	});

	$(document).on('click', "i.fa-eye", function () {
		$('i.fa-eye-slash').show();
		$('i.fa-eye').hide();
		var spwd = $('.rspwd').attr('type', 'text');
	});

	$(document).on('click', "i.fa-eye-slash", function () {
		$('i.fa-eye').show();
		$('i.fa-eye-slash').hide();
		var hpwd = $('.rspwd').attr('type', 'password');
	})

});