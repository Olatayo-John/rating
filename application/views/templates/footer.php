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


	function topFunction() {
		$('html, body').animate({
			scrollTop: 0
		}, 100);
	}

	function copylink_fun(element) {
        var link = $("<input>");
        $("body").append(link);
        link.val($(element).val()).select();
        document.execCommand("copy");
        link.remove();
        $('.linkcopyalert').fadeIn("slow").delay("5000").fadeOut("slow");
    }


	function clearAlert() {
		$(".alertWrapper").hide();
		$(".alertWrapper strong").empty();
	}

	$(document).on("click", ".alertWrapper", function() {
		clearAlert();
	});

	function returnPassword() {
		var length = 10;
		var charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		var val = "";

		for (var i = 0, n = charset.length; i < length; ++i) {
			val += charset.charAt(Math.floor(Math.random() * n));
		}
		return val;
	}

	

	$('[data-toggle="tooltip"]').tooltip();

	$(".menubtn").click(function() {
		var func = $(this).attr("onclick");
		if (func == "opennav()") {
			$(this).attr("onclick", "closenav()");
		} else if (func == "closenav()") {
			$(this).attr("onclick", "opennav()");
		}

	});

	$(document).ready(function() {
		setTimeout(() => document.querySelector('.alerterror').remove(), 6000);
		setTimeout(() => document.querySelector('.alertsuccess').remove(), 6000);
	})


</script>
</body>

</html>