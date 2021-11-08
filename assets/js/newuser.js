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

	$(document).on('click', '.chooseplanbtn', function () {
		var plan = $(this).attr("plan");
		var quota = $(this).attr("quota");
		var webspace = $(this).attr("webspace");
		var userspace = $(this).attr("userspace");

		$(".quota,.webspace").val("");

		if (plan !== "" && quota !== "" && webspace !== "" && userspace !== "") {
			$(".quota").val(quota);
			$(".webspace").val(webspace);
			$(".userspace").val(userspace);

			$("div.plandiv").css({
				'transition': '.4s',
				'transform': 'scale(1)'
			});

			$("div." + plan + "").css({
				'transition': '.4s',
				'transform': 'scale(1.1)'
			});

			$(".chooseplanbtn").removeClass("bg-success").html("Chose Plan");;
			$(this).addClass("bg-success").html("Chose Plan");
		} else {
			window.location.reload();
		}
	});

	$('button.registerbtn').click(function (e) {
		// e.preventDefault();
		var email = $('.email').val();
		var mobile = $('.mobile').val();
		var cmpy = $('.cmpy').val();
		var cmpychkb = $('.cmpychkb').val();
		var uname = $('.uname').val();
		var pwd = $('.pwd').val();
		var quota = $(".quota").val();
		var webspace = $(".webspace").val();

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
			}else{
				$('.cmpy').css('border', '1px solid #ced4da');
			}
		}else{
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
		if (quota == "" || quota == null || webspace == "" || webspace == null) {
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