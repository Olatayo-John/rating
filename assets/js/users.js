$(document).ready(function () {
	$(document).on('click', '.tab_link', function (e) {
		e.preventDefault();
		var tabLinkN= $(this).attr('tabLinkN');
		var tabDivN= $(this).attr('tabDivN');

		$('div.einfoDiv').hide();
		$('div.'+tabDivN+'').show();
		$('.tab_link').css({
			'font-weight': 'initial',
			'background': 'transparent',
			'color': '#fff',
		});
		$(this).css({
			'font-weight': '500',
			'background': '#fff',
			'color': '#294a63',
		});
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
		$('.rspwd').val(returnPassword());
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

	$('.closevuserbtn').click(function (e) {
		e.preventDefault();

		$('.vusermodal').modal('hide');
	});

});