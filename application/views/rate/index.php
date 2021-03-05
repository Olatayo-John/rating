<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/rating.css'); ?>">

<div class="r_container container mt-5 mb-5">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
	<input type="hidden" class="form_key" name="form_key" value="<?php echo $_GET['k'] ?>">
	<input type="hidden" class="for_link" name="for_link" value="<?php echo $_GET['w'] ?>">
	<input type="hidden" class="b_url" name="b_url" value="<?php echo base_url() ?>">

	<h4 class="comp text-uppercase" style="margin-top: 60px;"><?php echo $_GET['w'] ?></h4>
	<div class="stars">
		<i class="far fa-star star1" name="star1" con="false"></i>
		<i class="far fa-star star2" name="star2" con="false"></i>
		<i class="far fa-star star3" name="star3" con="false"></i>
		<i class="far fa-star star4" name="star4" con="false"></i>
		<i class="far fa-star star5" name="star5" con="false"></i>
	</div>

	<div class="onestar i_div">
		<i class="fas fa-frown text-danger"></i></i><br>
		<strong>Very Bad!</strong>
		<p>You rated us <span class="star_value font-weight-bolder"></span></p>
	</div>
	<div class="twostar i_div">
		<i class="fas fa-frown text-danger"></i><br>
		<strong>Bad!</strong>
		<p>You rated us <span class="star_value font-weight-bolder"></span></p>
	</div>
	<div class="threestar i_div">
		<i class="fas fa-meh text-warning"></i><br>
		<strong>Good!</strong>
		<p>You rated us <span class="star_value font-weight-bolder"></span></p>
	</div>
	<div class="fourstar i_div">
		<i class="fas fa-smile text-success"></i><br>
		<strong>Very Good!</strong>
		<p>You rated us <span class="star_value font-weight-bolder"></span></p>
	</div>
	<div class="fivestar i_div">
		<i class="fas fa-smile-wink text-success"></i><br>
		<strong>Excellent!</strong>
		<p>You rated us <span class="star_value font-weight-bolder"></span></p>
	</div>

	<div class="submit">
		<button class="btn text-light submitbtn" type="button" style="border-radius: 0;background: #294a63 !important;">Submit</button>
	</div>

	<div class="modal msgmodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="form-group">
						<label><span class="text-danger">* </span>Name</label>
						<input type="text" class="name form-control" name="name" placeholder="Your Name" value="<?php echo set_value('name') ?>" required autofocus>
					</div>
					<div class="form-group">
						<label><span class="text-danger">* </span>Mobile</label>
						<input type="number" class="mobile form-control" name="mobile" placeholder="Phone number" style="outline: none;" value="<?php echo set_value('mobile') ?>" required>
						<span class="err e_mobile text-danger font-weight-bolder">Invalid mobile length</span>
					</div>
					<div class="form-group" style="display:none">
						<label>Message</label><small class="font-weight-bolder"> (optional)</small>
						<textarea class="msg form-control" name="msg" placeholder="Your message..." rows="2" style="outline: none;" value="<?php echo set_value('msg') ?>"></textarea>
					</div>
					<div class="submitmsg d-flex justify-content-between">
						<button class="btn btn-secondary closemodalbtn" type="button">Close</button>
						<div class="spinner-border res_spinner" style="position:absolute;right:90px;width:20px;height:20px;top:unset;left:unset;;margin-top:5px;display:none">
							<span class="sr-only">Loading...</span>
						</div>
						<button class="btn text-light submitmodalbtn" name="submitmodalbtn" type="submit" style="background: #294a63 !important;">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal thnkyoumodal" style="padding: auto;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<img src="<?php echo base_url('assets/images/hanks-header.jpg'); ?>" class="img-fluid">
					<div class="thumbsi text-center">
						<i class="fas fa-thumbs-up"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<style type="text/css">
	.form-control:focus {
		border-color: black;
		box-shadow: none;
	}
</style>
<script type="text/javascript" src="<?php echo base_url('assets/js/rating.js'); ?>"></script>
<script type="text/javascript">
	$(window).on('load', function() {
		$('.c_modal').modal('show');
	});
	$(document).ready(function() {
		$('.submitbtn').click(function() {
			// e.preventDefault();
			var starv = $('.submitbtn').val();
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			var form_key = $('.form_key').val();

			$('.msgmodal').modal('show');

		});

		$(document).on('click', '.submitmodalbtn', function() {
			var starv = $('.submitbtn').val();
			var mobile = $('.mobile').val();
			var name = $('.name').val();
			var form_key = $('.form_key').val();
			var for_link = $('.for_link').val();
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();


			if (name == "" || name == null) {
				$('.name').css('border', '2px solid red');
				return false;
			} else {
				$('.name').css('border', '1px solid #294a63');
			}
			if (mobile == "" || mobile == null) {
				$('.mobile').css('border', '2px solid red');
				return false;
			}
			if (mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border', '2px solid red');
				$('.e_mobile').show();
				return false;
			} else {
				$('.e_mobile').hide();
				$('.mobile').css('border', '1px solid #294a63');
			}

			$.ajax({
				url: "<?php echo base_url('user/rating_store'); ?>",
				method: "post",
				dataType: "json",
				data: {
					starv: starv,
					name: name,
					mobile: mobile,
					[csrfName]: csrfHash,
					form_key: form_key,
					for_link: for_link,
				},
				beforeSend: function() {
					$('.submitmodalbtn').attr("disabled", "disabled");
					$('.res_spinner').fadeIn();
				},
				success: function(data) {
					$('.csrf_token').val(data.token);

					if (data.res === "failed") {
						$(".res_spinner,.ajax_succ_div").fadeOut();
						$('.ajax_res_err').html(data.res_msg);
						$('.ajax_err_div').fadeIn();
					} else if (data.res === "succ") {
						$(".res_spinner,.ajax_err_div").fadeOut();
						$('.ajax_res_succ').html(data.res_msg);
						$('.ajax_succ_div').fadeIn();

						if (data.web_link == "" || data.web_link == null) {
							$('.submitmodalbtn').hide();
							window.location.assign($(".b_url").val());
						} else {
							window.location.assign(data.web_link);
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