$(document).ready(function () {
//
	$(document).on('click', '.rr_i', function () {
		var inview = $(this).attr("inview");
		if (inview === "hidden") {
			$(this).removeClass("fa-caret-down").addClass("fa-caret-up");
			$(this).attr("inview", "showing");
			$('.rr_innerwrapper').show();
		} if (inview === "showing") {
			$(this).removeClass("fa-caret-up").addClass("fa-caret-down");
			$(this).attr("inview", "hidden");
			$('.rr_innerwrapper').hide();
		}
	});

	$(document).on('click', '.ls_i', function () {
		var inview = $(this).attr("inview");
		if (inview === "hidden") {
			$(this).removeClass("fa-caret-down").addClass("fa-caret-up");
			$(this).attr("inview", "showing");
			$('.ls_innerwrapper').show();
		} if (inview === "showing") {
			$(this).removeClass("fa-caret-up").addClass("fa-caret-down");
			$(this).attr("inview", "hidden");
			$('.ls_innerwrapper').hide();
		}
	});

});