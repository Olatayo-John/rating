<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/index.css'); ?>">
<div class="container mt-4">
	<div class="emailmodal modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" method="post" id="upload_csv">
					<div class="modal-body">
						<h6 class="font-weight-bolder text-danger">
							*CSV file to be imported must only contains emails<br>
							*CSV file must have header of "Email"
						</h6>
						<input type="file" name="csv_file" id="csv_file" accept=".csv">
					</div>
					<div class="modal-footer justify-content-between">
						<button class="btn btn-secondary closebtn" type="button">Close</button>
						<button class="btn btn-success importbtn" type="submit">Import</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<h4 class="text-center text-uppercase text-danger">Generate Link</h4>
	<hr>
	<div class="row">
		<div class="col-md-6">
			<h5 class="text-left text-light">Choose website link to rate</h5>
			<div class="form-check">
				<input type="radio" class="form-check-input" name="link" value="google">
				<label class="form-check-label" for="google">Google</label>
			</div>
			<div class="form-check">
				<input type="radio" class="form-check-input" name="link" value="facebook">
				<label class="form-check-label" for="facebook">Facebook</label>
			</div>
			<div class="form-check">
				<input type="radio" class="form-check-input" name="link" value="glassdoor">
				<label class="form-check-label" for="glassdoor">Glassdoor</label>
			</div>
			<div class="form-check">
				<input type="radio" class="form-check-input" name="link" value="trust_pilot">
				<label class="form-check-label" for="trust_pilot">Trust Pilot</label>
			</div>
			<div class="form-check">
				<input type="radio" class="form-check-input" name="link" value="mainweb">
				<label class="form-check-label" for="mainweb">Official Website</label>
			</div>
			<div class="text-left mt-3">
				<button class="btn text-light genlinkbtn" type="button" style="color: #ffff;border: 1px solid #fff">Generate Link</button>
			</div><br>
		</div>
		<div class="col-md-6">
			<div class="">
				<form action="<?php echo base_url('user/send_link'); ?>" method="post" id="gen_link_form" class="gen_link_form">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">
					<input type="hidden" name="userid" value="<?php echo $this->session->userdata('mr_id'); ?>" class="userid">
					<div class="import text-right d-flex justify-content-between">
						<button class="btn btn-info singlemailsend" type="button" style="display: none;">Send as Single</button>
						<input type="hidden" name="link_for" class="link_for">
						<button class="btn btn-info importemail" type="button">Import emails in CSV format</button>
					</div>
					<div class="request text-light" name="request"></div>
					<div class="form-group">
						<label class="text-warning">E-mail:</label>
						<input type="email" name="email" class="form-control email" placeholder="example@domain.com" id="email">
						<select class="form-control email_select" name="email_select" id="email_select" style="display: none;" readonly conn="false">
							<option></option>
						</select>
					</div>
					<div class="form-group">
						<label class="text-warning">Subject:</label>
						<input type="text" name="subj" class="form-control subj">
					</div>
					<div class="form-group">
						<label class="text-warning">Body:</label>
						<textarea class="form-control bdy" rows="8" name="bdy"></textarea>
					</div>
					<div class="sendlinkdiv">
						<button class="btn btn-success sendlinkbtn">Send</button>
						<button class="btn btn-success sendmultiplelinkbtn" style="display: none;">Send</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/index.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click', '.form-check-input', function() {
			var val = $(this).val();
			$('button.genlinkbtn').val(val);
			$('button.genlinkbtn').show();
		});

		$('.genlinkbtn').click(function() {
			var btnval = $('.genlinkbtn').val();
			var id = $('.userid').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();
			$.ajax({
				url: "<?php echo base_url('user/get_link'); ?>",
				method: "post",
				data: {
					id: id,
					btnval: btnval,
					[csrfName]: csrfHash
				},
				dataType: "json",
				success: function(data) {
					$('.csrf_hash').val(data.token);
					$('.gen_link_form').show();
					if (btnval == "google") {
						$('.subj').val("Rate our Google Website");
						$('.link_for').val('Google');
						$(".bdy").load("<?php echo base_url("body.txt"); ?>");
					}
					if (btnval == "facebook") {
						$('.subj').val("Rate our Facebook Website");
						$('.link_for').val('Facebook');
						$(".bdy").load("<?php echo base_url("body.txt"); ?>");
					}
					if (btnval == "glassdoor") {
						$('.subj').val("Rate our Glassdoor Website");
						$('.link_for').val('Glassdoor');
						$(".bdy").load("<?php echo base_url("body.txt"); ?>");
					}
					if (btnval == "trust_pilot") {
						$('.subj').val("Rate our Trust Pilot Website");
						$('.link_for').val('Trust Pilot');
						$(".bdy").load("<?php echo base_url("body.txt"); ?>");
					}
					if (btnval == "mainweb") {
						$('.subj').val("Rate our Official Website");
						$('.link_for').val('Official Website');
						$(".bdy").load("<?php echo base_url("body.txt"); ?>");
					}
				},
				error: function(data) {
					window.location.reload();
				}
			});
		});

		$('.sendlinkbtn').click(function() {
			var email = $('.email').val();
			var subj = $('.subj').val();
			var body = $('.bdy').val();

			if (email == "" || email == null) {
				$('.email').css('border', '2px solid red');
				return false;
			} else {
				$('.email').css('border', '0 solid red');
			}
			if (subj == "" || subj == null) {
				$('.subj').css('border', '2px solid red');
				return false;
			} else {
				$('.subj').css('border', '0 solid red');
			}
			if (body == "" || body == null) {
				$('.body').css('border', '2px solid red');
				return false;
			} else {
				$('.body').css('border', '0 solid red');
			}

			$.ajax({
				success: function() {
					$('.sendlinkbtn').attr('disabled', 'disabled');
					$('.sendlinkbtn').html('Sending...');
					$('.sendlinkbtn').css('cursor', 'not-allowed');
					$('.sendlinkbtn').removeClass('btn-success').addClass('btn-danger');
				}
			});
		});

		$('#upload_csv').on('submit', function(e) {
			e.preventDefault();
			var file = $('#csv_file').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (file == "" || file == null) {
				$('#csv_file').css('border', '2px solid red');
				return false;
			} else {
				$('#csv_file').css('border', '0 solid red');
			}

			$.ajax({
				url: "<?php echo base_url('user/importcsv_email'); ?>",
				method: "post",
				data: new FormData(this),
				[csrfName]: csrfHash,
				dataType: "json",
				contentType: false,
				cache: false,
				processData: false,
				beforSend: function(data) {
					$('.importbtn').attr('disabled', 'disabled');
					$('.importbtn').html('Importing...');
					$('.importbtn').css('cursor', 'not-allowed');
					$('.importbtn').removeClass('btn-success').addClass('btn-danger');
				},
				success: function(data) {
					$('.emailmodal').hide();
					$('#csv_file').val("");
					for (i = 0; i < data.length; i++) {
						$('#email_select').append('<option disabled class="email_options">' + data[i].Email + '</option>');
					}
					$('#email').hide();
					$('.sendlinkbtn').hide();
					$('.sendmultiplelinkbtn').show();
					$('#email').val('nomailname@nodomainname.com');
					$('#email_select').attr('conn', 'true');
					$('#email_select').show();
					$('.singlemailsend').show();
					bseu = "<?php echo base_url('user/send_multiple_link'); ?>";
					$("#gen_link_form").attr('action', bseu);
				},
				error: function(data) {
					alert('Error importing data');
				}
			});
		});

		$('.sendmultiplelinkbtn').click(function(e) {
			e.preventDefault();
			var link_for = $('.link_for').val();
			var email = $('.email').val();
			var subj = $('.subj').val();
			var bdy = $('.bdy').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (email == "" || email == null) {
				$('.email').css('border', '2px solid red');
				return false;
			} else {
				$('.email').css('border', '0 solid red');
			}
			if (subj == "" || subj == null) {
				$('.subj').css('border', '2px solid red');
				return false;
			} else {
				$('.subj').css('border', '0 solid red');
			}
			if (bdy == "" || bdy == null) {
				$('.bdy').css('border', '2px solid red');
				return false;
			} else {
				$('.bdy').css('border', '0 solid red');
			}

			var emaildata = [];
			$(".email_options").each(function() {
				var eachopt = $(this).val();
				emaildata.push(eachopt);
			});

			$.ajax({
					url: "<?php echo base_url('user/send_multiple_email'); ?>",
					method: "post",
					data: {
						emaildata: emaildata,
						subj: subj,
						bdy: bdy,
						link_for: link_for,
						[csrfName]: csrfHash,
					},
					beforeSend: function() {
						$('.sendmultiplelinkbtn').attr('disabled', 'disabled');
						$('.sendmultiplelinkbtn').html('Sending...');
						$('.sendmultiplelinkbtn').css('cursor', 'not-allowed');
						$('.sendmultiplelinkbtn').removeClass('btn-success').addClass('btn-danger');
					},
					error: function() {
						$('.sendmultiplelinkbtn').attr('disabled', 'false');
						$('.sendmultiplelinkbtn').html('Send');
						$('.sendmultiplelinkbtn').css('cursor', 'pointer');
						$('.sendmultiplelinkbtn').removeClass('btn-danger').addClass('btn-success');
					}
				})
				.done(function() {
					window.location.reload();
				});
		});

	});
</script>