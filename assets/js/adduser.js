$(document).ready(function () {
	$(".pwd").keyup(function () {
		var pwdval = $('.pwd').val();
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
		var pwd = $('.pwd').val(val);
		$('i.fa-eye').show();
		$('i.fa-eye-slash').hide();
	});

	$(document).on('click', "i.fa-eye", function () {
		$('i.fa-eye-slash').show();
		$('i.fa-eye').hide();
		var spwd = $('.pwd').attr('type', 'text');
	});

	$(document).on('click', "i.fa-eye-slash", function () {
		$('i.fa-eye').show();
		$('i.fa-eye-slash').hide();
		var hpwd = $('.pwd').attr('type', 'password');
	});

	//check all validation
	$('form#adminAddUserForm').submit(function (e) {
		// e.preventDefault();
		var email = $('.email').val();
		var mobile = $('.mobile').val();
		var uname = $('.uname').val();
		var pwd = $('.pwd').val();

		if (email == "" || email == null) {
			document.getElementById("email").scrollIntoView(false);
			return false;
		}

		if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
			document.getElementById("mobile").scrollIntoView(false);
			$('.mobileerr').show();
			return false;
		} else {
			$('.mobileerr').hide();
		}

		if (uname == "" || uname == null) {
			document.getElementById("uname").scrollIntoView(false);
			return false;
		}

		if (pwd == "" || pwd == null || pwd.length < 6) {
			document.getElementById("pwd").scrollIntoView(false);
			$('.pwderr').show();
			return false;
		} else {
			$('.pwderr').hide();
		}

		$.ajax({
			beforSend: function () {
				$('.registerbtn').attr('disabled', 'disabled');
				$('.registerbtn').html('Processing...');
				$('.registerbtn').css('cursor', 'not-allowed');
			}
		});
	});

	//check all validation
	$('form#sadminAddUserForm').submit(function (e) {
		// e.preventDefault();
		var email = $('.email').val();
		var mobile = $('.mobile').val();
		var uname = $('.uname').val();
		var pwd = $('.pwd').val();
		var sms_quota = $(".sms_quota").val();
		var email_quota = $(".email_quota").val();
		var whatsapp_quota = $(".whatsapp_quota").val();
		var web_quota = $(".web_quota").val();

		$(".ajax_res_err,.ajax_res_succ").text("");
		$(".ajax_err_div,ajax_succ_div").hide();

		if (email == "" || email == null) {
			document.getElementById("email").scrollIntoView(false);
			return false;
		}

		if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
			document.getElementById("mobile").scrollIntoView(false);
			$('.mobileerr').show();
			return false;
		} else {
			$('.mobileerr').hide();
		}

		if (uname == "" || uname == null) {
			document.getElementById("uname").scrollIntoView(false);
			return false;
		}

		var chl = $('#cmpychkb').is(":checked");
		if (chl == true) {
			if (cmpy == "" || cmpy == null) {
				document.getElementById("cmpy").scrollIntoView(false);
				return false;
			}
		}

		var lcd = $('#logincred').is(":checked");
		if (lcd !== true) {
			$(".ajax_res_err").text("Send credentials not selected");
			$(".ajax_err_div").fadeIn();
			document.getElementById("cmpy").scrollIntoView(false);
			return false;
		}

		if (pwd == "" || pwd == null || pwd.length < 6) {
			document.getElementById("pwd").scrollIntoView(false);
			$('.pwderr').show();
			return false;
		} else {
			$('.pwderr').hide();
		}

		if (sms_quota == "" || sms_quota == null || email_quota == "" || email_quota == null || whatsapp_quota == "" || whatsapp_quota == null || web_quota == "" || web_quota == null) {
			$(".ajax_res_err").text("Please pick a plan");
			$(".ajax_err_div").fadeIn();
			return false;
		}

		$.ajax({
			beforSend: function () {
				$('.registerbtn').attr('disabled', 'disabled');
				$('.registerbtn').html('Processing...');
				$('.registerbtn').css('cursor', 'not-allowed');
			}
		});
	});

});