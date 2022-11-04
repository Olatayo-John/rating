<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/email_verify.css'); ?>">

<div class="bg-light-custom" style="margin-top: 74px;">
	<form action="<?php echo base_url('verifyemail/' . $key); ?>" method="POST" class="email_verify_form">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="form-group">
			<label class="mt-2">
				<span class="text-danger font-weight-bolder">* </span>
				<span>Enter the verification code sent to your mail</span>
				<span class="text-danger">(<?php echo $email ?>)</span>
			</label>
			<input type="text" name="sentcode" class="form-control sentcode" style="border-radius: 0" autofocus required>
			<div class="text-danger font-weight-bolder codeerr" style="display: none;">Invalid code length</div>
		</div>
		<div class="form-group verifybtndiv">
			<button class="btn btn-block text-light verifycodebtn" type="submit" style="background:#294a63">Verify</button>
		</div>
		<div class="text-right font-weight-bolder rsendcodediv">
			<div class="spinner-border rsend_spinner" style="right:140px;width:20px;height:20px;top:unset;left:unset;display:none;">
				<span class="sr-only">Loading...</span>
			</div>
			<a href="<?php echo base_url('user/resendemailverify/' . $key); ?>" class="text-danger rsendcodebtn" id="rsendcodebtn">
				<i class="fas fa-redo-alt mr-2"></i>Resend code?</a>
		</div>
	</form>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/email_verify.js'); ?>"></script>
<script>
	$(document).ready(function() {
		$(document).on('click', '.rsendcodebtn', function(e) {
			// e.preventDefault();
			$(this).css('visibility', 'hidden');
			$(".rsend_spinner").fadeIn();
			// $(this).removeAttr('href');
		})
	})
</script>