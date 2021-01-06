<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/rating.css'); ?>">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="icon" href="<?php echo base_url('assets/images/logo_dark.png') ?>">
<div class="container">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
	<input type="hidden" class="form_key" name="form_key" value="<?php echo $form_key ?>">
	<input type="hidden" class="for_link" name="for_link" value="tp_r">

	<h4 class="comp">Trust Pilot Rating</h4>
	<div class="stars">
		<i class="far fa-star star1" name="star1" con="false"></i>
		<i class="far fa-star star2" name="star2" con="false"></i>
		<i class="far fa-star star3" name="star3" con="false"></i>
		<i class="far fa-star star4" name="star4" con="false"></i>
		<i class="far fa-star star5" name="star5" con="false"></i>
	</div>

	<div class="onestar">
		<i class="fas fa-frown text-danger"></i></i><br>
		<strong>Very Bad!</strong>
		<p>You rated us <span class="star_value font-weight-bolder"></span></p>
	</div>
	<div class="twostar">
		<i class="fas fa-frown text-danger"></i><br>
		<strong>Bad!</strong>
		<p>You rated us <span class="star_value font-weight-bolder"></span></p>
	</div>
	<div class="threestar">
		<i class="fas fa-meh text-warning"></i><br>
		<strong>Good!</strong>
		<p>You rated us <span class="star_value font-weight-bolder"></span></p>
	</div>
	<div class="fourstar">
		<i class="fas fa-smile text-success"></i><br>
		<strong>Very Good!</strong>
		<p>You rated us <span class="star_value font-weight-bolder"></span></p>
	</div>
	<div class="fivestar">
		<i class="fas fa-smile-wink text-success"></i><br>
		<strong>Excellent!</strong>
		<p>You rated us <span class="star_value font-weight-bolder"></span></p>
	</div>

	<div class="submit">
		<button class="btn btn-info submitbtn" type="button" style="border-radius: 0;">Submit</button>
	</div>

	<div class="modal msgmodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header d-flex justify-content-center">
					<label class="text-info">What would you like us to improve</label>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="name form-control" name="name" placeholder="Your Name" value="<?php echo set_value('name') ?>">
					</div>
					<div class="form-group">
						<label>Mobile</label>
						<input type="number" class="mobile form-control" name="mobile" placeholder="Phone number" style="outline: none;" value="<?php echo set_value('mobile') ?>">
						<span class="err e_mobile text-danger font-weight-bolder">Invalid mobile length</span>
					</div>
					<div class="form-group">
						<label>Message</label><small class="font-weight-bolder"> (optional)</small>
						<textarea class="msg form-control" name="msg" placeholder="Your message..." rows="2" style="outline: none;" value="<?php echo set_value('msg') ?>"></textarea>
					</div>
					<div class="submitmsg d-flex justify-content-between">
						<button class="btn btn-secondary closemodalbtn" type="button">Close</button>
						<button class="btn btn-success submitmodalbtn" name="submitmodalbtn" type="submit">Submit</button>
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
	$(window).on('load',function(){
		$('.c_modal').modal('show');
	});
	$(document).ready(function() {
		$('.submitbtn').click(function() {
		// e.preventDefault();
		var starv= $('.submitbtn').val();
		var csrfName= $('.csrf_token').attr('name');
		var csrfHash= $('.csrf_token').val();
		var form_key= $('.form_key').val();

		$('.msgmodal').modal('show');

	});

		$(document).on('click','.submitmodalbtn',function() {
			var starv= $('.submitbtn').val();
			var msg= $('.msg').val();
			var mobile= $('.mobile').val();
			var name= $('.name').val();
			var tbl_name= 'trustpilot_ratings';
			var form_key= $('.form_key').val();
			var for_link= $('.for_link').val();
			var csrfName= $('.csrf_token').attr('name');
			var csrfHash= $('.csrf_token').val();

			if (mobile == ""|| mobile == null) {
				$('.mobile').css('border','2px solid red');
				return false;
			}if (mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border','2px solid red');
				$('.e_mobile').show();
				return false;
			}else{
				$('.e_mobile').hide();
				$('.mobile').css('border','2px solid green');
			}if (name == ""|| name == null) {
				$('.name').css('border','2px solid red');
				return false;
			}else{
				$('.name').css('border','2px solid green');
			}

			$.ajax({
				url: "<?php echo base_url('user/rating_store'); ?>",
				method: "post",
				dataType: "json",
				data: {
					starv:starv,
					msg:msg,
					name:name,
					mobile:mobile,
					[csrfName]:csrfHash,
					tbl_name:tbl_name,
					form_key:form_key,
					for_link:for_link,
				},
				beforeSend: function() {
					$('.submitmodalbtn').removeClass("btn-info").addClass("btn-danger");
					$('.submitmodalbtn').html("Submitting...");
					$('.submitmodalbtn').attr("disabled","disabled");
					$('.submitmodalbtn').css("cursor","not-allowed");
				},
				success: function(data){
					$('.submitmodalbtn,.submitbtn').html("Submitted");
					$('.submitmodalbtn').removeClass("btn-danger").addClass("btn-success");
					$('.submitmodalbtn,.submitbtn').attr("disabled","disabled");
					if (starv <= 3) {
						$('.msgmodal').modal('hide');
						$('.thnkyoumodal').modal('show');
					}else{
						if (data.tp == "") {
							$('.msgmodal').modal('hide');
							$('.thnkyoumodal').modal('show');
						}else{
							window.location.assign(data.tp);
						}
					}
				},
				error: function(){
					$('.submitmodalbtn').removeClass("btn-danger").addClass("btn-success");
					$('.submitmodalbtn').html("Submit");
					alert('Please refresh the page');
				}
			});
		});

	});
</script>