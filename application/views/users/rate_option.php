<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="icon" href="<?php echo base_url('assets/images/logo_dark.png') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/rate_option.css'); ?>">
<div class="col-md-4 container wrapper_div">
	<form action="" method="post" class="form_wrapper">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
		<input type="hidden" class="form_key" name="form_key" value="<?php echo $form_key ?>">
		<h6 class="text-center mt-3" for="rate">Pick a website to give your rating</h6>
		<hr>
		<div class="form-group">
			<a href="<?php echo base_url('user/official/'.$form_key); ?>" class="btn ow" target="_blank">
			Official Website</a>
		</div>
		<div class="form-group">
			<a href="<?php echo base_url('user/facebook/'.$form_key); ?>" class="btn fb" target="_blank">
				<i class="fab fa-facebook mr-2"></i>Facebook</a>
			</div>
			<div class="form-group">
				<a href="<?php echo base_url('user/google/'.$form_key); ?>" class="btn fb" target="_blank">
					<i class="fab fa-google mr-2"></i>Google</a>
				</div>
				<div class="form-group">
					<a href="<?php echo base_url('user/glassdoor/'.$form_key); ?>" class="btn fb" target="_blank">
					Glassdoor</a>
				</div>
				<div class="form-group">
					<a href="<?php echo base_url('user/trustpilot/'.$form_key); ?>" class="btn fb" target="_blank">
					Trust Pilot</a>
				</div>
				<div class="form-group">
					<!-- <button class="btn btn-success btn-block" type="submit">
						<i class="fas fa-arrow-alt-circle-right mr-2"></i>Go</button>
					</div> -->
				</form>
			</div>

			<script type="text/javascript">
				$(document).ready(function() {
					$(document).on('click','.sub_btn',function(e) {
						e.preventDefault();
						var key = $('.form_key').val();
						console.log(new_url);
					});
					
				});
			</script>