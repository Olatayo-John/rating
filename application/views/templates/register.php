<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/register.css'); ?>">

<div class="wrapper_div">
	<form action="<?php echo base_url('register'); ?>" method="post" class="bg-light-custom p-3" id="regForm">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

		<div class="row">
			<div class="form-group col">
				<label>First Name</label>
				<input type="text" name="fname" class="form-control fname" placeholder="Your First Name" value="<?php echo set_value('fname'); ?>">
			</div>
			<div class="form-group col">
				<label>Last Name</label>
				<input type="text" name="lname" class="form-control lname" placeholder="Your Last Name" value="<?php echo set_value('lname'); ?>">
			</div>
		</div>

		<div class="form-group">
			<label>E-mail</label> <span>*</span>
			<input type="email" name="email" class="form-control email" placeholder="example@domain.com" id="email" value="<?php echo set_value('email'); ?>" required>
		</div>

		<div class="form-group">
			<label>Mobile</label> <span>*</span>
			<input type="number" name="mobile" class="form-control mobile" placeholder="0123456789" id="mobile" value="<?php echo set_value('mobile'); ?>" required>
			<div class="err mobileerr">Invalid mobile length</div>
		</div>

		<div class="form-group">
			<label>Username</label> <span>*</span>
			<input type="text" name="auto-uname" style="opacity: 0; position: absolute">
			<input type="text" name="uname" class="form-control uname" placeholder="Pick a username" id="uname" required>
			<span class="unameerr err">Username already exist</span>
		</div>

		<div class="form-group">
			<label>Password</label> <span>*</span>
			<i class="fas fa-question-circle ml-2" title="Password must be over 6 characters long"></i>
			<input type="password" name="auto-pwd" style="opacity: 0; position: absolute">
			<input type="password" name="pwd" class="form-control pwd" placeholder="Password must be over 6 characters long" id="pwd" minlength="6">
			<span class="err pwderr">Password is too short</span>
		</div>

		<div class="form-group text-right">
			<i class="far fa-eye mr-2"></i>
			<i class="fas fa-eye-slash mr-2"></i>
			<button class="btn text-light genpwdbtn bg-danger" type="button" name="genpwdbtn">Generate Password</button>
		</div>

		<hr>
		<div class="form-group mb-3 d-flex">
			<div style="color:#294a63;" class="font-weight-bolder">Are you a company?</div>
			<input type="checkbox" class="cmpychkb form" id="cmpychkb" name="cmpychkb" style="margin:auto 0 auto 3px;">
		</div>
		<div class="form-group cmpydiv">
			<label>Company Name</label>
			<input type="text" name="cmpy" class="form-control cmpy" placeholder="Company Name" id="cmpy">
			<span class="cmpyerr err">Company already exist</span>
		</div>
		<hr>

		<!-- plans -->
		<div class="pt-4">
			<!-- <h4 class="text-dark">Subscriptions</h4>
			<hr class="sub"> -->
			<input type="hidden" name="sms_quota" class="sms_quota" id="sms_quota">
			<input type="hidden" name="email_quota" class="email_quota" id="email_quota">
			<input type="hidden" name="whatsapp_quota" class="whatsapp_quota" id="whatsapp_quota">
			<input type="hidden" name="web_quota" class="web_quota" id="web_quota">

			<div class="text-center">
				<h3>Simple Pricing for Everyone!</h3>
				<p>All plans come with a 100% money-back guarantee.</p>
			</div>

			<div class="plansDiv row">
				<div class="col-md-4 planone" plan="planone">
					<div class="planDetails">
						<h5>Free Plan</h5>
						<h6>
							<span>Rs </span>
							<b>0.00 /per month</b>
						</h6>

						<button type="button" class='btn chooseplanbtn' sms_quota="0" email_quota="100" whatsapp_quota="5" web_quota="1" plan="planthree">Choose Plan</button>

						<ul>
							<li>0 SMS Quota</li>
							<li>100 Email Quota</li>
							<li>5 WhatsApp Quota</li>
							<li>1 Website Quota</li>
							<li class="cmp_fet">Unlimited Users</li>
						</ul>
					</div>
				</div>

				<div class="col-md-4 plantwo" plan="plantwo">
					<div class="planDetails">
						<h5>Basic Plan</h5>
						<h6>
							<span>Rs </span>
							<b>1.00 /per month</b>
						</h6>

						<button type="button" class='btn chooseplanbtn' sms_quota="0" email_quota="100" whatsapp_quota="5" web_quota="1" plan="planthree">Choose Plan</button>

						<ul>
							<li>0 SMS Quota</li>
							<li>100 Email Quota</li>
							<li>5 WhatsApp Quota</li>
							<li>1 Website Quota</li>
							<li class="cmp_fet">Unlimited Users</li>
						</ul>
					</div>
				</div>

				<div class="col-md-4 planthree" plan="planthree">
					<div class="planDetails">
						<h5>Regular Plan</h5>
						<h6>
							<span>Rs </span>
							<b>2.00 /per month</b>
						</h6>

						<button type="button" class='btn chooseplanbtn' sms_quota="0" email_quota="100" whatsapp_quota="5" web_quota="1" plan="planthree">Choose Plan</button>

						<ul>
							<li>0 SMS Quota</li>
							<li>100 Email Quota</li>
							<li>5 WhatsApp Quota</li>
							<li>1 Website Quota</li>
							<li class="cmp_fet">Unlimited Users</li>
						</ul>
					</div>
				</div>

			</div>

		</div>
		<hr>

		<div class="btngrp bg-light-custom pt-3 pb-3">
			<button class="btn text-light registerbtn" type="submit" style="background:#294a63">Create Account</button>
			<a href="<?php echo base_url('login'); ?>" class="loginbtn text-danger" style="colosr:#294a63">
				Already a user?</a>
		</div>
	</form>
</div>





<script type="text/javascript" src="<?php echo base_url('assets/js/register.js'); ?>"></script>
<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();

		//check for duplicate username
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

		$(".cmpychkb").change(function() {
			var chl = $('#cmpychkb').is(":checked");
			if (chl == true) {
				$('.cmpydiv,.cmp_fet').fadeIn();
				$('.cmpy').attr('required', 'required');
			} else {
				$('.cmpydiv,.cmp_fet').fadeOut();
				$('.cmpy').removeAttr('required');
			}
		});

		//check for duplicate companyName
		$(".cmpy").keyup(function() {
			var cmpy_val = $(".cmpy").val();
			var csrfName = $(".csrf_token").attr("name");
			var csrfHash = $(".csrf_token").val();

			$.ajax({
				url: "<?php echo base_url("duplicatecmpy") ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					cmpy_val: cmpy_val
				},
				success: function(data) {
					$(".csrf_token").val(data.token);
					if (data.user_data > 0) {
						$('.cmpyerr').show();
						$(".registerbtn").attr("type", "button");
					} else {
						$('.cmpyerr').hide();
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