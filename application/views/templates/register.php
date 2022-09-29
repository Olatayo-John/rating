<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/register.css'); ?>">

<div class="pt-3">
	<form action="<?php echo base_url('user/register'); ?>" method="post" class="bg-light" style="padding:20px">
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
			<label><span class="text-danger font-weight-bolder">* </span>E-mail</label>
			<input type="email" name="email" class="form-control email" placeholder="example@domain.com" id="email" value="<?php echo set_value('email'); ?>">
		</div>
		<div class="form-group">
			<label><span class="text-danger font-weight-bolder">* </span>Mobile</label>
			<input type="number" name="mobile" class="form-control mobile" placeholder="0123456789" id="mobile" value="<?php echo set_value('mobile'); ?>">
			<div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
		</div>
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
			<span class="cmpyerr text-danger" style="display:none">Company already exist</span>
		</div>
		<hr>

		<div class="pt-4">
			<h4 class="text-dark">Subscriptions</h4>
			<hr class="sub">
			<input type="hidden" name="quota" class="quota" id="quota">
			<input type="hidden" name="webspace" class="webspace" id="webspace">
			<input type="hidden" name="userspace" class="userspace" id="userspace">

			<div class="row col-md-12 m-0">
				<div class="col-md-3 plandiv planone" plan="planone">
					<div class="card">
						<div class="card-header text-center plantype mb-3">
							<label for="">Basic</label>
						</div>
						<div class="text-center planamt">
							FREE
						</div>
						<div class="card-body">
							<p class="text-center mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							<ol style="list-style-type: disc;">
								<li><strong>10</strong> Quota Points</li>
								<li><strong>5</strong> Website Space</li>
								<li class="us"><strong>3</strong> Employee's Space</li>
							</ol>
						</div>
						<div class="card-footer p-0">
							<button class="btn btn-block chooseplanbtn" quota="10" webspace="5" userspace="3" plan="planone" type="button">Choose Plan</button>
						</div>
					</div>
				</div>

				<div class="col-md-3 plandiv plantwo" plan="plantwo">
					<div class="card">
						<div class="card-header text-center plantype mb-3">
							<label for="">Basic</label>
						</div>
						<div class="text-center planamt">
							<i class="fas fa-rupee-sign"></i>
							2000
						</div>
						<div class="card-body">
							<p class="text-center mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							<ol style="list-style-type: disc;">
								<li><strong>50</strong> Quota Points</li>
								<li><strong>10</strong> Website Space</li>
								<li class="us"><strong>5</strong> Employee's Space</li>
							</ol>
						</div>
						<div class="card-footer p-0">
							<button class="btn btn-block chooseplanbtn" quota="50" webspace="10" userspace="5" plan="plantwo" type="button">Choose Plan</button>
						</div>
					</div>
				</div>

				<div class="col-md-3 plandiv planthree" plan="planthree">
					<div class="card">
						<div class="card-header text-center plantype mb-3">
							<label for="">SILVER</label>
						</div>
						<div class="text-center planamt">
							<i class="fas fa-rupee-sign"></i>
							4000
						</div>
						<div class="card-body">
							<p class="text-center mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							<ol style="list-style-type: disc;">
								<li><strong>100</strong> Quota Points</li>
								<li><strong>15</strong> Website Space</li>
								<li class="us"><strong>10</strong> Employee's Space</li>
							</ol>
						</div>
						<div class="card-footer p-0">
							<button class="btn btn-block chooseplanbtn" quota="100" webspace="15" userspace="10" plan="planthree" type="button">Choose Plan</button>
						</div>
					</div>
				</div>

				<div class="col-md-3 plandiv planfour" plan="planfour">
					<div class="card">
						<div class="card-header text-center plantype mb-3">
							<label for="">GOLD</label>
						</div>
						<div class="text-center planamt">
							<i class="fas fa-rupee-sign"></i>
							6000
						</div>
						<div class="card-body">
							<p class="text-center mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							<ol style="list-style-type: disc;">
								<li><strong>200</strong> Quota Points</li>
								<li><strong>20</strong> Website Space</li>
								<li class="us"><strong>15</strong> Employee's Space</li>

							</ol>
						</div>
						<div class="card-footer p-0">
							<button class="btn btn-block chooseplanbtn" quota="150" webspace="20" userspace="15" plan="planfour" type="button">Choose Plan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>

		<div class="btngrp bg-light pt-3 pb-3">
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

		$(".cmpychkb").change(function() {
			var chl = $('#cmpychkb').is(":checked");
			if (chl == true) {
				$('.cmpydiv,li.us').fadeIn();
				$('.cmpy').attr('required', 'required');
			} else {
				$('.cmpydiv,li.us').fadeOut();
				$('.cmpy').removeAttr('required');
			}
		});

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
						$(".cmpy").css('border', '2px solid red');
						$(".registerbtn").attr("type", "button");
					} else {
						$('.cmpyerr').hide();
						$(".cmpy").css('border', '1px solid #ced4da');
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