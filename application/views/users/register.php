<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/register.css'); ?>">
<div class="mb-3 mt-3 ml-3 mr-3 pt-2 pb-2 bg-light">
	<h4 class="text-center">REGISTRATION FORM</h4>
	<hr class="mb-5 mt-2" style="display:none">
</div>
<div class="mt-3" id="content">
	<form action="<?php echo base_url('user/register'); ?>" method="post" class="">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="row mr-3 ml-3">
			<div class="col bg-light pt-4 pb-4">
				<div class="form-group">
					<label>First Name</label>
					<input type="text" name="fname" class="form-control fname" placeholder="Your First Name">
				</div>
				<div class="form-group">
					<label>Last Name</label>
					<input type="text" name="lname" class="form-control lname" placeholder="Your Last Name">
				</div>
				<div class="form-group">
					<label><span class="text-danger font-weight-bolder">* </span>E-mail</label>
					<input type="email" name="email" class="form-control email" placeholder="example@domain.com" id="email">
				</div>
				<div class="form-group">
					<label><span class="text-danger font-weight-bolder">* </span>Mobile</label>
					<input type="number" name="mobile" class="form-control mobile" placeholder="0123456789" id="mobile">
					<div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
				</div>

			</div>
			<div class="col bg-light pt-4 pb-4">
				<div class="form-group">
					<label><span class="text-danger font-weight-bolder">* </span>Username</label>
					<input type="text" name="auto-uname" style="opacity: 0; position: absolute">
					<input type="text" name="uname" class="form-control uname" placeholder="Pick a username" id="uname">
					<span class="unameerr text-danger" style="display:none">Username already exist</span>
				</div>
				<div class="form-group">
					<label><span class="text-danger font-weight-bolder">* </span>Password</label><i class="fas fa-question-circle ml-2" title="Password must be over 6 characters long"></i>
					<input type="password" name="auto-pwd" style="opacity: 0; position: absolute">
					<input type="password" name="pwd" class="form-control pwd" placeholder="Password must be over 6 characters long" id="pwd" minlength="6">
					<span class="font-weight-bolder text-danger pwderr" style="display: none;">Password is too short</span>
				</div>
				<div class="form-group text-right">
					<i class="far fa-eye mr-2"></i>
					<i class="fas fa-eye-slash mr-2"></i>
					<button class="btn btn-outline-info genpwdbtn" type="button" name="genpwdbtn">Generate Password</button>
				</div>
			</div>
		</div>

		<div class="btngrp bg-light pt-4 pb-4 mr-3 ml-3">
			<button class="btn text-light registerbtn" type="submit" style="background:#294a63">Register</button>
			<a href="<?php echo base_url('user/login'); ?>" class="loginbtn text-info" style="colosr:#294a63">
				Already a user? <i class="far fa-arrow-alt-circle-right"></i></a>
		</div>
	</form>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/register.js'); ?>"></script>
<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();

		$(".uname").keyup(function() {
			var uname_val = $(".uname").val();
			var csrfName = $(".csrf_token").attr("name");
			var csrfHash = $(".csrf_token").val();

			$.ajax({
				url: "<?php echo base_url("user/check_duplicate_username") ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					uname_val: uname_val
				},
				success: function(data) {
					$(".csrf_token").val(data.token);
					if (data.user_data > 0) {
						$('.unameerr').show();
						$(".uname").css('border', '1px solid red');
						$(".registerbtn").attr("type", "button");
					} else {
						$('.unameerr').hide();
						$(".uname").css('border', '1px solid #ced4da');
						$(".registerbtn").attr("type", "submit");
					}
				},
				error: function(data) {
					alert('error filtering. Please refresh and try again');
				}
			});
		});
	});
</script>