<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/account.css'); ?>">

<div class="row set_wrapper">
	<div class="tab_div col-md-2">
		<a href="" class="tab_link prof_a">Profile</a>
		<a href="" class="tab_link web_a">Websites</a>
		<?php if(!$this->session->userdata("mr_cmpyid")) :?><a href="" class="tab_link qu_a">Plan</a><?php endif;?>
		<a href="" class="tab_link rp_a">Reset Password</a>
		<a href="" class="tab_link ac_a text-danger font-weight-bolder">De-activate Account</a>
	</div>
	<div class="info_div col-md-10 p-3">
		<div class="prof_div">
			<?php include("profile/profile_edit.php") ?>
		</div>

		<div class="web_div pb-5">
			<?php include("profile/websites.php") ?>
		</div>
		
		<?php if(!$this->session->userdata("mr_cmpyid")) :?>
		<div class="qu_div pb-5">
			<?php include("profile/quota.php") ?>
		</div>
		<?php endif;?>

		<div class="rp_div">
			<?php include("profile/password_reset.php") ?>
		</div>

		<div class="ac_div">
			<?php include("profile/account.php") ?>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/account.js'); ?>"></script>