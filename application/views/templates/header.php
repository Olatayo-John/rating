<!DOCTYPE html>
<html>

<head>
	<title>RATING</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css'); ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="icon" href="<?php echo base_url('assets/images/logo_dark.png') ?>">
	<script type="text/javascript">
		document.onreadystatechange = function() {
			if (document.readyState !== "complete") {
				$(".spinnerdiv").show();
			} else {
				$(".spinnerdiv").fadeOut();
			}
		};
	</script>
</head>

<body>
	<div class="spinnerdiv">
		<div class="spinner-border" style="color:cornflowerblue"></div>
	</div>
	<nav class="navbar navbar-expand-lg navbar-light">

		<button class="btn btn-outline-dark menubtn mr-auto" onclick="opennav()">&#9776;</button>

		<div class="side-nav" id="side-nav">
			<a href="javascript:void(0)" class="closex" onclick="closenav()">&times;</a>
			<ul>
				<?php if (!$this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item"><a href="<?php echo base_url('user/login') ?>" class="nav-link text-success"><i class="fas fa-user"></i>Login</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('user/register') ?>" class="nav-link text-danger"><i class="fas fa-plus-circle"></i>Register</a>
					</li>
				<?php endif; ?>
				<?php if ($this->session->userdata('mr_logged_in') && $this->session->userdata('mr_admin') == "1") : ?>
					<li class="nav-item"><a href="<?php echo base_url('admin/votes') ?>" class="nav-link">
							<i class="fas fa-poll"></i>Reviews</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('admin/users') ?>" class="nav-link">
							<i class="fas fa-user-shield"></i>Users</a>
					</li>
				<?php endif; ?>
				<?php if ($this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item"><a href="<?php echo base_url('user/profile') ?>" class="nav-link">
							<i class="fas fa-user-edit"></i>Profile</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('user/sendlink') ?>" class="nav-link">
							<i class="fas fa-link"></i>Send Link</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('user/account') ?>" class="nav-link">
							<i class="fas fa-hourglass-half"></i>Account</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('admin/pick_plan') ?>" class="nav-link">
							<i class="fas fa-retweet"></i>Renew Plan</a>
					</li>
				<?php endif; ?>
				<li class="nav-item"><a href="<?php echo base_url('user/contact') ?>" class="nav-link"><i class="fas fa-id-card"></i>Contact us</a>
				</li>
				<?php if ($this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item"><a href="<?php echo base_url('user/logout') ?>" class="nav-link text-danger">
							<i class="fas fa-sign-out-alt"></i>Logout</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>

	</nav>

	<div class="container">
		<div class="alert-danger ajax_alert_div ajax_err_div" style="padding:8px;display:none;z-index: 9999;">
			<button class="ajax_err_div_close close" data-dismiss="ajax_err_div">&times;</button>
			<i class="fas fa-exclamation-circle text-danger"></i>
			<strong class="ajax_res_err text-dark"></strong>
		</div>
		<div class="alert-success ajax_alert_div ajax_succ_div" style="padding:8px;display:none;z-index: 9999;">
			<button class="ajax_succ_div_close close">&times;</button>
			<i class="fas fa-check-circle text-success"></i>
			<strong class="ajax_res_succ text-dark"></strong>
		</div>
		<?php if ($this->session->flashdata('valid')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('valid') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('invalid')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('invalid') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('acces_denied')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('acces_denied') ?></strong>
			</div>
		<?php endif; ?>
		<?php if (form_error('subj') || form_error('body') || form_error('uname') || form_error('pwd')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong>Please fill in the required fields</strong>
			</div>
		<?php endif; ?>
		<?php if (form_error('email')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<strong><?php echo form_error('email') ?></strong>
			</div>
		<?php endif; ?>
		<?php if (form_error('sentcode')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong>Verification code is required to activate your account</strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('db_register_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('db_register_err') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('link_send_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('link_send_err') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('link_send_succ')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle"></i>
				<strong><?php echo $this->session->flashdata('link_send_succ') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('login_now')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle"></i>
				<strong><?php echo $this->session->flashdata('login_now') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('loginfirst')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('loginfirst') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('logout_first')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('logout_first') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('inacc_acc')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('inacc_acc') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('inacc_sub')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('inacc_sub') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('quota_expired')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('quota_expired') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('sub_failed')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('sub_failed') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('reg_succ')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('reg_succ') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('payment_save_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('payment_save_err') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('invalid_login')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('invalid_login') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('valid_login')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle"></i>
				<strong><?php echo $this->session->flashdata('valid_login') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('email_code')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle"></i>
				<strong><?php echo $this->session->flashdata('email_code') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('email_verify_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('email_verify_err') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('email_verify_resend')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle"></i>
				<strong><?php echo $this->session->flashdata('email_verify_resend') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('email_verify_resend_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('email_verify_resend_err') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('email_verified')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle"></i>
				<strong><?php echo $this->session->flashdata('email_verified') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('update_failed')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('update_failed') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('update_succ')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('update_succ') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('user_updated')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('user_updated') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('user_deleted')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('user_deleted') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('small_bal_length')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('small_bal_length') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('cntc_us_succ')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle"></i>
				<strong><?php echo $this->session->flashdata('cntc_us_succ') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('cntc_us_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('cntc_us_err') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('log_out')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle"></i>
				<strong><?php echo $this->session->flashdata('log_out') ?></strong>
			</div>
		<?php endif; ?>
	</div>