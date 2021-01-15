$(document).ready(function () {
	$('.addnewuserbtn').click(function () {
		$('.addusermodal').modal('show');
	});

	$('.closemodalbtn').click(function () {
		$('.addusermodal').modal('hide');
	});

	$('button.adduserbtn').click(function () {
		//e.preventDefault();
		var full_name = $('.full_name').val();
		var email = $('.email').val();
		var mobile = $('.mobile').val();
		var mail_chk = $('.mail_chkbox').prop('checked');
		var mobile_chk = $('.mobile_chkbox').prop('checked');

		if (full_name == "" || full_name == null) {
			$('.full_name').css('border', '2px solid red');
			return false;
		} else {
			$('.full_name').css('border', '0 solid red');
		}
		if (email == "" || email == null) {
			$('.email').css('border', '2px solid red');
			return false;
		} else {
			$('.email').css('border', '0 solid red');
		}
		if (mobile == "" || mobile == null) {
			$('.mobile').css('border', '2px solid red');
			return false;
		} if (mobile.length < 10 || mobile.length > 10) {
			$('.mobileerr').show();
			return false;
		} else {
			$('.mobile').css('border', '0 solid red');
			$('.mobileerr').hide();
		} if (mail_chk == false && mobile_chk == false) {
			$('div.chkboxerr').show();
			$('.mail_chkbox_span').removeClass('text-secondary').addClass('text-danger');
			$('.mobile_chkbox_span').removeClass('text-secondary').addClass('text-danger');
			return false;
		} else {
			return true;
		}
		$.ajax({
			success: function () {
				$('.adduserbtn').attr('disabled', 'disabled');
				$('.adduserbtn').html('Creating user...');
				$('.adduserbtn').css('cursor', 'not-allowed');
				$('.adduserbtn').removeClass('btn-info').addClass('btn-danger');
			}
		});
	});

	$(document).on('click', '.closeupdatebtn,.close_x_icon', function () {
		$('.updateusermodal').modal("hide");
		$('.website_form_div').html("");
		$(".prof_update_spinner").hide();
		// $('.modal-backdrop').hide();
	});

	$(document).on('click', '.ajax_err_div', function () {
		$('.ajax_err_div').fadeOut();
	});

	$(document).on('click', '.ajax_succ_div', function () {
		$('.ajax_succ_div').fadeOut();
	});

	$(document).on('click', 'a.prof_a', function (e) {
		e.preventDefault();
		$('div.website_div,div.account_div').hide();
		$('a.web_a,a.ac_a').css('border-bottom', 'initial');
		$(this).css('border-bottom', '2px solid #141E30');
		$('div.profile_div').show();
	});

	$(document).on('click', 'a.web_a', function (e) {
		e.preventDefault();
		$('div.profile_div,div.account_div').hide();
		$('a.prof_a,a.ac_a').css('border-bottom', 'initial');
		$(this).css('border-bottom', '2px solid #141E30');
		$('div.website_div').show();
	});

	$(document).on('click', 'a.ac_a', function (e) {
		e.preventDefault();
		$('div.profile_div, div.website_div').hide();
		$('a.prof_a, a.web_a').css('border-bottom', 'initial');
		$(this).css('border-bottom', '2px solid #141E30');
		$('div.account_div').show();
	});

	// $('.u_pwd').click(function () {
	// 	$('.pwderr').show();
	// });

	$(document).on('click', '.genpwdbtn', function () {
		var randpwd = Math.floor((Math.random() * 10000000) + 1);
		var pwd = $('.u_pwd').val(randpwd);
	});

});