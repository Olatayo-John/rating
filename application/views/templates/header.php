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

	<nav class="navbar navbar-expand-lg navbar-light fixed-top p-0">

		<!-- <button class="btn menubtn" onclick="opennav()">&#9776;</button> -->

		<div class="logoimg mr-auto m-1">
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

			<div class="navbar-brand text-uppercase font-weight-bolder" style="display: nonee;">
				<a href="<?php echo base_url('account') ?>" style="color:#294a63">
					<span>
						<i class="fas fa-user-circle p_icon"></i>
					</span>
					<?php echo ($this->session->userdata('mr_uname') ? $this->session->userdata('mr_uname') : 'Account') ?></a>
			</div>
		<?php endif; ?>

		<div class="side-nav" id="side-nav">
			<?php $url = $this->uri->segment(1); ?>
			<ul>
				<?php if (!$this->session->userdata('mr_logged_in')) : ?>
					<!-- login -->
					<li class="nav-item">
						<a href="<?php echo base_url('login') ?>" class="nav-link" style="<?php echo ($url == 'login' || $url == 'user' || $url == '') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-user"></i>
							<b>Login</b>
						</a>
					</li>

					<!-- register -->
					<li class="nav-item">
						<a href="<?php echo base_url('register') ?>" class="nav-link" style="<?php echo ($url == 'register') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-user-plus"></i>
							<b>Register</b>
						</a>
					</li>
				<?php endif; ?>

				<!-- shareLink -->
				<?php if ($this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item">
						<a href="<?php echo base_url('share') ?>" class="nav-link" style="<?php echo ($url == 'share') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-link"></i><b>Send Link</b>
						</a>
					</li>
				<?php endif; ?>

				<!-- manageUsers -->
				<?php if ($this->session->userdata('mr_logged_in') && ($this->session->userdata('mr_sadmin') == "1" || $this->session->userdata('mr_admin') == "1")) : ?>
					<li class="nav-item">
						<a href="<?php echo base_url('users') ?>" class="nav-link" style="<?php echo ($url == 'users') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-users"></i><b>Manage Users</b>
						</a>
					</li>
				<?php endif; ?>

				<?php if ($this->session->userdata('mr_logged_in')) : ?>
					<!-- myAccount -->
					<li class="nav-item">
						<a href="<?php echo base_url('account') ?>" class="nav-link" style="<?php echo ($url == 'account' || $url == 'account-edit') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-user-circle"></i><b>My Account</b>
						</a>
					</li>

					<!-- logs -->
					<li class="nav-item">
						<a href="<?php echo base_url('logs') ?>" class="nav-link" style="<?php echo ($url == 'logs') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-chart-area"></i><b>Logs</b>
						</a>
					</li>

					<!-- renewPlan disabled -->
					<li class="nav-item" style="display: none;">
						<a href="<?php echo base_url('plan') ?>" class="nav-link" style="<?php echo ($url == 'plan') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-retweet"></i>bRenew Plan
						</a>
					</li>
					<!--  -->
				<?php endif; ?>

				<!-- payments disabled-->
				<?php if ($this->session->userdata('mr_logged_in') && $this->session->userdata('mr_sadmin') == "1") : ?>
					<li class="nav-item" style="display:none">
						<a href="<?php echo base_url('payments') ?>" class="nav-link" style="<?php echo ($url == 'payments') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-wallet"></i><b>Payments</b>
						</a>
					</li>
				<?php endif; ?>

				<!-- <li class="sub-menu dcjq-parent-li">
					<a href="javascript:;" class="dcjq-parent active">
						<i class="fa fa-calendar-check"></i>
						<span>Appointment</span>
						<span class="dcjq-icon"></span></a>
					<ul class="sub" style="display: block;">
						<li><a href="appointment"><i class="fa fa-list-alt"></i>All</a></li>
						<li><a href="appointment/addNewView"><i class="fa fa-plus-circle"></i>Add</a></li>
						<li><a href="appointment/todays"><i class="fa fa-list-alt"></i>Todays</a></li>
						<li><a href="appointment/upcoming"><i class="fa fa-list-alt"></i>Upcoming</a></li>
						<li><a href="appointment/calendar"><i class="fa fa-list-alt"></i>Calendar</a></li>
						<li><a href="appointment/request"><i class="fa fa-list-alt"></i>Request</a></li>
					</ul>
				</li> -->

				<?php if ($this->session->userdata('mr_logged_in') && $this->session->userdata('mr_sadmin') == "1") : ?>
					<!-- feedbacksFromContactUs -->
					<li class="nav-item">
						<a href="<?php echo base_url('feedbacks') ?>" class="nav-link" style="<?php echo ($url == 'feedbacks') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-comment"></i><b>Feedbacks</b>
						</a>
					</li>

					<!-- actvity logs -->
					<li class="nav-item">
						<a href="<?php echo base_url('activity') ?>" class="nav-link" style="<?php echo ($url == 'activity') ? 'background:white;color:#294a63' : '' ?>">
							<i class="fas fa-clipboard-check"></i><b>Activity Log</b>
						</a>
					</li>
				<?php endif; ?>

				<!-- contactUs -->
				<li class="nav-item">
					<a href="<?php echo base_url('contact') ?>" class="nav-link" style="<?php echo ($url == 'contact') ? 'background:white;color:#294a63' : '' ?>">
						<i class="fas fa-id-card"></i><b>Contact Us</b>
					</a>
				</li>

				<!-- logOUT -->
				<?php if ($this->session->userdata('mr_logged_in')) : ?>
					<li class="nav-item logoutli">
						<a href="<?php echo base_url('logout') ?>" class="nav-link text-danger">
							<i class="fas fa-sign-out-alt"></i><b>Logout</b>
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