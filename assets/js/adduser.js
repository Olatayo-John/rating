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

	$('button.registerbtn').click(function (e) {
		// e.preventDefault();
		var email = $('.email').val();
		var mobile = $('.mobile').val();
		var uname = $('.uname').val();
		var pwd = $('.pwd').val();

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