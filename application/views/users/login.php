<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">
<div class="">
	<div class="login col-md-6 col-sm-6" id="content">
		<form action="<?php echo base_url('user/login'); ?>" method="post">
			<h4 class="text-center text-light">LOGIN</h4>
			<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="form-group">
				<label>Username:</label>
				<input type="text" name="uname" class="form-control uname" autofocus placeholder="Your Username">
			</div>
			<div class="form-group">
				<label>Password:</label>
				<input type="password" name="pwd" class="form-control pwd" placeholder="Your Password">
			</div>
			<div class="btngrp">
				<button class="btn btn-dark loginbtn" type="submit">Log in</button>
				<a href="<?php echo base_url('user/register'); ?>" class="signupbtn">
					Sign up <i class="far fa-arrow-alt-circle-right"></i></a>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/login.js'); ?>"></script>