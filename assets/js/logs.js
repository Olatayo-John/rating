$(document).ready(function () {
//
	$(document).on('click', '#toggleHeader', function (e) {
		e.preventDefault();

		var inview = $(this).attr("inview");
		var tabName = $(this).attr("tabName");
		var iName = $(this).attr("iName");

		if (inview === "hidden") {
			$('i.'+iName+'').removeClass("fa-caret-up").addClass("fa-caret-down");
			$(this).attr("inview", "showing");
			$('div.'+tabName+'').show();
		} if (inview === "showing") {
			$('i.'+iName+'').removeClass("fa-caret-down").addClass("fa-caret-up");
			$(this).attr("inview", "hidden");
			$('div.'+tabName+'').hide();
		}
	});

});