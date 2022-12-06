$(document).ready(function () {

	$('.starI').click(function (e) {
		e.preventDefault();
		
		var svalue = $(this).attr('star_value');

		//reset
		$('.starI').removeClass('fas').addClass('far');
		$('div.i_div').hide();

		//apply
		$('.stars i:nth-child(-n+' + svalue + ')').removeClass('far').addClass('fas');
		$('div[star_value="'+svalue+'"]').show();
		$('div[star_value="'+svalue+'"] span').text(svalue+' Star');
		$('.submitbtn').val(svalue);

		$('.details').show();
	});

});