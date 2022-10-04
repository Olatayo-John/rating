<!DOCTYPE html>
<html>

<head>
	<title>

		<?php echo (isset($title)) ? ucwords($title) :  $this->config->item('web_name'); ?>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.0/gsap.min.js"></script>

	<link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
	<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>

	<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>

	<link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">

	<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
	<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/export/bootstrap-table-export.min.js"></script>

	<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/print/bootstrap-table-print.min.js"></script>

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
	<nav class="navbar navbar-expand-lg navbar-light fixed-top">

		<!-- <button class="btn menubtn" onclick="opennav()">&#9776;</button> -->
		<button class="btn menubtn" onclick="closenav()">&#9776;</button>

		<div class="logoimg mr-auto ml-3">
			<img src="<?php echo base_url("assets/images/logo_dark.png") ?>" class="navbar-label">
		</div>
		<?php print_r($_SESSION) ?>

		<?php if ($this->session->userdata('mr_logged_in')) : ?>
			<?php if ($this->session->userdata('mr_sub') == "0") : ?>
				<div class="text-danger mr-3">
					<strong><i class="fas fa-exclamation-circle text-danger mr-1"></i>Inactive subscription</strong>
				</div>
			<?php endif; ?>
			<?php if ($this->session->userdata('mr_sub') == "1") : ?>
				<div class="text-success mr-3">
					<strong><i class="fas fa-exclamation-circle text-success mr-1"></i>Active subscription</strong>
				</div>
			<?php endif; ?>

			<div class="navbar-brand text-uppercase font-weight-bolder" style="font-size: 1.1rem;display: nonem;">
				<a href="<?php echo base_url('account') ?>" style="color:#294a63">
					<span>
						<i class="fas fa-user-circle p_icon"></i>
					</span>
					<?php echo ($this->session->userdata('mr_uname') ? $this->session->userdata('mr_uname') : '') ?></a>
			</div>
		<?php endif; ?>

		<div class="side-nav" id="side-nav">
			<?php $url = $this->uri->segment(1); ?>
			<ul>
				<?php if (!$this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item">
						<a href="<?php echo base_url('login') ?>" class="nav-link" style="<?php echo ($url == 'login') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-user" style="<?php echo ($url == 'login') ? 'color:#294a63' : 'color:#fff' ?>"></i>Login
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url('register') ?>" class="nav-link" style="<?php echo ($url == 'register') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-user-plus" style="<?php echo ($url == 'register') ? 'color:#294a63' : 'color:#fff' ?>"></i>Register
						</a>
					</li>
				<?php endif; ?>

				<?php if ($this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item">
						<a href="<?php echo base_url('share') ?>" class="nav-link" style="<?php echo ($url == 'share') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-link" style="<?php echo ($url == 'share') ? 'color:#294a63' : 'color:#fff' ?>"></i>Send Link
						</a>
					</li>
				<?php endif; ?>

				<?php if ($this->session->userdata('mr_logged_in') && ($this->session->userdata('mr_sadmin') == "1" || $this->session->userdata('mr_admin') == "1")) : ?>
					<li class="nav-item">
						<a href="<?php echo base_url('users') ?>" class="nav-link" style="<?php echo ($url == 'users') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-users" style="<?php echo ($url == 'users') ? 'color:#294a63' : 'color:#fff' ?>"></i>Manage Users
						</a>
					</li>
				<?php endif; ?>

				<?php if ($this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item">
						<a href="<?php echo base_url('account') ?>" class="nav-link" style="<?php echo ($url == 'account') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-user-circle" style="<?php echo ($url == 'account') ? 'color:#294a63' : 'color:#fff' ?>"></i>My Account
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo base_url('logs') ?>" class="nav-link" style="<?php echo ($url == 'logs') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-chart-area" style="<?php echo ($url == 'logs') ? 'color:#294a63' : 'color:#fff' ?>"></i>Logs
						</a>
					</li>

					<li class="nav-item" style="display: none;">
						<a href="<?php echo base_url('plan') ?>" class="nav-link" style="<?php echo ($url == 'plan') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-retweet" style="<?php echo ($url == 'plan') ? 'color:#294a63' : 'color:#fff' ?>"></i>Renew Plan
						</a>
					</li>
				<?php endif; ?>

				<?php if ($this->session->userdata('mr_logged_in') && $this->session->userdata('mr_sadmin') == "1") : ?>
					<li class="nav-item" style="display:none">
						<a href="<?php echo base_url('payments') ?>" class="nav-link" style="<?php echo ($url == 'payments') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-wallet" style="<?php echo ($url == 'payments') ? 'color:#294a63' : 'color:#fff' ?>"></i>Payments
						</a>
					</li>
				<?php endif; ?>

				<li class="nav-item">
					<a href="<?php echo base_url('contact') ?>" class="nav-link" style="<?php echo ($url == 'contact') ? 'background:white;color:#294a63' : '' ?>">
						<i class="fas fa-id-card" style="<?php echo ($url == 'contact') ? 'color:#294a63' : 'color:#fff' ?>"></i>Contact Us
					</a>
				</li>

				<?php if ($this->session->userdata('mr_logged_in') && $this->session->userdata('mr_sadmin') == "1") : ?>
					<li class="nav-item">
						<a href="<?php echo base_url('feedbacks') ?>" class="nav-link" style="<?php echo ($url == 'feedbacks') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-comment" style="<?php echo ($url == 'feedbacks') ? 'color:#294a63' : 'color:#fff' ?>"></i>Feedbacks
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo base_url('activity') ?>" class="nav-link" style="<?php echo ($url == 'activity') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-clipboard-check" style="<?php echo ($url == 'activity') ? 'color:#294a63' : 'color:#fff' ?>"></i>Activity Log
						</a>
					</li>
				<?php endif; ?>

				<?php if ($this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item">
						<a href="<?php echo base_url('logout') ?>" class="nav-link text-danger">
							<i class="fas fa-sign-out-alt"></i>Logout
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>

	</nav>

	<div class="container">
		<!-- testing div -->
		<!-- <div class="alerterror">
			<strong>Test notification Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur, ratione repudiandae esse repellendus est expedita, quod aut at odio odit ipsam vel! Lorem, ipsum dolor sitss amet consectetur adipisicing elit. Consequatur, ratione repudiandae esse repellendus est expedita, quod aut at odio odit ipsam vel! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur, ratione repudiandae esse repellendus est expedita, quod aut at odio odit ipsam vel!</strong>
		</div> -->

		<!-- ajax-failed -->
		<div class="ajax_alert_div ajax_err_div" style="padding:8px;display:none;z-index: 9999;">
			<strong class="ajax_res_err text-dark"></strong>
		</div>

		<!-- ajax-success -->
		<div class="ajax_alert_div ajax_succ_div" style="padding:8px;display:none;z-index: 9999;">
			<strong class="ajax_res_succ text-dark"></strong>
		</div>

		<!-- success-function -->
		<?php if ($this->session->flashdata('valid')) : ?>
			<div class="alertsuccess">
				<strong><?php echo $this->session->flashdata('valid') ?></strong>
			</div>
		<?php endif; ?>

		<!-- failed-function -->
		<?php if ($this->session->flashdata('invalid')) : ?>
			<div class="alerterror">
				<strong><?php echo $this->session->flashdata('invalid') ?></strong>
			</div>
		<?php endif; ?>

		<!-- access-denied -->
		<?php if ($this->session->flashdata('acces_denied')) : ?>
			<div class="alerterror">
				<strong><?php echo $this->session->flashdata('acces_denied') ?></strong>
			</div>
		<?php endif; ?>

		<?php if (validation_errors()) : ?>
			<div class="alerterror">
				<strong><?php echo validation_errors(); ?></strong>
			</div>
		<?php endif; ?>
	</div>

	<div id="content">