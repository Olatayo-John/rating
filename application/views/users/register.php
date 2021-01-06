<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/register.css'); ?>">
<div class="container-fluid" id="content">
	<form action="<?php echo base_url('user/register'); ?>" method="post" class="user_reg_form">
		<h4 class="text-center text-light mt-3 mb-5">USER REGISTRATION</h4>
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>First Name</label>
					<input type="text" name="fname" class="form-control fname" placeholder="First Name">
				</div>
				<div class="form-group">
					<label>Last Name</label>
					<input type="text" name="lname" class="form-control lname" placeholder="Last Name">
				</div>
				<div class="form-group">
					<label><span class="text-danger font-weight-bolder">* </span>E-mail</label>
					<input type="email" name="email" class="form-control email" placeholder="example@domain-name.com" id="email">
				</div>
				<div class="form-group">
					<label><span class="text-danger font-weight-bolder">* </span>Mobile</label>
					<input type="number" name="mobile" class="form-control mobile" placeholder="0123456789" id="mobile">
					<div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
				</div>

			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label><span class="text-danger font-weight-bolder">* </span>Username</label>
					<input type="text" name="uname" class="form-control uname" placeholder="Pick a username" id="uname">
					<span class="unameerr text-danger" style="display:none">Username already exist</span>
				</div>
				<div class="form-group">
					<label><span class="text-danger font-weight-bolder">* </span>Password</label>
					<input type="password" name="pwd" class="form-control pwd" placeholder="Password must be over 6 characters long" id="pwd">
					<span class="font-weight-bolder text-danger pwderr" style="display: none;">Password is too short</span>
				</div>
				<div class="form-group">
					<button class="btn btn-outline-warning genpwdbtn" type="button" name="genpwdbtn">Generate Password</button>
					<i class="far fa-eye text-light ml-1"></i>
					<i class="fas fa-eye-slash text-light ml-1"></i>
				</div>
			</div>
		</div>

		<div class="btngrp container">
			<button class="btn btn-success registerbtn" type="submit">Register</button>
			<a href="<?php echo base_url('user/login'); ?>" class="loginbtn">
				Already a user? <i class="far fa-arrow-alt-circle-right"></i></a>
		</div>
	</form>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/register.js'); ?>"></script>
<script>
	$(document).ready(function() {
		$(".uname").keyup(function() {
			var uname_val = $(".uname").val();
			var csrfName = $(".csrf_token").attr("name");
			var csrfHash = $(".csrf_token").val();
			console.log(uname_val);
			$.ajax({
				url: "<?php echo base_url("user/check_duplicate_username") ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					uname_val: uname_val
				},
				success: function(data) {
					console.log(data.user_data);
					$(".csrf_token").val(data.token);
					if (data.user_data > 0) {
						$('.unameerr').show();
						$(".registerbtn").attr("type", "button");
					} else {
						$('.unameerr').hide();
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