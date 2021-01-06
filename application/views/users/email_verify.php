<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/email_verify.css'); ?>">

<div class="container mt-5 col-md-6">
	<h4 class="text-center text-warning">ACCOUNT VERIFICATION</h4>
	<form action="<?php echo base_url('user/emailverify/' . $key); ?>" method="POST" class="email_verify_form">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="form-group">
			<label class="mt-2">
				<span class="text-danger font-weight-bolder">* </span>
				Enter verification code sent to your mail</label>
			<input type="text" name="sentcode" class="form-control sentcode" style="border-radius: 0">
			<div class="text-danger font-weight-bolder codeerr" style="display: none;">Invalid code length</div>
		</div>
		<div class="form-group verifybtndiv">
			<button class="btn btn-success btn-block verifycodebtn" type="submit">Verify</button>
		</div>
		<div class="text-right font-weight-bolder rsendcodediv">
			<a href="<?php echo base_url('user/resendemailverify/' . $key); ?>" class="text-light rsendcodebtn" id="rsendcodebtn">Resend code?</a>
		</div>
	</form>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/email_verify.js'); ?>"></script>