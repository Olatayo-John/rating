$(document).ready(function () {
	$(document).on('click', '.closeupdatebtn', function () {
		$('.updateusermodal').modal('hide');
		$("tr.truserreview").remove();
		$("div.userweb_div_cal").html("");
		$("#search_ind_votes").val("");
	});

	$(document).on('click', '.container-fluid', function () {
		$('.updateusermodal').modal('hide');
		$("tr.truserreview").remove();
		$("#search_ind_votes").val("");
	});

	$('.u_pwd').click(function () {
		$('.pwderr').show();
	});

	$(document).on('click', '.genpwdbtn', function () {
		var randpwd = Math.floor((Math.random() * 10000000) + 1);
		var pwd = $('.u_pwd').val(randpwd);
	});

});