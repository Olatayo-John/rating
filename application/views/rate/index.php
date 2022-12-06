<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/rate.css'); ?>">

<div class="set_wrapper">
	<div class="bg-light-custom p-3">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
		<input type="hidden" class="web_id" name="web_id" value="<?php echo $platform->id ?>">
		<input type="hidden" class="web_name" name="web_name" value="<?php echo $platform->web_name ?>">
		<input type="hidden" class="web_link" name="web_link" value="<?php echo $platform->web_link ?>">
		<input type="hidden" class="form_key" name="form_key" value="<?php echo $platform->form_key ?>">

		<h4 class="comp text-uppercase" style=""><?php echo $platform->web_name ?></h4>

		<div class="stars">
			<i class="far fa-star starI" star_value="1"></i>
			<i class="far fa-star starI" star_value="2"></i>
			<i class="far fa-star starI" star_value="3"></i>
			<i class="far fa-star starI" star_value="4"></i>
			<i class="far fa-star starI" star_value="5"></i>
		</div>

		<div>
			<div class="i_div" star_value="1">
				<i class="fas fa-frown text-danger"></i></i><br>
				<strong>Very Bad!</strong>
				<p>You rated us <span class="font-weight-bolder"></span></p>
			</div>
			<div class="i_div" star_value="2">
				<i class="fas fa-frown text-danger"></i><br>
				<strong>Bad!</strong>
				<p>You rated us <span class="font-weight-bolder"></span></p>
			</div>
			<div class="i_div" star_value="3">
				<i class="fas fa-meh text-warning"></i><br>
				<strong>Good!</strong>
				<p>You rated us <span class="font-weight-bolder"></span></p>
			</div>
			<div class="i_div" star_value="4">
				<i class="fas fa-smile text-success"></i><br>
				<strong>Very Good!</strong>
				<p>You rated us <span class="font-weight-bolder"></span></p>
			</div>
			<div class="i_div" star_value="5">
				<i class="fas fa-smile-wink text-success"></i><br>
				<strong>Excellent!</strong>
				<p>You rated us <span class="font-weight-bolder"></span></p>
			</div>
		</div>

		<div class="details bg-light-custom p-3 mt-5">

			<div class="row">
				<div class="form-group col-md-6">
					<label>Name</label>
					<input type="text" class="name form-control" name="review" placeholder="Your Name" value="<?php echo set_value('name') ?>">
				</div>
				<div class="form-group col-md-6">
					<label>Mobile</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">+91</span>
						</div>

						<input type="number" class="mobile form-control" name="mobile" placeholder="Your Mobile" value="<?php echo set_value('mobile') ?>">
					</div>
					<span class="err e_mobile text-danger font-weight-bolder">Invalid mobile length</span>
				</div>
			</div>

			<div class="form-group">
				<label>Review</label><small class="font-weight-bolder"> (optional)</small>
				<textarea class="review form-control" name="review" placeholder="Your review..." rows="3" value="<?php echo set_value('review') ?>"></textarea>
			</div>

			<div class="form-group text-right">
				<button class="btn text-light submitbtn" type="button" style="background: #294a63">Submit</button>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/rating.js'); ?>"></script>
<script type="text/javascript">
	var csrfName = $('.csrf_token').attr('name');
	var csrfHash = $('.csrf_token').val();
	var form_key = $('.form_key').val();

	$(document).ready(function() {

		//collect reviews and some details
		$(document).on('click', '.submitbtn', function(e) {
			e.preventDefault();

			var starv = $(this).val();
			var review = $('.review').val();
			var name = $('.name').val();
			var mobile = $('.mobile').val();
			var web_id = $('.web_id').val();
			var web_name = $('.web_name').val();
			var web_link = $('.web_link').val();

			if (mobile) {
				if (mobile.length < 10 || mobile.length > 10) {
					$('.mobile').css('border-bottom', '2px solid #dc3545');
					$('.e_mobile').show();
					return false;
				} else {
					$('.e_mobile').hide();
					$('.mobile').css('border-bottom', '1px solid #ced4da');
				}
			}

			$.ajax({
				url: "<?php echo base_url('save-rating'); ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					starv: starv,
					review: review,
					name: name,
					mobile: mobile,
					web_name: web_name,
					web_link: web_link,
					web_id: web_id,
					form_key: form_key,
				},
				beforeSend: function() {
					$('.submitmodalbtn').attr('disabled', 'disabled').html('Submitting...').css('cursor', 'not-allowed');

					clearAlert();
				},
				success: function(data) {
					$('.csrf_token').val(data.token);
					$('.submitmodalbtn').removeAttr('disabled').html('Submit').css('cursor', 'pointer');

					if (data.status === "error") {
						window.location.assign(res.redirect);
					} else if (data.status === false) {
						$(".ajax_res_err").append(data.msg);
						$(".ajax_err_div").fadeIn();
					} else if (data.status === true) {

						$('.ajax_res_succ').html(data.msg);
						$('.ajax_succ_div').fadeIn();

						if (parseInt(starv) > 3) {
							// window.open(data.redirectLink, '_blank');
							window.location.assign(data.redirectLink);
						} else {
							window.location.reload();
						}
					}
				},
				error: function() {
					alert('Error saving your feedbacks. Please refresh the page');
					window.location.reload();
				}
			});
		});

	});
</script>