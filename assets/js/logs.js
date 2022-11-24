$(document).ready(function () {
	//
	$(document).on('click', '#toggleHeader', function (e) {
		e.preventDefault();

		var inview = $(this).attr("inview");
		var tabName = $(this).attr("tabName");
		var iName = $(this).attr("iName");

		if (inview === "hidden") {
			$('i.' + iName + '').removeClass("fa-caret-up").addClass("fa-caret-down");
			$(this).attr("inview", "showing");
			$('div.' + tabName + '').show();
		} if (inview === "showing") {
			$('i.' + iName + '').removeClass("fa-caret-down").addClass("fa-caret-up");
			$(this).attr("inview", "hidden");
			$('div.' + tabName + '').hide();
		}
	});

	$('.tab_link').click(function (e) {
		e.preventDefault();

		var tabFormName = $(this).attr("tabFormName");

		$('.tab_link').css({ 'font-weight': 'initial', 'border-bottom': 'initial' });
		$(this).css({ 'font-weight': '500', 'border-bottom': '2px solid #294a63' });

		$('.info_div').hide();
		$('div.' + tabFormName + '_outer').show();
	});

});