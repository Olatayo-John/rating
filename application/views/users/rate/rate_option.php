<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/rate_option.css'); ?>">
<div class="mt-3 mb-5 mr-3 ml-3 wrapper_div">
	<form action="" method="post" class="form_wrapper">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
		<input type="hidden" class="form_key" name="form_key" value="<?php echo $form_key ?>">

		<?php if ($active->active === "1") : ?>
			<?php if ($web_data->num_rows() == 0) : ?>
				<div class="pt-3">
					<h6 class="text-center text-danger text-uppercase" style="font-weight:bolder">User has no website(s)!!</h6>
				</div>
				<hr>
			<?php endif; ?>
			<?php if ($web_data->num_rows() > 0) : ?>
				<div class="pt-3">
					<h6 class="text-center" style="font-weight:bolder">Pick a website to give your rating(s)</h6>
				</div>
				<hr>
				<div class="all_web_div pl-3 pr-3 pt-2 pb-2" style="display: grid; grid-template-columns:auto auto auto;">
					<?php foreach ($web_data->result_array() as $row) : ?>
						<?php if ($row['active'] === "1") : ?>
							<div class="form-group text-center">
								<a href="<?php echo base_url('user/check_cred?w=' . $row['web_name'] . '&k=' . $form_key); ?>" class="btn wbratebtn text-light" target="_blank" web="<?php echo $row['web_name'] ?>" key="<?php echo $row['form_key'] ?>">
									<?php echo ucfirst($row['web_name']) ?>
								</a>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		<?php elseif ($active->active === "0") : ?>
			<div class="pt-3 text-center">
				<h6 class="text-center text-uppercase" style="font-weight:bolder;color:#294a63">User account is not active!!</h6>
				<a href="<?php echo base_url(); ?>" class="btn text-light mt-4" style="background:#294a63;border-radius:0">
					<i class="fas fa-home mr-2"></i>HOMEPAGE</a>
			</div>
			<hr>
		<?php endif; ?>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click', '.wbratebtn', function(e) {
			e.preventDefault();
			var web = $(this).attr("web");
			var key = $(this).attr("key");
			if ((web == "") && (key == null)) {
				e.preventDefault();
			} else {
				window.location = this.href;
			}
		});

	});
</script>