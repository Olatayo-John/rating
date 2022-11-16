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
		$('.pwd').val(returnPassword());
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

		clearAlert();

		if (email == "" || email == null) {
			document.getElementById("email").scrollIntoView(false);
			return false;
		}

		if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
			document.getElementById("mobile").scrollIntoView(false);
			$('.mobileerr').show();
			return false;
		}else{
			$('.mobileerr').hide();
		}

		var chl = $('#cmpychkb').is(":checked");
		if (chl == true) {
			if (cmpy == "" || cmpy == null) {
				document.getElementById("cmpy").scrollIntoView(false);
				return false;
			}
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

		if (sms_quota == "" || sms_quota == null || email_quota == "" || email_quota == null || whatsapp_quota == "" || whatsapp_quota == null || web_quota == "" || web_quota == null) {
			$(".ajax_res_err").text("Please pick a plan");
			$(".ajax_err_div").fadeIn();
			return false;
		}


		$.ajax({
			beforeSend: function () {
				$('.registerbtn').attr('disabled', 'disabled').html('Processing...').css('cursor', 'not-allowed');
			}
		});
	});

});