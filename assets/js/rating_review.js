$('div.fbdiv,div.gdiv,div.gddiv,div.tpdiv').hide();
$('button.owbtn').css('box-shadow','5px 5px 5px 5px #8BC34A');
$('button.fbbtn,button.gbtn,button.gdbtn,button.tpbtn').css('box-shadow','none');

$(document).ready(function() {
	$('button.owbtn').click(function() {
		$('.owdiv').show();
		$('div.fbdiv,div.gdiv,div.gddiv,div.tpdiv').hide();
		$(this).css('box-shadow','5px 5px 5px 5px #8BC34A');
		$('button.fbbtn,button.gbtn,button.gdbtn,button.tpbtn').css('box-shadow','none');
	});
	$('button.fbbtn').click(function() {
		$('.fbdiv').show();
		$('div.owdiv,div.gdiv,div.gddiv,div.tpdiv').hide();
		$(this).css('box-shadow','5px 5px 5px 5px #8BC34A');
		$('button.owbtn,button.gbtn,button.gdbtn,button.tpbtn').css('box-shadow','none');
	});
	$('button.gbtn').click(function() {
		$('.gdiv').show();
		$('div.owdiv,div.fbdiv,div.gddiv,div.tpdiv').hide();
		$(this).css('box-shadow','5px 5px 5px 5px #8BC34A');
		$('button.fbbtn,button.owbtn,button.gdbtn,button.tpbtn').css('box-shadow','none');
	});
	$('button.gdbtn').click(function() {
		$('.gddiv').show();
		$('div.owdiv,div.fbdiv,div.gdiv,div.tpdiv').hide();
		$(this).css('box-shadow','5px 5px 5px 5px #8BC34A');
		$('button.fbbtn,button.gbtn,button.owbtn,button.tpbtn').css('box-shadow','none');
	});
	$('button.tpbtn').click(function() {
		$('.tpdiv').show();
		$('div.owdiv,div.fbiv,div.gdiv,div.gddiv').hide();
		$(this).css('box-shadow','5px 5px 5px 5px #8BC34A');
		$('button.fbbtn,button.gbtn,button.gdbtn,button.owbtn').css('box-shadow','none');
	});
	$('button.closemodal').click(function() {
		$('.readmodal').hide();
	});
	// $('button.tabbtn').click(function() {
	// 	$(this).css('color','#8BC34A');
	// });
	
});