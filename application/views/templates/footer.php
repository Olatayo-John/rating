<script type="text/javascript">
	function opennav() {
		document.getElementById('side-nav').style.width = "200px";
		// document.getElementById('content').style.marginRight="250px";
	}

	function closenav() {
		document.getElementById('side-nav').style.width = "0";
		// document.getElementById('content').style.marginRight="auto";
	}
	$('[data-toggle="tooltip"]').tooltip();
	setTimeout(() => document.querySelector('.alert').remove(), 6000);

	$(document).ready(function() {
		$("div ul li a.nav-link").mouseover(function() {
			$(this).children().css("color", "#294a63");
		});

		$("div ul li a.nav-link").mouseout(function() {
			$(this).children().css("color", "white");
		});

		$(document).on("click", ".ajax_succ_div_close", function() {
			$(".ajax_succ_div").fadeOut();
		});

		$(document).on("click", ".ajax_err_div_close", function() {
			$(".ajax_err_div").fadeOut();
		});
	})
</script>
</body>

</html>