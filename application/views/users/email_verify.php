<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/email_verify.css'); ?>">
<div class="ml-3 mr-3 mt-3 bg-light">
	<form action="<?php echo base_url('user/emailverify/' . $key); ?>" method="POST" class="email_verify_form">
		<h4 class="text-center mt-3 mb-0">ACCOUNT VERIFICATION</h4>
		<hr class="mb-5 mt-2">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="form-group">
			<label class="mt-2">
				<span class="text-danger font-weight-bolder">* </span>
				Enter the verification code sent to your mail</label>
			<input type="text" name="sentcode" class="form-control sentcode" style="border-radius: 0" autofocus required>
			<div class="text-danger font-weight-bolder codeerr" style="display: none;">Invalid code length</div>
		</div>
		<div class="form-group verifybtndiv">
			<button class="btn text-light verifycodebtn" type="submit" style="background:#294a63"><i class="fas fa-user-check mr-2"></i>Verify</button>
		</div>
		<div class="text-right font-weight-bolder rsendcodediv">
			<a href="<?php echo base_url('user/resendemailverify/' . $key); ?>" class="text-danger rsendcodebtn" id="rsendcodebtn">
				<i class="fas fa-redo-alt mr-2"></i>Resend code?</a>
		</div>
	</form>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/email_verify.js'); ?>"></script>