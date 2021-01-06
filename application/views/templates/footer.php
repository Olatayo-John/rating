<script type="text/javascript">
	function opennav() {
		document.getElementById('side-nav').style.width="200px";
		// document.getElementById('content').style.marginRight="250px";
	}
	function closenav() {
		document.getElementById('side-nav').style.width="0";
		// document.getElementById('content').style.marginRight="auto";
	}
	$('[data-toggle="tooltip"]').tooltip();
	setTimeout(() => document.querySelector('.alert').remove(), 5000);
</script>
</body>
</html>