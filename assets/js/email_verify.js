$(document).ready(function () {

	$('button.verifycodebtn').click(function () {
		//e.preventDefault();
		$.ajax({
			beforSend: function () {
				$('.verifybtn').attr('disabled', 'disabled');
				$('.verifybtn').html('Verifying...');
				$('.verifybtn').css('cursor', 'not-allowed');
				$('.verifybtn').removeClass('btn-success').addClass('btn-danger');
			}
		});
	});

	$(document).on("click", 'a.rsendcodebtn', function () {
		//e.preventDefault();
		$.ajax({
			beforSend: function () {
				$('#rsendcodebtn').attr('disabled', 'disabled').html('Sending...').css('cursor', 'not-allowed');
			}
		});
	});

});