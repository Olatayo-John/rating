$(document).ready(function () {
	//

	$('.tab_link').click(function (e) {
		e.preventDefault();

		var tabFormName = $(this).attr("tabFormName");

		$('.tab_link').css({ 'font-weight': 'initial', 'border-bottom': 'initial' });
		$(this).css({ 'font-weight': '500', 'border-bottom': '2px solid #294a63' });

		$('.info_div').hide();
		$('div.' + tabFormName + '_outer').show();
	});

});