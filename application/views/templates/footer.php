</div>
<script type="text/javascript">
	function opennav() {
		document.getElementById('side-nav').style.left = "0";
		document.getElementById('content').style.marginLeft = "214px";
	}

	function closenav() {
		document.getElementById('side-nav').style.left = "-200px";
		document.getElementById('content').style.marginLeft = "14px";
	}

	$('[data-toggle="tooltip"]').tooltip();

	setTimeout(() => document.querySelector('.alertsuccess,.alerterror').remove(), 6000);

	// window.icons = {
	// 	refresh: 'ion-md-refresh',
	// 	'columns': 'fa-th-list',
	// 	export : 'fa-download',
	// 	detail : 'fa-download',
	// 	icon : 'fa-download',
	// 	'detail-view' : 'fa-download',
	// }

	$(document).ready(function() {

		$(document).on("click", ".ajax_succ_div_close", function() {
			$(".ajax_succ_div").fadeOut();
		});

		$(document).on("click", ".ajax_err_div_close", function() {
			$(".ajax_err_div").fadeOut();
		});

		$(".menubtn").click(function() {
			var func = $(this).attr("onclick");
			if (func == "opennav()") {
				$(this).attr("onclick", "closenav()");
			} else if (func == "closenav()") {
				$(this).attr("onclick", "opennav()");
			}

		});
	})
</script>
</body>

</html>