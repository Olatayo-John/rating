$(document).ready(function () {
	$('.addnewuserbtn').click(function () {
		$('.addusermodal').modal('show');
	});

	$('.closemodalbtn').click(function () {
		$('.addusermodal').modal('hide');
	});

	$(document).on('click', '.closeupdatebtn,.close_x_icon', function () {
		$('.updateusermodal').modal("hide");
		$('.website_form_div').html("");
		$(".prof_update_spinner").hide();
		$(".new_pwd").val("");
		$(".user_accupdate").hide();
		$(".weberr").hide();
	});

	$(document).on('click', '.ajax_err_div', function () {
		$('.ajax_err_div').fadeOut();
	});

	$(document).on('click', '.ajax_succ_div', function () {
		$('.ajax_succ_div').fadeOut();
	});

	$(document).on('click', 'a.prof_a', function (e) {
		e.preventDefault();
		$('div.website_div,div.account_div,div.payment_div').hide();
		$('a.pay_a,a.web_a,a.ac_a').css('border-bottom', 'initial');
		$(this).css('border-bottom', '2px solid #294a63');
		$('div.profile_div').show();
	});

	$(document).on('click', 'a.web_a', function (e) {
		e.preventDefault();
		$('div.profile_div,div.account_div,div.payment_div').hide();
		$('a.prof_a,a.pay_a,a.ac_a').css('border-bottom', 'initial');
		$(this).css('border-bottom', '2px solid #294a63');
		$('div.website_div').show();
	});

	$(document).on('click', 'a.pay_a', function (e) {
		e.preventDefault();
		$('div.profile_div,div.account_div,div.website_div').hide();
		$('a.prof_a,a.ac_a,a.web_a').css('border-bottom', 'initial');
		$(this).css('border-bottom', '2px solid #294a63');
		$('div.payment_div').show();
	});

	$(document).on('click', 'a.ac_a', function (e) {
		e.preventDefault();
		$('div.profile_div, div.website_div,div.payment_div').hide();
		$('a.prof_a,a.pay_a,a.web_a').css('border-bottom', 'initial');
		$(this).css('border-bottom', '2px solid #294a63');
		$('div.account_div').show();
	});

	// $('.u_pwd').click(function () {
	// 	$('.pwderr').show();
	// });

	$(document).on('click', '.genpwdbtn', function () {
		// var randpwd = Math.floor((Math.random() * 10000000) + 1);
		// var pwd = $('.u_pwd').val(randpwd);
		// $(".user_accupdate").show();

		var length = 10;
		var charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		var val = "";

		for (var i = 0, n = charset.length; i < length; ++i) {
			val += charset.charAt(Math.floor(Math.random() * n));
		}
		var pwd = $('.u_pwd').val(val);
		$(".user_accupdate").show();
	});

});