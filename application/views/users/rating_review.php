<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/rating_review.css'); ?>">
<div class="container">
	<h4 class="text-center font-weight-bolder mb-4 mt-2">REVIEWS</h4>
	<div class="row tab_links d-flex justify-content-between">
		<button class="btn btn-outline-light tabbtn owbtn">Official Website</button>
		<button class="btn btn-outline-light tabbtn fbbtn">Facebook</button>
		<button class="btn btn-outline-light tabbtn gbtn">Google</button>
		<button class="btn btn-outline-light tabbtn gdbtn">Glassdoor</button>
		<button class="btn btn-outline-light tabbtn tpbtn">Trust Pilot</button>
	</div>

	<div class="modal readmodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="card">
						<div class="card-title mb-0">
							<div class="ml-3">
								<span class="font-weight-bolder">E-mail:</span>
								<span class="mb-0 user_email text-secondary"></span>
							</div>
							<div class="ml-3">
								<span class="font-weight-bolder">Mobile:</span>
								<span class="mb-0 mobile text-secondary"></span>
							</div>
							<div class="ml-3">
								<span class="font-weight-bolder">User IP:</span>
								<span class="mb-0 user_ip text-secondary"></span>
							</div>
							<div class="ml-3">
								<span class="font-weight-bolder">Time:</span>
								<span class="mb-0 rated_at"></span>
							</div>
						</div>
						<div class="card-body">
							<p class="card-text mt-0 review_msg text-dark"></p>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button class="btn btn-secondary closemodal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

	<div class="tab_info container-fluid">
		<div class="owdiv" id="owdiv">
			<div class="row">
				<div class="col-md-4">
					<div class="stars mb-2 text-center">
						<h4>THREE STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($ows3 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="mainweb_rating" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="stars">
						<!-- <i class="fas fa-star"></i>
						<i class="fas fa-star"></i> -->
						<h4>TWO STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($ows2 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="mainweb_rating" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="stars text-center">
						<!-- <i class="fas fa-star"></i> -->
						<h4>ONE STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($ows1 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="mainweb_rating" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="fbdiv" id="fbdiv">
			<div class="row">
				<div class="col-md-4">
					<div class="stars mb-2">
						<!-- <i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i> -->
						<h4>THREE STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($fbs3 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="fb_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="stars">
						<!-- <i class="fas fa-star"></i>
						<i class="fas fa-star"></i> -->
						<h4>TWO STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($fbs2 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="fb_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="stars">
						<!-- <i class="fas fa-star"></i> -->
						<h4>ONE STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($fbs1 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="fb_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="gdiv" id="gdiv">
			<div class="row">
				<div class="col-md-4">
					<div class="stars mb-2">
						<!-- <i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i> -->
						<h4>THREE STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($gs3 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="google_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="stars">
						<!-- <i class="fas fa-star"></i>
						<i class="fas fa-star"></i> -->
						<h4>TWO STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($gs2 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="google_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="stars">
						<!-- <i class="fas fa-star"></i> -->
						<h4>ONE STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($gs1 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="google_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="gddiv" id="gddiv">
			<div class="row">
				<div class="col-md-4">
					<div class="stars mb-2">
						<!-- <i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i> -->
						<h4>THREE STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($gds3 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="glassdoor_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="stars">
						<!-- <i class="fas fa-star"></i>
						<i class="fas fa-star"></i> -->
						<h4>TWO STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($gds2 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="glassdoor_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="stars">
						<!-- <i class="fas fa-star"></i> -->
						<h4>ONE STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($gds1 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="glassdoor_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="tpdiv" id="tpdiv">
			<div class="row">
				<div class="col-md-4">
					<div class="stars mb-2">
						<!-- <i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i> -->
						<h4>THREE STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($tps3 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="trustpilot_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="stars">
						<!-- <i class="fas fa-star"></i>
						<i class="fas fa-star"></i> -->
						<h4>TWO STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($tps2 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="trustpilot_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="stars">
						<!-- <i class="fas fa-star"></i> -->
						<h4>ONE STAR</h4><hr style="border-color: #78909C">
					</div>
					<div class="info">
						<?php foreach($tps1 as $row): ?>
						<div class="d-flex flex-row">
							<label>E-mail:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['user_email'] ?></p>
						</div>
						<div class="d-flex flex-row">
							<label>Mobile:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['mobile'] ?></p>
						</div>
						<div class="d-flex flex-row mb-0">
							<label>Message:</label><span style="visibility: hidden;">d</span>
							<p><?php echo $row['review_msg'] ?></p>
						</div>
						<div class="rbtn justify-content-between d-flex">
							<span class="text-danger font-weight-bolder"><?php echo $row['rated_at'] ?></span>
							<button class="btn btn-info readbtn" table="trustpilot_ratings" id="<?php echo $row['id'] ?>">Read</button>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/rating_review.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('button.readbtn').click(function() {
		var id= $(this).attr('id');
		//$(this).removeClass('btn-info').addClass('btn-success');
		var table= $(this).attr('table');
		var csrfName= $('.csrf_token').attr('name');
		var csrfHash= $('.csrf_token').val();
		$.ajax({
			url: "<?php echo base_url("user/get_review"); ?>",
			method: "post",
			dataType: "json",
			data: {
				id:id,
				table:table,
				[csrfName]:csrfHash
			},
			success: function(data){
				$('.csrf_token').val(data.token);
				$('span.user_email').html(data.user_email);
				$('.mobile').html(data.mobile);
				$('.user_ip').html(data.user_ip);
				$('.rated_at').html(data.rated_at);
				$('.star').html(data.star);
				$('.review_msg').html(data.review_msg);
				$('.readmodal').show();
			},
			error: function(data){
				alert("Error showing data");
			}
		});
	});

});
</script>