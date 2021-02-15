<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/contact.css'); ?>">
<div class="ml-3 mr-3 mt-3 pb-5" style="background:white">
	<h4 class="text-center mb-5 pt-3">CONTACT US</h4>
	<div class="col-md-12 pt-3 wrapper_div" style="display:flex;flex-direction:row">
		<div class="col-md-6">
			<form action="<?php echo base_url('user/contact'); ?>" method="post">
				<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<div class="form-group">
					<input type="text" name="name" class="form-control name" placeholder="Your Name" required>
				</div>
				<div class="form-group">
					<input type="email" name="email" class="form-control email" placeholder="example@domain.com" required>
				</div>
				<div class="form-group">
					<textarea name="msg" class="form-control msg" rows="6" placeholder="Drop your message" required></textarea>
				</div>
				<div class="g-recaptcha form-group" data-sitekey="xxxxxxxxxx"></div>
				<div class="subbtngrp text-center">
					<button class="btn text-light btn-block" style="background:#141E30">Submit</button>
				</div>
			</form>
		</div>
		<div class="col-md-6 wrapper_div_second">
			<div class="imagediv text-center mb-5">
				<img src="<?php echo base_url('assets/images/logo_dark.png') ?>" class="">
			</div>
			<div class="detailsdiv row">
				<i class="fas fa-map-marker"></i>
				308, 3rd Floor,I Thum Tower-A,Sector-62, Noida-201301
			</div>
			<div class="row">
				<i class="fas fa-phone-alt"></i>
				Call on- +91-120-4561602/+91-8920877101
			</div>
			<div class="row">
				<i class="fas fa-at"></i>
				Email us- info@nktech.in
			</div>
			<hr>
			<div class="row mt-3">
				<div class="col-md-8">
					NkTech © 2012-2020 All rights reserved.<br>Terms of Use and Privacy Policy
				</div>
				<div class="col-md-4 text-center">
					<label class="text-center">FOLLOW US</label>
					<div class="icons d-flex justify-content-between">
						<a href=""><i class="fab fa-facebook"></i></a>
						<a href=""><i class="fab fa-twitter"></i></a>
						<a href=""><i class="fab fa-linkedin"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>