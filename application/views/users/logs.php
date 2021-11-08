<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/logs.css'); ?>">
<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<div class="log_wrapper">
	<div class="rr_wrapper pt-2 pb-2">
		<div class="rr_header">
			<div>
				<h4>Ratings Received</h4>
				<!-- <hr> -->
			</div>
			<div class="drop_i">
				<i class="fas fa-caret-down rr_i" inview="showing"></i>
			</div>
		</div>
		<div class="rr_innerwrapper">
			<?php include("logs/ratings-received.php") ?>
		</div>
	</div>

	<div class="ls_wrapper pt-2 pb-2 mt-3">
		<div class="ls_header">
			<div>
				<h4>Links Sent</h4>
				<!-- <hr> -->
			</div>
			<div class="drop_i">
				<i class="fas fa-caret-down ls_i" inview="hidden"></i>
			</div>
		</div>
		<div class="ls_innerwrapper">
			<?php include("logs/links-sent.php") ?>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/logs.js'); ?>"></script>