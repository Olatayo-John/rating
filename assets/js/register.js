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
		// var randpwd = Math.floor((Math.random() * 10000000) + 1);
		// var pwd = $('.pwd').val(randpwd);
		// $('i.fa-eye').show();
		// $('i.fa-eye-slash').hide();

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

	//mouse event on "ANY" plan
	$(".plandiv").on({
		mouseenter: function () {
			var plan = $(this).attr("plan");

			//reset back
			$("div.plandiv").css({
				'transition': '.4s',
				'transform': 'scale(1)'
			});

			//zoom out the selected plan
			$("div." + plan + "").css({
				'transition': '.4s',
				'transform': 'scale(1.1)'
			});
		},
		mouseleave: function () {
			var plan = $(this).attr("plan");

			//reset back
			$("div.plandiv").css({
				'transition': '.4s',
				'transform': 'scale(1)'
			});
		}
	});

	$(document).on('click', '.chooseplanbtn', function () {
		var plan = $(this).attr("plan");
		var sms_quota = $(this).attr("sms_quota");
		var email_quota = $(this).attr("email_quota");
		var whatsapp_quota = $(this).attr("whatsapp_quota");
		var web_quota = $(this).attr("web_quota");

		$(".sms_quota,.email_quota,.whatsapp_quota,.web_quota").val("");

		if (plan !== "" && sms_quota !== "" && email_quota !== "" && whatsapp_quota !== "" && web_quota !== "") {
			$(".sms_quota").val(sms_quota);
			$(".email_quota").val(email_quota);
			$(".whatsapp_quota").val(whatsapp_quota);
			$(".web_quota").val(web_quota);

			$(".chooseplanbtn").removeClass("bg-success").html("Choose Plan");;
			$(this).addClass("bg-success").html("Current Plan");
		} else {
			window.location.reload();
		}
	});

	//check all validation
	$('form#regForm').submit(function (e) {
		// e.preventDefault();

		var email = $('.email').val();
		var mobile = $('.mobile').val();
		var cmpy = $('.cmpy').val();
		var cmpychkb = $('.cmpychkb').val();
		var uname = $('.uname').val();
		var pwd = $('.pwd').val();
		var sms_quota = $(".sms_quota").val();
		var email_quota = $(".email_quota").val();
		var whatsapp_quota = $(".whatsapp_quota").val();
		var web_quota = $(".web_quota").val();
		var formErr = null;

		if (email == "" || email == null) {
			formErr = true;
			document.getElementById("email").scrollIntoView(false);
		} else {
			formErr = "";
		}

		if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
			formErr = true;
			document.getElementById("mobile").scrollIntoView(false);
			$('.mobileerr').show();
		}else {
			formErr = "";
			$('.mobileerr').hide();
		}

		var chl = $('#cmpychkb').is(":checked");
		if (chl == true) {
			if (cmpy == "" || cmpy == null) {
				formErr = true;
				document.getElementById("cmpy").scrollIntoView(false);
			} else {
				formErr = "";
			}
		} else {
			formErr = "";
		}

		if (uname == "" || uname == null) {
			formErr = true;
			document.getElementById("uname").scrollIntoView(false);
		} else {
			formErr = "";
		}

		if (pwd == "" || pwd == null || pwd.length < 6) {
			formErr = true;
			document.getElementById("pwd").scrollIntoView(false);
			$('.pwderr').show();
		} else {
			formErr = "";
			$('.pwderr').hide();
		}

		if (sms_quota == "" || sms_quota == null || email_quota == "" || email_quota == null || whatsapp_quota == "" || whatsapp_quota == null || web_quota == "" || web_quota == null) {
			$(".ajax_succ_div,.ajax_err_div").hide();
			$(".ajax_res_err").text("Please pick a plan");
			$(".ajax_err_div").fadeIn().delay("6000").fadeOut();
			formErr = true;
		} else {
			$(".ajax_err_div,ajax_succ_div").hide();
			formErr = '';
		}

		if (formErr === true) {
			return false;
		} else {
			$.ajax({
				beforSend: function () {
					$('.registerbtn').attr('disabled', 'disabled');
					$('.registerbtn').html('Processing...');
					$('.registerbtn').css('cursor', 'not-allowed');
					$('.registerbtn').removeClass('btn-info').addClass('btn-danger');
				}
			});
		}
	});

});