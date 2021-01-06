$(document).ready(function() {
	$('.emailsmsmodalbtn').click(function (e) {
		e.preventDefault();
		$('.emailsmsusermodal').modal('show');
	});

	$('.closeemailsmsbtn').click(function (e) {
		e.preventDefault();
		$('.emailsmsusermodal').modal('hide');
	});

});