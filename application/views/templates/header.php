<!DOCTYPE html>
<html>

<head>
	<title>
		<?php echo ucfirst(isset($title) ? $title : $this->config->item('web_name')) ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css'); ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

		<?php if ($this->session->userdata('mr_logged_in')) : ?>
			<?php if ($this->session->userdata('mr_sub_active') == "0") : ?>
				<div class="text-danger mr-3">
					<strong><i class="fas fa-exclamation-circle text-danger mr-1"></i>You're subscription is inactive</strong>
				</div>
			<?php elseif ($this->session->userdata('mr_sub_active') == "1") : ?>
				<div class="text-success mr-3">
					<strong><i class="fas fa-check text-success mr-1"></i>You're subscription is active</strong>
				</div>
			<?php endif; ?>
			<div class="navbar-brand text-uppercase font-weight-bolder" style="font-size: 1.1rem;">
				<a href="<?php echo base_url('profile') ?>" style="color:#294a63">
					<span>
						<i class="fas fa-user-circle p_icon"></i>
					</span>
					<?php echo ($this->session->userdata('mr_uname') ? $this->session->userdata('mr_uname') : '') ?></a>
			</div>
		<?php endif; ?>

		<div class="side-nav" id="side-nav">
			<a href="javascript:void(0)" class="closex" onclick="closenav()">&times;</a>
			<?php $url = $this->uri->segment(1); ?>
			<ul>
				<?php if (!$this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item"><a href="<?php echo base_url('login') ?>" class="nav-link" style="<?php echo ($url == 'login') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>"><i class="fas fa-user"></i>Login</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('register') ?>" class="nav-link" style="<?php echo ($url == 'register') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>"><i class="fas fa-user-plus"></i>Register</a>
					</li>
				<?php endif; ?>
				<?php if ($this->session->userdata('mr_logged_in') && $this->session->userdata('mr_admin') == "1") : ?>
					<li class="nav-item"><a href="<?php echo base_url('votes') ?>" class="nav-link" style="<?php echo ($url == 'votes') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>">
							<i class="fas fa-poll"></i>Reviews</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('users') ?>" class="nav-link" style="<?php echo ($url == 'users') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>">
							<i class="fas fa-user-shield"></i>Users</a>
					</li>
				<?php endif; ?>
				<?php if ($this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item"><a href="<?php echo base_url('profile') ?>" class="nav-link" style="<?php echo ($url == 'profile') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>">
							<i class="fas fa-user-edit"></i>Profile</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('share') ?>" class="nav-link" style="<?php echo ($url == 'share') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>">
							<i class="fas fa-link"></i>Send Link</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('account') ?>" class="nav-link" style="<?php echo ($url == 'account') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>">
							<i class="fas fa-hourglass-half"></i>Account</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('plan') ?>" class="nav-link" style="<?php echo ($url == 'plan') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>">
							<i class="fas fa-retweet"></i>Renew Plan</a>
					</li>
				<?php endif; ?>
				<?php if ($this->session->userdata('mr_logged_in') && $this->session->userdata('mr_admin') == "1") : ?>
					<li class="nav-item"><a href="<?php echo base_url('payments') ?>" class="nav-link" style="<?php echo ($url == 'payments') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>">
							<i class="fas fa-wallet"></i>Payments</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('logs') ?>" class="nav-link" style="<?php echo ($url == 'logs') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>">
							<i class="fas fa-clipboard-check"></i>Activity Log</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('feedbacks') ?>" class="nav-link" style="<?php echo ($url == 'feedbacks') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>">
							<i class="fas fa-comment"></i>Feedbacks</a>
					</li>
				<?php endif; ?>
				<li class="nav-item"><a href="<?php echo base_url('contact') ?>" class="nav-link" style="<?php echo ($url == 'contact') ? 'border-left: 3px solid white;border-right: 3px solid white;opacity: 0.5;' : '' ?>"><i class="fas fa-id-card"></i>Contact Us</a>
				</li>
				<?php if ($this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item"><a href="<?php echo base_url('logout') ?>" class="nav-link text-danger">
							<i class="fas fa-sign-out-alt"></i>Logout</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>

	</nav>

	<div class="container">
		<!--testing div-->
		<!--   <div class="alert alert-danger mt-2">-->
		<!--	<button class="close" data-dismiss="alert"><i class="far fa-times-circle"></i></button>-->
		<!--	<i class="fas fa-exclamation-circle text-danger"></i>-->
		<!--	<strong>Test notification</strong>-->
		<!--</div>-->
		<!-- ajax-failed -->

		<div class="alert-danger ajax_alert_div ajax_err_div mt-2" style="padding:8px;display:none;z-index: 9999;">
			<button class="ajax_err_div_close close" data-dismiss="ajax_err_div"><i class="far fa-times-circle"></i></button>
			<i class="fas fa-exclamation-circle text-danger"></i>
			<strong class="ajax_res_err text-dark"></strong>
		</div>
		<!-- ajax-success -->
		<div class="alert-success ajax_alert_div ajax_succ_div mt-2" style="padding:8px;display:none;z-index: 9999;">
			<button class="ajax_succ_div_close close" data-dismiss="ajax_succ_div"><i class="far fa-times-circle"></i></button>
			<i class="fas fa-bell text-success"></i>
			<strong class="ajax_res_succ text-dark"></strong>
		</div>
		<!-- success-function -->
		<?php if ($this->session->flashdata('valid')) : ?>
			<div class="alert alert-success mt-2">
				<button class="close" data-dismiss="alert"><i class="far fa-times-circle"></i></button>
				<i class="fas fa-bell"></i>
				<strong><?php echo $this->session->flashdata('valid') ?></strong>
			</div>
		<?php endif; ?>
		<!-- failed-function -->
		<?php if ($this->session->flashdata('invalid')) : ?>
			<div class="alert alert-danger mt-2">
				<button class="close" data-dismiss="alert"><i class="far fa-times-circle"></i></button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('invalid') ?></strong>
			</div>
		<?php endif; ?>
		<!-- access-denied -->
		<?php if ($this->session->flashdata('acces_denied')) : ?>
			<div class="alert alert-danger mt-2">
				<button class="close" data-dismiss="alert"><i class="far fa-times-circle"></i></button>
				<i class="fas fa-ban"></i>
				<strong><?php echo $this->session->flashdata('acces_denied') ?></strong>
			</div>
		<?php endif; ?>
		<?php if (form_error('subj') || form_error('body') || form_error('uname') || form_error('pwd') || form_error('sentcode')) : ?>
			<div class="alert alert-danger mt-2">
				<button class="close" data-dismiss="alert"><i class="far fa-times-circle"></i></button>
				<i class="fas fa-exclamation-circle"></i>
				<strong>Please fill the required fields</strong>
			</div>
		<?php endif; ?>
		<?php if (form_error('email')) : ?>
			<div class="alert alert-danger mt-2">
				<button class="close" data-dismiss="alert"><i class="far fa-times-circle"></i></button>
				<strong><?php echo form_error('email') ?></strong>
			</div>
		<?php endif; ?>
	</div>