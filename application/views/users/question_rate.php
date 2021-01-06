<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="icon" href="<?php echo base_url('assets/images/logo_dark.png') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/question_rate.css'); ?>">

<?php if ($this->session->flashdata('ques_r_err')) : ?>
	<div class="alert alert-danger">
		<button class="close" data-dismiss="alert">&times;</button>
		<i class="fas fa-exclamation-circle"></i>
		<strong><?php echo $this->session->flashdata('ques_r_err') ?></strong>
	</div>
<?php endif; ?>
<?php if ($this->session->flashdata('ques_r_succ')) : ?>
	<div class="alert alert-success">
		<button class="close" data-dismiss="alert">&times;</button>
		<i class="fas fa-exclamation-circle"></i>
		<strong><?php echo $this->session->flashdata('ques_r_succ') ?></strong>
	</div>
<?php endif; ?>
<div class="col-md-10 container wrapper_div">
	<form action="<?php echo base_url('user/save_questions/').$form_key; ?>" method="post" class="form_wrapper">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
		<input type="hidden" class="form_key" name="form_key" value="<?php echo $form_key ?>">
		<h5 class="text-center">Your feedback</h5><hr>
		<div class="form-group">
			<p>
				<span class="no">1.</span> Are you aware that your city is participating in Swachh Survekshan 2021? Do you know the rank of
				your city in Swachh Survekshan-2020?
			</p>
			<div class="form-group">
				<input type="radio" name="ques_one" class="ques_one opt ques mr-1" value="Yes" index="0"><span class="op">Yes</span>
				<input type="radio" name="ques_one" class="ques_one opt ques mr-1" value="No" index="0"><span class="op">No</span>
			</div>
		</div>
		<div class="form-group">
			<p>
				<span class="no">2.</span> How many marks would you like to give to your city on the cleanliness level of your neighbourhood –
				Out of 100?
			</p>
			<div class="form-group">
				<input type="number" name="ques_two" class="ques_two ques form-control" placeholder="0 to 100">
				<div class="ques_two_err text-danger">Invalid input</div>
			</div>
		</div>
		<div class="form-group">
			<p>
				<span class="no">3.</span> How many marks would you like to give to your city on the cleanliness level of your commercial/
				public areas – Out of 100?
			</p>
			<div class="form-group">
				<input type="number" name="ques_three" class="ques_three ques form-control" placeholder="0 to 100">
				<div class="ques_three_err text-danger">Invalid input</div>
			</div>
		</div>
		<div class="form-group">
			<p>
				<span class="no">4.</span> Whether you are always asked to give segregated dry and wet waste by your waste collector?
			</p>
			<div class="form-group">
				<input type="radio" name="ques_four" class="ques_four opt ques mr-1" value="Yes" index="3"><span class="op">Yes, always</span>
				<input type="radio" name="ques_four" class="ques_four opt ques mr-1" value="Sometimes" index="3"><span class="op">Yes but somtimes</span>
				<input type="radio" name="ques_four" class="ques_four opt ques mr-1" value="Never" index="3"><span class="op">Never</span>
			</div>
		</div>
		<div class="form-group">
			<p>
				<span class="no">5.</span> How many marks would you like to give to your city on the cleanliness level of Public or
				Community toilet or Urinals of your cities – Out of 100?

			</p>
			<div class="form-group">
				<input type="number" name="ques_five" class="ques_five ques form-control" placeholder="0 to 100">
				<div class="ques_five_err text-danger">Invalid input</div>
			</div>
		</div>
		<div class="form-group">
			<p>
				<span class="no">6.</span> Do you know you can search nearest <strong>Public Toilet on Google?</strong>
			</p>
			<div class="form-group">
				<input type="radio" name="ques_six" class="ques_six opt ques mr-1" value="Yes" index="5"><span class="op">Yes</span>
				<input type="radio" name="ques_six" class="ques_six opt ques mr-1" value="No" index="5"><span class="op">No</span>
			</div>
		</div>
		<div class="form-group">
			<p>
				<span class="no">7.</span> Do you know you can use <strong>SwachhataApp/local App </strong> to escalate your complaints around Swachhata?
			</p>
			<div class="form-group">
				<input type="radio" name="ques_seven" class="ques_seven opt ques mr-1" value="Yes" index="6"><span class="op">Yes</span>
				<input type="radio" name="ques_seven" class="ques_seven opt ques mr-1" value="No" index="6"><span class="op">No</span>
			</div>
		</div>
		<div class="form-group text-center mt-3 mb-3">
			<button class="btn btn-dark submit_btn" type="submit">Submit</button>
		</div>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('.ques_two').keyup(function() {
			if ($(this).val() > 100 || $(this).val() < 0) {
				$('.ques_two').css('border-bottom','2px solid red');
				$('.ques_two_err').show();
				return false;
			}else{
				$('.ques_two').css('border-bottom','1px solid black');
				$('.ques_two_err').hide();
			}
		});

		$('.ques_three').keyup(function() {
			if ($(this).val() > 100 || $(this).val() < 0) {
				$('.ques_three').css('border-bottom','2px solid red');
				$('.ques_three_err').show();
				return false;
			}else{
				$('.ques_three').css('border-bottom','1px solid black');
				$('.ques_three_err').hide();
			}
		});

		$('.ques_five').keyup(function() {
			if ($(this).val() > 100 || $(this).val() < 0) {
				$('.ques_five').css('border-bottom','2px solid red');
				$('.ques_five_err').show();
				return false;
			}else{
				$('.ques_five').css('border-bottom','1px solid black');
				$('.ques_five_err').hide();
			}
		});

		$(document).on('click','.submit_btn',function(e) {
			// e.preventDefault();
			var ques_one= $('.ques_one').val();
			var ques_two= $('.ques_two').val();
			var ques_three= $('.ques_three').val();
			var ques_four= $('.ques_four').val();
			var ques_five= $('.ques_five').val();
			var ques_six= $('.ques_six').val();
			var ques_seven= $('.ques_seven').val();

			if (ques_one == ""||ques_two == ""||ques_three == ""||ques_four == ""||ques_five == ""||ques_six == ""||ques_seven == "") {
				alert('Please fill all fields');
				return false;
			}

			if (ques_two !== "") {
				if (ques_two > 100 || ques_two < 0) {
					$('.ques_two').css('border-bottom','2px solid red');
					$('.ques_two_err').show();
					return false;
				}else{
					$('.ques_two').css('border-bottom','1px solid black');
					$('.ques_two_err').hide();
				}
			}
			if (ques_three !== "") {
				if (ques_three > 100 || ques_three < 0) {
					$('.ques_three').css('border-bottom','2px solid red');
					$('.ques_three_err').show();
					return false;
				}else{
					$('.ques_three').css('border-bottom','1px solid black');
					$('.ques_three_err').hide();
				}
			}
			if (ques_five !== "") {
				if (ques_five > 100 || ques_five < 0) {
					$('.ques_five').css('border-bottom','2px solid red');
					$('.ques_five_err').show();
					return false;
				}else{
					$('.ques_five').css('border-bottom','1px solid black');
					$('.ques_five_err').hide();
				}
			}

			$.ajax({
				beforSend: function() {
					$('.submit_btn').html('Submitting....');
					$('.submit_btn').removeClass('btn-dark').addClass('btn-danger');
					$('.submit_btn').css('cursor','not-allowed');
				}
			});
		});

	});
</script>