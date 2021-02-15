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

	setTimeout(() => document.querySelector('.ajax_alert_div').remove(), 1000);

	$(document).ready(function() {
		$("div ul li a.nav-link").mouseover(function() {
			$(this).children().css("color", "#141E30");
		});

		$("div ul li a.nav-link").mouseout(function() {
			$(this).children().css("color", "white");
		});
	})
</script>
</body>

</html>