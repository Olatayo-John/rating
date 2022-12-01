<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/logs.css'); ?>">
<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<div class="log_wrapper">

	<!-- tabLinks -->
	<div class="tab_div bg-light-custom">
		<a href="#myLogs" class="tab_link" id="myLogs" tabFormName="myLogs"><?php echo ($this->session->userdata('mr_uname')); ?></a>
		<?php if ($this->session->userdata('mr_sadmin') === '1' || $this->session->userdata('mr_admin') === '1') : ?>
			<a href="#userLogs" class="tab_link" id="userLogs" tabFormName="userLogs">
				<?php echo ($this->session->userdata('mr_sadmin') === '1') ? 'All' : 'Users' ?>
			</a>
		<?php endif; ?>
	</div>
	<!--  -->

	<!-- tabs-->
	<div class="info_div bg-light-custom myLogs_outer">
		<div class="myLogs p-3" id="myLogs">
			<div class="rr_wrapper">
				<div class="rr_header" id="toggleHeader" inview="hidden" iName="rr_i" tabName="rr_innerwrapper">
					<h4>Ratings</h4>
					<i class="fas fa-caret-up rr_i"></i>
				</div>
				<div class="rr_innerwrapper">
					<?php include("logs/ratings-received.php"); ?>
				</div>
			</div>

			<div class="ls_wrapper">
				<div class="ls_header" id="toggleHeader" inview="hidden" iName="ls_i" tabName="ls_innerwrapper">
					<h4>Links</h4>
					<i class="fas fa-caret-up ls_i"></i>
				</div>
				<div class="ls_innerwrapper">
					<?php include("logs/links-sent.php"); ?>
				</div>
			</div>

			<div class="web_wrapper">
				<div class="web_header" id="toggleHeader" inview="hidden" iName="web_i" tabName="web_innerwrapper">
					<h4>Platforms</h4>
					<i class="fas fa-caret-up web_i"></i>
				</div>
				<div class="web_innerwrapper">
					<?php include("logs/website.php"); ?>
				</div>
			</div>
		</div>
	</div>

	<?php if ($this->session->userdata('mr_sadmin') === '1' || $this->session->userdata('mr_admin') === '1') : ?>
		<div class="info_div bg-light-custom userLogs_outer" style="display:none;">
			<div class="userLogs p-3" id="userLogs">
				<div class="users_rr_wrapper">
					<div class="users_rr_header" id="toggleHeader" inview="hidden" iName="users_rr_i" tabName="users_rr_innerwrapper">
						<h4>Ratings</h4>
						<i class="fas fa-caret-up users_rr_i"></i>
					</div>
					<div class="users_rr_innerwrapper">
						<?php include("logs/users-ratings-received.php"); ?>
					</div>
				</div>

				<div class="users_ls_wrapper">
					<div class="users_ls_header" id="toggleHeader" inview="hidden" iName="users_ls_i" tabName="users_ls_innerwrapper">
						<h4>Links</h4>
						<i class="fas fa-caret-up users_ls_i"></i>
					</div>
					<div class="users_ls_innerwrapper">
						<?php include("logs/users-links-sent.php"); ?>
					</div>
				</div>

				<div class="users_web_wrapper">
					<div class="users_web_header" id="toggleHeader" inview="hidden" iName="users_web_i" tabName="users_web_innerwrapper">
						<h4>Platforms</h4>
						<i class="fas fa-caret-up users_web_i"></i>
					</div>
					<div class="users_web_innerwrapper">
						<?php include("logs/users-website.php"); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<!--  -->
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/logs.js'); ?>"></script>