<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/logs.css'); ?>">
<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<div class="log_wrapper">
	<div class="rr_wrapper p-3 bg-light-custom mb-3">
		<div class="rr_header" id="toggleHeader" inview="showing" iName="rr_i" tabName="rr_innerwrapper">
			<h4>Ratings</h4>
			<i class="fas fa-caret-down rr_i"></i>
		</div>
		<div class="rr_innerwrapper">
			<?php include("logs/ratings-received.php"); ?>
		</div>
	</div>

	<div class="ls_wrapper p-3 bg-light-custom mb-3">
		<div class="ls_header" id="toggleHeader" inview="hidden" iName="ls_i" tabName="ls_innerwrapper">
			<h4>Links</h4>
			<i class="fas fa-caret-up ls_i"></i>
		</div>
		<div class="ls_innerwrapper">
			<?php include("logs/links-sent.php"); ?>
		</div>
	</div>

	<div class="web_wrapper p-3 bg-light-custom mb-3">
		<div class="web_header" id="toggleHeader" inview="hidden" iName="web_i" tabName="web_innerwrapper">
			<h4>Websites</h4>
			<i class="fas fa-caret-up web_i"></i>
		</div>
		<div class="web_innerwrapper">
			<?php include("logs/website.php"); ?>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/logs.js'); ?>"></script>