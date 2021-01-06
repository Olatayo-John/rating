$(document).ready(function() {
	$('.star1').click(function() {
		var value= $('.star1').attr('name');
		var con= $('.star1').attr('con');
		if (con == 'false') {
			$('.star1').removeClass('far').addClass('fas');
			$('.star1').attr('con','true');
			$('.submit').show();
			$('.submitbtn').val('1');
			$('.onestar').show();
			$('.twostar,.threestar,.fourstar,.fivestar').hide();
			$('span.star_value').text('1 Star');
		}else if(con == 'true'){
			$('.star2').removeClass('fas').addClass('far');
			$('.star3').removeClass('fas').addClass('far');
			$('.star4').removeClass('fas').addClass('far');
			$('.star5').removeClass('fas').addClass('far');
			$('.star2').attr('con','false');							
			$('.star3').attr('con','false');					
			$('.star4').attr('con','false');	
			$('.star5').attr('con','false');
			$('.submitbtn').val('1');
			$('.onestar').show();
			$('.twostar,.threestar,.fourstar,.fivestar').hide();	
			$('span.star_value').text('1 Star');			
		}
	});

	$('.star2').click(function() {
		var value= $('.star2').attr('name');
		var con= $('.star2').attr('con');
		if (con == 'false') {
			$('.star1').removeClass('far').addClass('fas');
			$('.star2').removeClass('far').addClass('fas');
			$('.star1').attr('con','true');
			$('.star2').attr('con','true');
			$('.submit').show();
			$('.twostar').show();
			$('.submitbtn').val('2');
			$('.onestar,.threestar,.fourstar,.fivestar').hide();
			$('span.star_value').text('2 Star');
		}else if(con == 'true'){
			$('.star3').removeClass('fas').addClass('far');
			$('.star4').removeClass('fas').addClass('far');
			$('.star5').removeClass('fas').addClass('far');							
			$('.star3').attr('con','false');					
			$('.star4').attr('con','false');	
			$('.star5').attr('con','false');
			$('.submitbtn').val('2');	
			$('.twostar').show();
			$('.onestar,.threestar,.fourstar,.fivestar').hide();
			$('span.star_value').text('2 Star');			
		}
	});

	$('.star3').click(function() {
		var value= $('.star3').attr('name');
		var con= $('.star3').attr('con');
		if (con == 'false') {
			$('.star1').removeClass('far').addClass('fas');
			$('.star2').removeClass('far').addClass('fas');
			$('.star3').removeClass('far').addClass('fas');
			$('.star1').attr('con','true');
			$('.star2').attr('con','true');
			$('.star3').attr('con','true');
			$('.submit').show();
			$('.submitbtn').val('3');
			$('.threestar').show();
			$('.onestar,.twostar,.fourstar,.fivestar').hide();
			$('span.star_value').text('3 Star');
		}else if(con == 'true'){
			$('.star4').removeClass('fas').addClass('far');
			$('.star5').removeClass('fas').addClass('far');			
			$('.star4').attr('con','false');				
			$('.star5').attr('con','false');
			$('.submitbtn').val('3');
			$('.threestar').show();
			$('.onestar,.twostar,.fourstar,.fivestar').hide();
			$('span.star_value').text('3 Star');
		}
	});

	$('.star4').click(function() {
		var value= $('.star4').attr('name');
		var con= $('.star4').attr('con');
		if (con == 'false') {
			$('.star1').removeClass('far').addClass('fas');
			$('.star2').removeClass('far').addClass('fas');
			$('.star3').removeClass('far').addClass('fas');
			$('.star4').removeClass('far').addClass('fas');
			$('.star1').attr('con','true');
			$('.star2').attr('con','true');
			$('.star3').attr('con','true');
			$('.star4').attr('con','true');
			$('.submit').show();
			$('.submitbtn').val('4');
			$('.fourstar').show();
			$('span.star_value').text('4 Star');
			$('.onestar,.twostar,.threestar,.fivestar').hide();
		}else if(con == 'true'){
			$('.star5').removeClass('fas').addClass('far');							
			$('.star5').attr('con','false');
			$('.submitbtn').val('4');
			$('.fourstar').show();
			$('span.star_value').text('4 Star');
			$('.onestar,.twostar,.threestar,.fivestar').hide();
		}
	});

	$('.star5').click(function() {
		var value= $('.star5').attr('name');
		var con= $('.star5').attr('con');
		if (con == 'false') {
			$('.star1').removeClass('far').addClass('fas');
			$('.star2').removeClass('far').addClass('fas');
			$('.star3').removeClass('far').addClass('fas');
			$('.star4').removeClass('far').addClass('fas');
			$('.star5').removeClass('far').addClass('fas');
			$('.star1').attr('con','true');
			$('.star2').attr('con','true');
			$('.star3').attr('con','true');
			$('.star4').attr('con','true');
			$('.star5').attr('con','true');
			$('.submit').show();
			$('.submitbtn').val('5');
			$('.fivestar').show();
			$('span.star_value').text('5 Star');
			$('.onestar,.twostar,.threestar,.fourstar').hide();
		}
	});

	$(document).on('click','.closemodalbtn',function() {
		$('.e_mobile').hide();
		$('.msgmodal').modal('hide');
	});
	
});