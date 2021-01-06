$(document).ready(function () {

	$(document).on('click', 'a.prof_a', function (e) {
		e.preventDefault();
		$('div.web_div,div.ac_div').hide();
		$('a.web_a,a.ac_a').css('border-bottom', 'initial');
		$(this).css('border-bottom', '2px solid #00695C');
		$('div.prof_div').show();
	});

	$(document).on('click', 'a.web_a', function (e) {
		e.preventDefault();
		$('div.prof_div,div.ac_div').hide();
		$('a.prof_a,a.ac_a').css('border-bottom', 'initial');
		$(this).css('border-bottom', '2px solid #00695C');
		$('div.web_div').show();
	});

	$(document).on('click', 'a.ac_a', function (e) {
		e.preventDefault();
		$('div.prof_div, div.web_div').hide();
		$('a.prof_a, a.web_a').css('border-bottom', 'initial');
		$(this).css('border-bottom', '2px solid #00695C');
		$('div.ac_div').show();
	});

	$(document).on('click', 'div.search_icon_div', function () {
		$('.search_div').fadeIn();
		$(this).removeClass("search_icon_div").addClass("search_icon_div_close");
		$('i.search_icon').removeClass("fa-search").addClass("fa-times text-danger");
	});

	$(document).on('click', 'div.search_icon_div_close', function () {
		$('.search_div').fadeOut();
		$(this).removeClass("search_icon_div_close").addClass("search_icon_div");
		$('i.search_icon').removeClass("fa-times text-danger").addClass("fa-search");
	});

	$('.save_pinfo_btn').click(function (e) {
		// e.preventDefault();
		var uname = $('.uname').val();
		var email = $('.email').val();
		var mobile = $('.mobile').val();

		if (uname == "" || uname == null) {
			$('.uname').css('border', '2px solid red');
			return false;
		} else {
			$('.uname').css('border', '1px solid #ced4da');
		}
		if (email == "" || email == null) {
			$('.email').css('border', '2px solid red');
			return false;
		} else {
			$('.email').css('border', '1px solid #ced4da');
		}
		if (mobile == "" || mobile == null) {
			$('.mobile').css('border', '2px solid red');
			return false;
		} if (mobile.length < 10 || mobile.length > 10) {
			$('.mobile').css('border', '2px solid red');
			$('.mobileerr').show();
			return false;
		} else {
			$('.mobile').css('border', '1px solid #ced4da');
			$('.mobileerr').hide();
		}
	});

	$(document).on('click', 'button.add_web_btn', function () {
		$('.add_web_modal').fadeIn();
	});

	$(document).on('click', 'button.close_web_modal', function () {
		$('.add_web_modal').fadeOut();
	});

	$('button.add_web_modal_btn').click(function (e) {
		// e.preventDefault();
		var web_name = $('.web_name').val();
		var web_link = $('.web_link').val();

		console.log(web_name);
		console.log(web_link);

		if (web_name == "" || web_name == null) {
			$('.web_name').css('border', '2px solid red');
			return false;
		} else {
			$('.web_name').css('border', '1px solid #00695C');
		}
		if (web_link == "" || web_link == null) {
			$('.web_link').css('border', '2px solid red');
			return false;
		} else {
			$('.web_link').css('border', '1px solid #00695C');
		}
	});

	$(document).on('click', 'button.delete_web_btn', function () {
		$('.delete_web_modal').fadeIn();
		var btn_id = $(this).attr('id');
		// console.log(btn_id);
		$('.yes_delweb_modal_btn').attr('id', btn_id);
	});

	$(document).on('click', 'button.close_delweb_modal', function () {
		$('.delete_web_modal').fadeOut();
	});

	$(document).on('click', 'button.close_editweb_modal', function () {
		$('.edit_web_modal').fadeOut();
		$('button.update_web_modal_btn').html("Update");
		$('button.update_web_modal_btn').css("background", "#00695C");
	});

	$('button.savecnt_btn').click(function (e) {
		// e.preventDefault();
		var email = $('.email').val();
		var mobile = $('.mobile').val();

		if (email == "" || email == null) {
			$('.email').css('border', '2px solid red');
			return false;
		} else {
			$('.email').css('border', '1px solid #ced4da');
		}
		if (mobile !== "" || mobile !== null) {
			if (mobile.length > 10 || mobile.length < 10) {
				$('span.mobileerr').show();
				return false;
			} else {
				$('.mobile').css('border', '1px solid #ced4da');
				$('span.mobileerr').hide();
			}
		}
	});

	$('button.saveact_btn').click(function (e) {
		// e.preventDefault();
		var c_pwd = $('.c_pwd').val();
		var n_pwd = $('.n_pwd').val();
		var rtn_pwd = $('.rtn_pwd').val();

		if (c_pwd == "" || c_pwd == null) {
			$('.c_pwd').css('border', '2px solid red');
			return false;
		} else {
			$('.c_pwd').css('border', '1px solid #ced4da');
		}
		if (n_pwd == "" || n_pwd == null) {
			$('.n_pwd').css('border', '2px solid red');
			return false;
		} if (n_pwd.length < 6) {
			$('.n_pwd').css('border', '2px solid red');
			$('span.n_pwd_err').show();
			return false;
		} else {
			$('span.n_pwd_err').hide();
			$('.n_pwd').css('border', '1px solid #ced4da');
		}
		if (rtn_pwd == "" || rtn_pwd == null) {
			$('.rtn_pwd').css('border', '2px solid red');
			return false;
		} if (n_pwd !== rtn_pwd) {
			$('.rtn_pwd').css('border', '2px solid red');
			$('span.rtn_pwd_err').show();
			return false;
		} else {
			$('span.rtn_pwd_err').hide();
			$('.rtn_pwd').css('border', '1px solid #ced4da');
		}
	});

});