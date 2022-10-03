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
	$('button.registerbtn').click(function (e) {
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

		if (email == "" || email == null) {
			$('.email').css('border', '2px solid red');
			document.getElementById("email").scrollIntoView();
			return false;
		} else {
			$('.email').css('border', '1px solid #ced4da');
		}
		if (mobile == "" || mobile == null) {
			$('.mobile').css('border', '2px solid red');
			document.getElementById("mobile").scrollIntoView();
			return false;
		} if (mobile.length < 10 || mobile.length > 10) {
			document.getElementById("mobile").scrollIntoView();
			$('.mobileerr').show();
			return false;
		} else {
			$('.mobile').css('border', '1px solid #ced4da');
			$('.mobileerr').hide();
		}
		var chl = $('#cmpychkb').is(":checked");
		if (chl == true) {
			if (cmpy == "" || cmpy == null) {
				$('.cmpy').css('border', '2px solid red');
				document.getElementById("cmpy").scrollIntoView();
				return false;
			} else {
				$('.cmpy').css('border', '1px solid #ced4da');
			}
		} else {
			$('.cmpy').css('border', '1px solid #ced4da');
		}

		if (uname == "" || uname == null) {
			$('.uname').css('border', '2px solid red');
			document.getElementById("uname").scrollIntoView();
			return false;
		} else {
			$('.uname').css('border', '1px solid #ced4da');
		}
		if (pwd == "" || pwd == null) {
			$('.pwd').css('border', '2px solid red');
			document.getElementById("pwd").scrollIntoView();
			return false;
		} if (pwd.length < 6) {
			document.getElementById("pwd").scrollIntoView();
			$('.pwderr').show();
			return false;
		} else {
			$('.pwd').css('border', '1px solid #ced4da');
			$('.pwderr').hide();
		}
		if (sms_quota == "" || sms_quota == null || email_quota == "" || email_quota == null || whatsapp_quota == "" || whatsapp_quota == null || web_quota == "" || web_quota == null) {
			$(".ajax_succ_div,.ajax_err_div").hide();
			$(".ajax_res_err").text("Please pick a plan");
			$(".ajax_err_div").fadeIn().delay("6000").fadeOut();
			return false;
		} else {
			$(".ajax_err_div,ajax_succ_div").hide();
		}

		$.ajax({
			beforSend: function () {
				$('.registerbtn').attr('disabled', 'disabled');
				$('.registerbtn').html('Processing...');
				$('.registerbtn').css('cursor', 'not-allowed');
				$('.registerbtn').removeClass('btn-info').addClass('btn-danger');
			}
		});
	});

});