<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/contact.css'); ?>">
<div class="container">
	<h4 class="text-center text-light font-weight-bolder mb-3 mt-3">CONTACT US</h4>
	<div class="row">
		<div class="col-md-6">
			<form action="<?php echo base_url('user/contact'); ?>" method="post">
				<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<div class="form-group">
					<label><span class="text-danger">* </span>Name</label>
					<input type="text" name="name" class="form-control name" placeholder="Your Name" required>
				</div>
				<div class="form-group">
					<label><span class="text-danger">* </span>E-mail</label>
					<input type="email" name="email" class="form-control email" placeholder="example@domain.com" required>
				</div>
				<div class="form-group">
					<label><span class="text-danger">* </span>Message</label>
					<textarea name="msg" class="form-control msg" rows="6" placeholder="Drop your message" required></textarea>
				</div>
				<div class="g-recaptcha form-group" data-sitekey="6LdT_UIaAAAAANYXRPUzs1SwrYxLE0alc5uiqdN2"></div>
				<div class="subbtngrp text-center">
					<button class="btn btn-success btn-block">Submit</button>
				</div>
			</form>
		</div>
		<div class="col-md-6 nktechdetails">
			<div class="imagediv text-center mb-4">
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
				<div class="col-md-4">
					<label class="text-center text-danger">FOLLOW US</label>
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