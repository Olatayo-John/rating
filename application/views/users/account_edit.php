<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/account.css'); ?>">

<div class="set_wrapper">
	<div class="tab_div">
		<a href="#profile" class="tab_link" id="profile">Profile</a>
		<a href="#websites" class="tab_link" id="websites">Websites</a>
		<?php if ($this->session->userdata('mr_cmpyid') == null) : ?>
			<a href="#plan" class="tab_link" id="plan">Plan</a>
		<?php endif; ?>
		<?php if ($this->session->userdata('mr_admin') == '1') : ?>
			<a href="#cmpy" class="tab_link" id="cmpy">Company</a>
		<?php endif; ?>
		<a href="#resetPassword" class="tab_link" id="resetPassword">Reset Password</a>
		<?php if ($this->session->userdata("mr_sadmin") === "0" && $this->session->userdata("mr_admin") === "0") : ?>
			<a href="#account" class="tab_link text-danger font-weight-bolder" id="account">De-activate Account</a>
		<?php endif; ?>
	</div>


	<div class="info_div p-3 bg-light-custom">
		<div class="info_inner" id="profile">
			<?php include("account/profile_edit.php") ?>
		</div>

		<div class="info_inner" id="websites">
			<?php include("account/websites.php") ?>
		</div>

		<?php if ($this->session->userdata('mr_cmpyid') == null) : ?>
			<div class="info_inner" id="plan">
				<?php include("account/quota.php") ?>
			</div>
		<?php endif; ?>

		<?php if ($this->session->userdata('mr_admin') == '1') : ?>
			<div class="info_inner" id="cmpy">
				<?php include("account/company.php") ?>
			</div>
		<?php endif; ?>

		<div class="info_inner" id="resetPassword">
			<?php include("account/password_reset.php") ?>
		</div>

		<?php if ($this->session->userdata("mr_sadmin") === "0" && $this->session->userdata("mr_admin") === "0") : ?>
			<div class="info_inner" id="account">
				<?php include("account/deactivate_account.php") ?>
			</div>
		<?php endif; ?>
	</div>
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/account.js'); ?>"></script>