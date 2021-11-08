<div class="container">
	<h4 class="text-center mt-5 text-light">Please wait...</h4>
	<h3 class="text-center mt-5 text-danger">Do not refresh this page</h3>
	<div class="spinner-border text-light" role="status">
		<span class="sr-only">Loading...</span>
	</div>
	<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1" class="f1">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
		<?php foreach ($paytm_info as $name => $value) : ?>
			<input type="text" name="<?php echo $name ?>" value="<?php echo $value ?>" class="form-control">
		<?php endforeach; ?>
		<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>" class="form-control">
	</form>
</div>

<style type="text/css">
	body {
		background: #294a63;
		cursor: not-allowed;
	}
</style>

<script type="text/javascript">
	$(document).ready(function(e) {
		// e.preventDefault();
		$('form.f1').submit();

	});
</script>