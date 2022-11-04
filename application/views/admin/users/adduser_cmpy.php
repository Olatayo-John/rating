<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/adduser.css'); ?>">

<div class="pt-3">
	<div>
		<a href="<?php echo base_url("users") ?>" class="btn text-light" style="background: #294a63;">Back</a>
	</div>
	<form action="<?php echo base_url('adduser'); ?>" method="post" class="bg-light-custom" style="padding:20px">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="row">
			<div class="form-group col">
				<label>First Name</label>
				<input type="text" name="fname" class="form-control fname" placeholder="First Name" value="<?php echo set_value('fname'); ?>">
			</div>
			<div class="form-group col">
				<label>Last Name</label>
				<input type="text" name="lname" class="form-control lname" placeholder="Last Name" value="<?php echo set_value('lname'); ?>">
			</div>
		</div>
		<div class="form-group">
			<label><span class="text-danger font-weight-bolder">* </span>E-mail</label>
			<input type="email" name="email" class="form-control email" placeholder="example@domain.com" id="email" value="<?php echo set_value('email'); ?>">
		</div>
		<div class="form-group">
			<label><span class="text-danger font-weight-bolder">* </span>Mobile</label>
			<input type="number" name="mobile" class="form-control mobile" placeholder="0123456789" id="mobile" value="<?php echo set_value('mobile'); ?>">
			<div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
		</div>
		<div class="form-group cmpydiv">
			<label>Company Name</label>
			<input type="text" name="cmpy" class="form-control cmpy" value=<?php echo $this->session->userdata("mr_cmpy") ?> readonly>
		</div>
		<div class="form-group">
			<label><span class="text-danger font-weight-bolder">* </span>Username</label>
			<input type="text" name="auto-uname" style="opacity: 0; position: absolute">
			<input type="text" name="uname" class="form-control uname" placeholder="Pick a username" id="uname" value="<?php echo set_value('uname'); ?>">
			<span class="unameerr text-danger" style="display:none">Username already exist</span>
		</div>
		<div class="form-group">
			<label><span class="text-danger font-weight-bolder">* </span>Password</label><i class="fas fa-question-circle ml-2" title="Password must be over 6 characters long"></i>
			<input type="password" name="auto-pwd" style="opacity: 0; position: absolute">
			<input type="password" name="pwd" class="form-control pwd" placeholder="Password must be over 6 characters long" id="pwd" minlength="6">
			<span class="text-danger pwderr" style="display: none;">Password is too short</span>
		</div>
		<div class="form-group text-right">
			<i class="far fa-eye mr-2"></i>
			<i class="fas fa-eye-slash mr-2"></i>
			<button class="btn text-light genpwdbtn bg-danger" type="button" name="genpwdbtn">Generate Password</button>
		</div>
		<div class="form-group font-weight-bolder text-left d-flex">
			<div>Send login credentials to user email</div>
			<input type="checkbox" name="logincred" class="logincred" style="margin: auto 0 auto 3px;" checked required>
		</div>

		<div class="pt-4">
			<h4 class="text-dark">Subscriptions</h4>
			<hr class="sub">
			<input type="hidden" name="quota" class="quota" id="quota" value="<?php echo $this->session->userdata("mr_web_quota") ?>">
			<input type="hidden" name="webspace" class="webspace" id="webspace" value="<?php echo $this->session->userdata("mr_webspace") ?>">
			<input type="hidden" name="userspace" class="userspace" id="userspace" value="<?php echo $this->session->userdata("mr_userspace") ?>">

			<div class="m-0 font-weight-bolder text-danger">
				<p>User quota is directly tied to company of "<?php echo $this->session->userdata("mr_cmpy") ?>"</p>
			</div>
		</div>
		<hr>

		<div class="bg-light-custom text-right">
			<button class="btn text-light registerbtn" type="submit" style="background:#294a63">Create User Account</button>
		</div>
	</form>
</div>



<script type="text/javascript" src="<?php echo base_url('assets/js/adduser.js'); ?>"></script>
<script>
	$(document).ready(function() {
		$(".uname").keyup(function() {
			var uname_val = $(".uname").val();
			var csrfName = $(".csrf_token").attr("name");
			var csrfHash = $(".csrf_token").val();

			$.ajax({
				url: "<?php echo base_url("duplicateusername") ?>",
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
						$(".uname").css('border', '2px solid red');
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