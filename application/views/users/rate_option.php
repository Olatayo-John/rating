<!-- <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="icon" href="<?php echo base_url('assets/images/logo_dark.png') ?>"> -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/rate_option.css'); ?>">
<div class="mt-3 pb-3 mr-3 ml-3 wrapper_div">
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
				<div class="all_web_div pl-5">
					<?php foreach ($web_data->result_array() as $row) : ?>
						<?php if ($row['active'] === "1") : ?>
							<div class="form-group">
								<a href="<?php echo base_url('user/check_cred?w=' . $row['web_name'] . '&k=' . $form_key); ?>" class="btn wbratebtn text-light" target="_blank" web="<?php echo $row['web_name'] ?>" key="<?php echo $row['form_key'] ?>" style="background:#141E30">
									<?php echo ucfirst($row['web_name']) ?>
								</a>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		<?php elseif ($active->active === "0") : ?>
			<div class="pt-3">
				<h6 class="text-center text-danger text-uppercase" style="font-weight:bolder">User account is not active!!</h6>
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

			console.log(web);
			console.log(key);
		});

	});
</script>