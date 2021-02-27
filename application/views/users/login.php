<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">
<div class="">
	<div class="login col-md-6 col-sm-6" id="content">
		<form action="<?php echo base_url('user/login'); ?>" method="post">
			<h4 class="text-center text-light mb-4">LOGIN</h4>
			<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="form-group">
				<label><i class="fas fa-user mr-2 ml-2"></i>Username</label>
				<input type="text" name="uname" class="form-control uname" autofocus="true" placeholder="Your Username" required>
			</div>
			<div class="form-group">
				<label><i class="fas fa-lock mr-2 ml-2"></i>Password</label>
				<input type="password" name="pwd" class="form-control pwd" placeholder="Your Password" required="required">
			</div>
			<div class="btngrp">
				<button class="btn btn-dark loginbtn" type="submit">Login</button>
				<a href="<?php echo base_url('user/register'); ?>" class="signupbtn">
					<i class="fas fa-user-plus mr-2"></i>Sign up
				</a>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/login.js'); ?>"></script>