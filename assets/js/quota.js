$(document).ready(function () {
	$('.emailsmsmodalbtn').click(function (e) {
		e.preventDefault();
		$('.emailsmsusermodal').modal('show');
	});

	$('.closeemailsmsbtn').click(function (e) {
		e.preventDefault();
		$('.emailsmsusermodal').modal('hide');
	});

	$(document).on("click", ".you_sentlinks_btn", function (e) {
		e.preventDefault();
		$('.total_sentlinks_div').hide();
		$('.you_sentlinks_div').show();
		$('.you_sentlinks_btn').css('opacity', 'unset');
		$('.total_sentlinks_btn').css('opacity', '0.9');
	});

	$(document).on("click", ".total_sentlinks_btn", function (e) {
		e.preventDefault();
		$('.you_sentlinks_div').hide();
		$('.total_sentlinks_div').show();
		$('.you_sentlinks_btn').css('opacity', '0.9');
		$('.total_sentlinks_btn').css('opacity', 'unset');
	});


});