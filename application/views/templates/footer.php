</div>


<script type="text/javascript">

	function opennav() {
		document.getElementById('side-nav').style.left = "0";
		document.getElementById('content').style.marginLeft = "214px";
		// $(".tab_div").hide();
		// $(".info_div").removeClass('col-md-10').addClass('col-md-12');
	}
	
	function closenav() {
		document.getElementById('side-nav').style.left = "-200px";
		document.getElementById('content').style.marginLeft = "14px";
		// $(".tab_div").show();
		// $(".info_div").removeClass('col-md-12').addClass('col-md-10');
	}


	function topFunction() {
		$('html, body').animate({scrollTop: 0}, 100);
	}


	$('[data-toggle="tooltip"]').tooltip();


	setTimeout(() => document.querySelector('.alertsuccess,.alerterror').remove(), 6000);




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

		$(document).on("click", ".ajax_err_div_close", function() {
			$(".ajax_err_div").fadeOut();
		});
	})
</script>
</body>

</html>