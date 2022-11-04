<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/users.css'); ?>">

<?php if ($this->session->userdata('mr_sadmin') === "1") : ?>
	<div class="p-3 bg-light-custom" style="margin-top: 74px;">
		<?php include("users/sadminusers.php") ?>
	</div>
<?php endif; ?>

<?php if ($this->session->userdata('mr_admin') === "1") : ?>
	<div class="p-3 bg-light-custom" style="margin-top: 74px;">
		<?php include("users/adminusers.php") ?>
	</div>
<?php endif; ?>



<script type="text/javascript" src="<?php echo base_url('assets/js/users.js'); ?>"></script>