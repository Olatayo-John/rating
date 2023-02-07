<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/share.css'); ?>">


<div class="wrapper_div">

	<!-- modals -->
	<div class="">
		<div class="emailmodal modal fade" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="modalcloseDiv">
							<h6>CSV must have header of only "Email"</h6>
							<i class="fas fa-times close_EmailModalBtn text-danger"></i>
						</div>

						<form enctype="multipart/form-data" method="post" id="emailForm_csvUpload">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">

							<div class="form-group">
								<input type="file" name="email_csv_file" id="email_csv_file" accept=".csv" class="" style="border:none">
							</div>

							<div class="text-right">
								<button class="btn text-light email_SendMultipleBtn" type="submit" style="background-color:#294a63">Import CSV</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="smsmodal modal fade" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="modalcloseDiv">
							<h6>CSV must have header of only "Phonenumber"</h6>
							<i class="fas fa-times close_SmsModalBtn text-danger"></i>
						</div>

						<form enctype="multipart/form-data" method="post" id="smsForm_csvUpload">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">

							<div class="form-group">
								<input type="file" name="sms_csv_file" id="sms_csv_file" accept=".csv" class="" style="border:none">
							</div>

							<div class="text-right">
								<button class="btn text-light sms_SendMultipleBtn" type="submit" style="background-color:#294a63">Import CSV</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade add_web_modal" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-top">
				<div class="modal-content">
					<div class="modal-body">
						<div class="modalcloseDiv">
							<h6></h6>
							<i class="fas fa-times closewebmodal_btn text-danger"></i>
						</div>

						<form method="post" action="<?php echo base_url("user/user_new_website") ?>" class="add_web_modal_form">
							<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

							<div class="form-group">
								<label class="mb-0">Platform Name</label>
								<input type="text" name="web_name_new" class="web_name_new form-control" placeholder="Platform Name" required>
								<div class="text-danger mt-0 web_name_err"></div>
							</div>

							<div class="form-group">
								<label class="mb-0">Platform Link</label>
								<input type="url" name="web_link_new" class="web_link_new form-control" placeholder="e.g https://domainname.com" required>
								<div class="text-danger mt-0 web_link_err"></div>
							</div>

							<div class="form-group">
								<label>Subject</label>
								<input type="url" name="web_subject_new" class="web_subject_new form-control" placeholder="Subject">
							</div>

							<div class="form-group">
								<label>Description</label>
								<textarea name="web_desc_new" class="web_desc_new form-control" cols="30" rows="5"></textarea>
							</div>

							<div class="text-right">
								<button type="submit" class="btn add_web_modal_btn text-light" style="background-color:#294a63;">
									Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- tabLinks -->
	<div class="tab_div bg-light-custom">
		<a href="#as-email" class="tab_link mail_a sndasmailbtn" id="as-email" tabFormName="emailForm">
			<!-- <i class="fas fa-envelope mr-2"></i> -->
			Email
		</a>
		<a href="#as-sms" class="tab_link sms_a sndassmsbtn" id="as-sms" tabFormName="smsForm">
			<!-- <i class="fas fa-comment-dots mr-2"></i> -->
			SMS
		</a>
		<a href="#as-whatsapp" class="tab_link whatsapp_a sndaswhpbtn" id="as-whatsapp" tabFormName="whatsappForm">
			<!-- <i class="fa-brands fa-whatsapp mr-2"></i> -->
			Whatsapp
		</a>
	</div>
	<!--  -->


	<div class="bg-light-custom allform p-3">
		<!-- email -->
		<form action="<?php echo base_url('share-email'); ?>" method="post" id="emailForm" class="emailForm as-email genform">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">
			<input type="hidden" name="userid" value="<?php echo $this->session->userdata('mr_id'); ?>" class="userid">

			<div class="importDiv">
				<button class="btn text-light email_SendSingleBtn" type="button" style="background-color:#294a63">Send single</button>
				<button class="btn text-light email_ImportMultipleBtn" type="button" style="background-color:#294a63">Import multiple</button>

				<a href="<?php echo base_url('email-sample-csv'); ?>" class="btn btn-danger">
					<i class="fas fa-file-csv mr-2"></i>Download sample</a>
			</div>

			<div class="form-group">
				<label class="labelplatform">Platform</label>
				<div class="input-group">
					<select name="foremailplatform" id="platforms" platformTab="email" class="form-control" required>
						<?php if ($platforms->num_rows() > 0) : ?>
							<option value="">Select</option>
							<?php foreach ($platforms->result_array() as $p) : ?>
								<?php if ($p['active'] === '1') : ?>
									<option value="<?php echo $p['id'] ?>"><?php echo $p['web_name'] ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else : ?>
							<option value="">No platform created</option>
						<?php endif; ?>
					</select>

					<div class="input-group-prepend addwebmodal_btn" style="cursor:pointer">
						<span class="input-group-text"><i class="fa-solid fa-plus"></i></span>
					</div>
				</div>

			</div>

			<div class="form-group">
				<label class="labelemail">E-mail</label>
				<input type="email" name="email" class="form-control email" placeholder="example@domain.com" id="email" required>
				<select class="form-control email_select" name="email_select" id="email_select" style="display: none;" readonly conn="false">
				</select>
			</div>

			<div class="form-group">
				<label>Subject</label>
				<input type="text" name="subj" class="form-control subj" required>
			</div>

			<div class="form-group">
				<label>Body</label>
				<textarea class="form-control emailbdy" rows="8" name="emailbdy" required></textarea>
			</div>

			<hr>
			<div class="text-right">
				<button class="btn email_sendBtn text-light" type="submit" style="background-color:#294a63">Share</button>
				<button class="btn email_sendBtn_m text-light" type="submit" style="background-color:#294a63">Share</button>
			</div>
		</form>

		<!-- sms -->
		<form action="<?php echo base_url('share-sms'); ?>" method="post" id="smsForm" class="smsForm as-sms genform">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">
			<input type="hidden" name="userid" value="<?php echo $this->session->userdata('mr_id'); ?>" class="userid">

			<div class="importDiv">
				<button class="btn text-light sms_SendSingleBtn" type="button" style="background-color:#294a63">Send single</button>
				<button class="btn text-light sms_ImportMultipleBtn" type="button" style="background-color:#294a63">Import multiple</button>

				<a href="<?php echo base_url('sms-sample-csv'); ?>" class="btn btn-danger">
					<i class="fas fa-file-csv mr-2"></i>Download sample</a>
			</div>

			<div class="form-group">
				<label class="labelplatform">Platform</label>
				<div class="input-group">
					<select name="forsmsplatform" id="platforms" platformTab="sms" class="form-control" required>
						<?php if ($platforms->num_rows() > 0) : ?>
							<option value="">Select</option>
							<?php foreach ($platforms->result_array() as $p) : ?>
								<?php if ($p['active'] === '1') : ?>
									<option value="<?php echo $p['id'] ?>"><?php echo $p['web_name'] ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else : ?>
							<option value="">No platform created</option>
						<?php endif; ?>
					</select>
					<div class="input-group-prepend addwebmodal_btn" style="cursor:pointer">
						<span class="input-group-text"><i class="fa-solid fa-plus"></i></span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="phonelabel">Phonenumber</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">+91</span>
					</div>

					<input type="number" name="mobile" class="form-control mobile" placeholder="Your mobile number" id="mobile" required value="1234567890">
					<select class="form-control sms_select" name="sms_select" id="sms_select" style="display: none;" readonly conn="false">
					</select>
				</div>
				<span class="e_mobile">Invalid mobile length</span>
			</div>

			<div class="form-group">
				<label>Body</label>
				<textarea class="form-control smsbdy" rows="8" name="smsbdy" required></textarea>
			</div>

			<hr>
			<div class="text-right">
				<button class="btn text-light sms_sendBtn" type="submit" style="background-color:#294a63">Share</button>
				<button class="btn text-light sms_sendBtn_m" type="submit" style="background-color:#294a63">Share</button>
			</div>
		</form>

		<!-- whatsapp -->
		<form action="<?php echo base_url('share-whatsapp'); ?>" method="post" id="whatsappForm" class="whatsappForm as-whatsapp genform">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">
			<input type="hidden" name="userid" value="<?php echo $this->session->userdata('mr_id'); ?>" class="userid">

			<div class="form-group">
				<label class="labelplatform">Platform</label>
				<div class="input-group">
					<select name="forwhpplatform" id="platforms" platformTab="whp" class="form-control" required>
						<?php if ($platforms->num_rows() > 0) : ?>
							<option value="">Select</option>
							<?php foreach ($platforms->result_array() as $p) : ?>
								<?php if ($p['active'] === '1') : ?>
									<option value="<?php echo $p['id'] ?>"><?php echo $p['web_name'] ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else : ?>
							<option value="">No platform created</option>
						<?php endif; ?>
					</select>
					<div class="input-group-prepend addwebmodal_btn" style="cursor:pointer">
						<span class="input-group-text"><i class="fa-solid fa-plus"></i></span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="phonelabel">Whatsapp Number</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">+91</span>
					</div>

					<input type="number" name="whpMobile" class="form-control whpMobile" placeholder="Whatsapp number" required value="1234567890">
				</div>
				<span class="e_whpMobile err">Invalid mobile length</span>
			</div>

			<div class="form-group">
				<label>Body</label>
				<textarea class="form-control whpbdy" rows="8" name="whpbdy" required></textarea>
			</div>

			<hr>
			<div class="text-right">
				<button class="btn text-light whp_sendBtn" type="submit" style="background-color:#294a63">Share</button>
			</div>
		</form>
	</div>
</div>




<script type="text/javascript" src="<?php echo base_url('assets/js/share.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var id = $('.userid').val();
		var csrfName = $('.csrf_hash').attr('name');
		var csrfHash = $('.csrf_hash').val();

		//load message body/file.txt
		// $.ajax({
		// 	url: "<?php echo base_url('getlink'); ?>",
		// 	method: "post",
		// 	data: {
		// 		id: id,
		// 		[csrfName]: csrfHash
		// 	},
		// 	dataType: "json",
		// 	beforeSend: function() {
		// 		// clearAlert();
		// 	},
		// 	success: function(data) {
		// 		$('.csrf_hash').val(data.token);

		// 		if (data.status === true) {
		// 			$('.subj').val("Rating");

		// 			$(".emailbdy,.smsbdy,.whpbdy").load("<?php echo base_url("body.txt"); ?>");

		// 		} else if (data.status == false) {
		// 			$(".ajax_succ_div,.ajax_err_div").fadeOut();
		// 			$('.ajax_res_err').html(data.msg);
		// 			$('.ajax_err_div').fadeIn();
		// 		} else if (data.status == "error") {
		// 			window.location.assign(data.redirect);
		// 		}
		// 	},
		// 	error: function(data) {
		// 		window.location.assign(data.redirect);
		// 	}
		// });

		//n change of platform
		$(document).on('change', '#platforms', function(e) {
			e.preventDefault();

			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();
			var platformid = $(this).val();
			var platformTab = $(this).attr('platformTab');

			if (platformid && platformid !== "" && platformid !== null && platformid !== undefined) {
				$.ajax({
					url: "<?php echo base_url('get-platform-link'); ?>",
					method: "post",
					data: {
						[csrfName]: csrfHash,
						platformid: platformid
					},
					dataType: "json",
					beforeSend: function(data) {
						clearAlert();
					},
					success: function(data) {
						if (data.status === false) {
							$(".ajax_res_err").append(data.msg);
							$(".ajax_err_div").fadeIn();

						} else if (data.status === true) {
							//subject
							if (data.res.subject) {
								$('.subj').val(data.res.subject);
							} else {
								$('.subj').val('Reviews');
							}
							//message-body
							$("." + platformTab + "bdy").val(data.body);
						} else if (data.status === 'error') {
							window.location.assign(data.redirect);
						}

						$('.csrf_hash').val(data.token);
					},
					error: function() {
						alert('Error');
						window.location.reload();
					}
				});
			}
		});

		//show email import modal
		//send single email
		$('button.email_ImportMultipleBtn,button.email_SendSingleBtn').click(function(e) {
			e.preventDefault();

			var sel_conn = $('#email_select').attr('conn');

			if (sel_conn == "true") {
				var ans = confirm("Your imported data will be cleared. Do you want to continue?");
				if (ans == true) {
					$('.email_options').remove();
					$('#email_select').attr('conn', 'false').removeAttr('required').hide();

					$('.labelemail').html('E-mail');
					$('#email').val('').attr('required', true).show();

					$(".email_SendSingleBtn,.email_sendBtn_m").hide();
					$(".email_ImportMultipleBtn,.email_sendBtn").show();

					$('.emailmodal').modal('show');
				} else {
					return false;
				}
			} else {
				$('.emailmodal').modal('show');
			}
		});

		//show sms import modal
		//send single sms
		$('button.sms_ImportMultipleBtn,button.sms_SendSingleBtn').click(function(e) {
			e.preventDefault();

			var sel_conn = $('#sms_select').attr('conn');

			if (sel_conn == "true") {
				var ans = confirm("Your imported data will be cleared. Do you want to continue?");
				if (ans == true) {
					$('.sms_options').remove();
					$('#sms_select').attr('conn', 'false').removeAttr('required').hide();

					$('.phonelabel').html('Phonenumber');
					$('#mobile').val('').attr('required', true).show();

					$(".sms_SendSingleBtn,.sms_sendBtn_m").hide();
					$(".sms_ImportMultipleBtn,.sms_sendBtn").show();

					$('.smsmodal').modal('show');
				} else {
					return false;
				}
			} else {
				$('.smsmodal').modal('show');
			}
		});

		//upload email file
		$('#emailForm_csvUpload').on('submit', function(e) {
			e.preventDefault();

			var file = $('#email_csv_file').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (file == "" || file == null) {
				$('#email_csv_file').css('border-bottom', '2px solid #dc3545');
				return false;
			} else {
				$('#email_csv_file').css('border', '2px solid #ced4da');
			}

			$.ajax({
				url: "<?php echo base_url('import-csv-email'); ?>",
				method: "post",
				data: new FormData(this),
				[csrfName]: csrfHash,
				dataType: "json",
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function(data) {
					$('.email_SendMultipleBtn').attr('disabled', 'disabled').html('Importing...').css('cursor', 'not-allowed');

					clearAlert();
				},
				success: function(data) {
					if (data.status === false) {
						$(".ajax_res_err").append(data.msg);
						$(".ajax_err_div").fadeIn();

					} else if (data.status === true) {
						if (parseInt(data.EmailArray.length) > 0) {
							$('.emailmodal').modal('hide');

							$('#email_csv_file').val("");
							for (i = 0; i < data.EmailArray.length; i++) {
								$('#email_select').append('<option disabled class="email_options">' + data.EmailArray[i].Email + '</option>');
							}

							$('#email').hide().removeAttr('required');
							$('.labelemail').html('Emails');

							$('#email_select').attr({
								conn: 'true',
								required: true
							}).show();

							$('.email_SendSingleBtn,.email_sendBtn_m').show();
							$('.email_ImportMultipleBtn,.email_sendBtn').hide();
						} else {
							$(".ajax_res_err").append('Empty file uploaded');
							$(".ajax_err_div").fadeIn();
						}
					}

					$('.csrf_hash').val(data.token);
					$('.email_SendMultipleBtn').removeAttr('disabled').html('Import CSV').css('cursor', 'pointer');
				},
				error: function(data) {
					alert('Error importing data');
					window.location.reload();
				}
			});
		});

		//upload sms file
		$('#smsForm_csvUpload').on('submit', function(e) {
			e.preventDefault();

			var sms_file = $('#sms_csv_file').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (sms_file == "" || sms_file == null) {
				$('#sms_csv_file').css('border', '2px solid #dc3545');
				return false;
			} else {
				$('#sms_csv_file').css('border', '2px solid #ced4da');
			}

			$.ajax({
				url: "<?php echo base_url('import-csv-sms'); ?>",
				method: "post",
				data: new FormData(this),
				[csrfName]: csrfHash,
				dataType: "json",
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function(data) {
					$('.sms_SendMultipleBtn').attr('disabled', 'disabled').html('Importing...').css('cursor', 'not-allowed');

					clearAlert();
				},
				success: function(data) {
					if (data.status === false) {
						$(".ajax_res_err").append(data.msg);
						$(".ajax_err_div").fadeIn();

					} else if (data.status === true) {
						if (parseInt(data.MobileArray.length) > 0) {
							$('.smsmodal').modal('hide');

							$('#sms_csv_file').val("");
							for (i = 0; i < data.MobileArray.length; i++) {
								$('#sms_select').append('<option disabled class="sms_options">' + data.MobileArray[i].Phonenumber + '</option>');
							}

							$('#mobile').hide().removeAttr('required');
							$('.phonelabel').html('Phonenumbers');

							$('#sms_select').attr({
								conn: 'true',
								required: true
							}).show();

							$('.sms_SendSingleBtn,.sms_sendBtn_m').show();
							$('.sms_ImportMultipleBtn,.sms_sendBtn').hide();
						} else {
							$(".ajax_res_err").append('Empty file uploaded');
							$(".ajax_err_div").fadeIn();
						}
					}

					$('.csrf_hash').val(data.token);
					$('.sms_SendMultipleBtn').removeAttr('disabled').html('Import CSV').css('cursor', 'pointer');
				},
				error: function(data) {
					alert('Error importing data');
					window.location.reload();
				}
			});
		});

		//send single email
		$('#emailForm').submit(function(e) {
			// e.preventDefault();

			var platform = $('select[name="foremailplatform"]').val();
			var email = $('.email').val();
			var sbj = $('.subj').val();
			var body = $('.emailbdy').val();

			if (platform == "" || platform == null) {
				return false;
			}

			if (email == "" || email == null) {
				return false;
			}

			if (sbj == "" || sbj == null) {
				return false;
			}

			if (body == "" || body == null) {
				return false;
			}


			$.ajax({
				success: function() {
					$('.email_sendBtn').addClass('bg-danger').html('Sharing...').attr('disabled', 'disabled').css('cursor', 'not-allowed');
				}
			});

		});

		//send single sms
		$('form#smsForm').submit(function(e) {
			// e.preventDefault();

			var platform = $('select[name="forsmsplatform"]').val();
			var mobile = $('.mobile').val();
			var smsbdy = $('.smsbdy').val();

			if (platform == "" || platform == null) {
				return false;
			}

			if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
				$('.e_mobile').show();
				return false;
			} else {
				$('.e_mobile').hide();
			}

			if (smsbdy == "" || smsbdy == null) {
				return false;
			}

			$.ajax({
				success: function() {
					$('.sms_sendBtn').addClass('bg-danger').html('Sharing...').attr('disabled', 'disabled').css('cursor', 'not-allowed');
				}
			});

		});

		//send single whatsapp
		// $('form#whatsappForm').submit(function(e) {
		$('button.whp_sendBtn').click(function(e) {
			e.preventDefault();

			var platform = $('select[name="forwhpplatform"]').val();
			var mobile = $('.whpMobile').val();
			var whpbdy = $('.whpbdy').val();

			if (platform == "" || platform == null) {
				$('select[name="forwhpplatform"]').css('border-bottom', '2px solid #dc3545');
				$('select[name="forwhpplatform"]').css('border-bottom', '2px solid #dc3545');
				return false;
			} else {
				$('select[name="forwhpplatform"]').css('border-bottom', '1px solid #ced4da');
			}

			if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
				$('.whpMobile').css('border-bottom', '2px solid #dc3545');
				$('.e_whpMobile').show();
				return false;
			} else {
				$('.whpMobile').css('border-bottom', '1px solid #ced4da');
				$('.e_whpMobile').hide();
			}

			if (whpbdy == "" || whpbdy == null) {
				$('.whpbdy').css('border-bottom', '2px solid #dc3545');
				return false;
			} else {
				$('.whpbdy').css('border-bottom', '1px solid #ced4da');
			}

			$.ajax({
				url: '<?php echo base_url('share-whatsapp') ?>',
				method: 'post',
				dataType: 'json',
				data: {
					mobile: mobile,
					whpbdy: whpbdy,
					[csrfName]: csrfHash
				},
				beforeSend: function() {
					$('.whp_sendBtn').addClass('bg-danger').html('Sharing...').attr('disabled', 'disabled').css('cursor', 'not-allowed');

					clearAlert();
				},
				success: function(data) {
					if (data.status === false) {
						$(".ajax_res_err").append(data.msg);
						$(".ajax_err_div").fadeIn();
					} else if (data.status === 'error') {
						window.location.assign(data.redirect);
					} else if (data.status === true) {
						var shareLink = "https://api.whatsapp.com/send?phone=" + mobile + "&text=" + whpbdy + "";
						window.open(shareLink);
						window.location.reload();
					}

					$('.csrf_hash').val(data.token);
					$('.whp_sendBtn').removeAttr('disabled').html('Send').css('cursor', 'pointer');
				},
				error: function() {
					alert('Error!');
					window.location.reload();
				}
			});

		});

		//send multiple email
		$('.email_sendBtn_m').click(function(e) {
			e.preventDefault();

			var platform = $('select[name="foremailplatform"]').val();
			var subj = $('.subj').val();
			var bdy = $('.emailbdy').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (platform == "" || platform == null) {
				$('select[name="foremailplatform"]').css('border-bottom', '2px solid #dc3545');
				return false;
			} else {
				$('select[name="foremailplatform"]').css('border-bottom', '1px solid #ced4da');
			}

			if (subj == "" || subj == null) {
				$('.subj').css('border-bottom', '2px solid #dc3545');
				return false;
			} else {
				$('.subj').css('border-bottom', '1px solid #ced4da');
			}

			if (bdy == "" || bdy == null) {
				$('.emailbdy').css('border-bottom', '2px solid #dc3545');
				return false;
			} else {
				$('.emailbdy').css('border-bottom', '1px solid #ced4da');
			}

			var emaildata = [];
			$(".email_options").each(function() {
				var eachopt = $(this).val();
				emaildata.push(eachopt);
			});

			if (parseInt(emaildata.length) == 0 || parseInt(emaildata.length) < 0) {
				return false;
			}

			$.ajax({
				url: "<?php echo base_url('share-email-multiple'); ?>",
				method: "post",
				dataType: "json",
				data: {
					emaildata: emaildata,
					subj: subj,
					bdy: bdy,
					[csrfName]: csrfHash,
				},
				beforeSend: function() {
					clearAlert();

					$('.email_sendBtn_m').addClass('bg-danger').html('Sharing...').attr('disabled', 'disabled').css('cursor', 'not-allowed');
				},
				success: function(data) {
					if (data.status === false) {
						$(".ajax_res_err").append(data.msg);

						//show user emails that were not sent
						if (data.emailnotsentarr) {
							if (data.emailnotsentarr.length > 0) {
								for (let index = 0; index < data.emailnotsentarr.length; index++) {
									$(".ajax_res_err").append('<div>' + data.emailnotsentarr[index] + '</div>');
								}
							}
						}

						$(".ajax_err_div").fadeIn();
					} else if (data.status === 'error') {
						window.location.assign(data.redirect);
					} else if (data.status === true) {
						window.location.reload();
					}

					$('.csrf_hash').val(data.token);
					$('.email_sendBtn_m').removeAttr('disabled').html('Send').css('cursor', 'pointer');

				},
				error: function() {
					alert("Error sending e-mails. Please try again");
					window.location.reload();
				}
			})
		});

		//send multiple sms
		$('.sms_sendBtn_m').click(function(e) {
			e.preventDefault();

			var platform = $('select[name="forsmsplatform"]').val();
			var mobile = $('.mobile').val();
			var smsbdy = $('.smsbdy').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (platform == "" || platform == null) {
				$('select[name="forsmsplatform"]').css('border-bottom', '2px solid #dc3545');
				return false;
			} else {
				$('select[name="forsmsplatform"]').css('border-bottom', '1px solid #ced4da');
			}

			if (smsbdy == "" || smsbdy == null) {
				$('.smsbdy').css('border-bottom', '2px solid #dc3545');
				return false;
			} else {
				$('.smsbdy').css('border-bottom', '1px solid #ced4da');
			}

			if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border-bottom', '2px solid #dc3545');
				$('.e_mobile').show();
				return false;
			} else {
				$('.mobile').css('border-bottom', '1px solid #ced4da');
				$('.e_mobile').hide();
			}

			var mobiledata = [];
			$(".sms_options").each(function() {
				var eachopt = $(this).val();
				mobiledata.push(eachopt);
			});

			if (parseInt(mobiledata.length) == 0 || parseInt(mobiledata.length) < 0) {
				return false;
			}

			$.ajax({
				url: "<?php echo base_url('share-sms-multiple'); ?>",
				method: "post",
				dataType: 'json',
				data: {
					mobiledata: mobiledata,
					smsbdy: smsbdy,
					[csrfName]: csrfHash,
				},
				beforeSend: function() {
					clearAlert();

					$('.sms_sendBtn_m').addClass('bg-danger').html('Sharing...').attr('disabled', 'disabled').css('cursor', 'not-allowed');
				},
				success: function(data) {
					if (data.status === false) {
						$(".ajax_res_err").append(data.msg);

						//show user numbers that were not sent
						if (data.mobilenotsentarr) {
							if (data.mobilenotsentarr.length > 0) {
								for (let index = 0; index < data.mobilenotsentarr.length; index++) {
									$(".ajax_res_err").append('<div>' + data.mobilenotsentarr[index].mobile + ' - ' + data.mobilenotsentarr[index].errorCode + ' - ' + data.mobilenotsentarr[index].errorInfo + '</div>');
								}
							}
						}

						$(".ajax_err_div").fadeIn();
					} else if (data.status === 'error') {
						window.location.assign(data.redirect);
					} else if (data.status === true) {
						window.location.reload();
					}

					$('.csrf_hash').val(data.token);
					$('.sms_sendBtn_m').removeAttr('disabled').html('Send').css('cursor', 'pointer');

				},
				error: function() {
					alert("Error sending messages. Please try again");
					window.location.reload();
				}
			})
		});


		// add new website modal
		$(document).on('click', '.addwebmodal_btn', function(e) {
			e.preventDefault();

			$('.add_web_modal').modal("show");
		});

		$(document).on('click', '.closewebmodal_btn', function(e) {
            e.preventDefault();

            $('.add_web_modal').modal("hide");

            $(".add_web_modal_btn").removeAttr("disabled readonly").attr("type", "submit").css("cursor", "pointer");

            $(".web_link_err,.web_name_err").fadeOut();
            $('.web_link_new,.web_name_new').css('border', '1px solid #ced4da').removeAttr("readonly").val("");
        });

		// check for duplicate web-name
        $(".web_name_new").keyup(function() {
            var webname = $(".web_name_new").val();
            var csrfName = $(".csrf_token").attr("name");
            var csrfHash = $(".csrf_token").val();

            $.ajax({
                url: "<?php echo base_url("duplicate-webname") ?>",
                method: "post",
                dataType: "json",
                data: {
                    [csrfName]: csrfHash,
                    webname: webname
                },
                success: function(data) {
                    $(".csrf_token").val(data.token);

                    if (data.webdata > 0) {
                        $('.web_name_err').html("You already have a platform with this name").show();
                        $(".web_name_new").css('border-bottom', '2px solid #dc3545');
                        $(".add_web_modal_btn").attr({
                            type: "button",
                            disabled: "disabled",
                            readonly: "readonly"
                        }).css("cursor", "not-allowed");
                    } else {
                        $('.web_name_err').hide();
                        $(".web_name_new").css('border', '1px solid #ced4da');
                        $(".add_web_modal_btn").removeAttr("disabled readonly").attr("type", "submit").css("cursor", "pointer");
                    }
                },
                error: function(data) {
                    window.location.reload();
                }
            });
        });

        // check for duplicate web-link
        $(".web_link_new").keyup(function() {
            var weblink = $(".web_link_new").val();
            var csrfName = $(".csrf_token").attr("name");
            var csrfHash = $(".csrf_token").val();

            $.ajax({
                url: "<?php echo base_url("duplicate-weblink") ?>",
                method: "post",
                dataType: "json",
                data: {
                    [csrfName]: csrfHash,
                    weblink: weblink
                },
                success: function(data) {
                    $(".csrf_token").val(data.token);

                    if (data.webdata > 0) {
                        $('.web_link_err').html("You already have a platform with this Link").show();
                        $(".web_link_new").css('border-bottom', '2px solid #dc3545');
                        $(".add_web_modal_btn").attr({
                            type: "button",
                            disabled: "disabled",
                            readonly: "readonly"
                        }).css("cursor", "not-allowed");
                    } else {
                        $('.web_link_err').hide();
                        $(".web_link_new").css('border', '1px solid #ced4da');
                        $(".add_web_modal_btn").removeAttr("disabled readonly").attr("type", "submit").css("cursor", "pointer");
                    }
                },
                error: function(data) {
                    window.location.reload();
                }
            });
        });

        // add website to database
        $(document).on('click', 'button.add_web_modal_btn', function(e) {
            e.preventDefault();

            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var web_name_new = $('.web_name_new').val();
            var web_link_new = $('.web_link_new').val();
            var web_subject_new = $('.web_subject_new').val();
            var web_desc_new = $('.web_desc_new').val();

            if (web_name_new == "" || web_name_new == null || web_name_new == undefined) {
                $('.web_name_new').css('border-bottom', '2px solid #dc3545');
                return false;
            } else {
                $('.web_name_new').css('border', '1px solid #ced4da');
            }
            if (web_link_new == "" || web_link_new == null || web_link_new == undefined) {
                $(".web_link_new").css('border-bottom', '2px solid #dc3545');
                return false;
            }

            var patt = new RegExp('^(https?:\\/\\/)?' + // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + //port
                '(\\?[;&amp;a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$', 'i');
            var res = patt.test(web_link_new);
            if (res == true) {
                $(".web_link_err").fadeOut();
                $('.web_link_new').css('border', '1px solid #ced4da');
            } else if (res == false) {
                $(".web_link_new").css('border-bottom', '2px solid #dc3545');
                $(".web_link_err").html("Invalid WEB URL").fadeIn();
                return false;
            }

            $.ajax({
                url: "<?php echo base_url("create-website") ?>",
                method: "post",
                dataType: "json",
                data: {
                    [csrfName]: csrfHash,
                    web_name_new: web_name_new,
                    web_link_new: web_link_new,
                    web_subject_new: web_subject_new,
                    web_desc_new: web_desc_new
                },
                beforeSend: function() {
                    clearAlert();

                    $('.add_web_modal_btn').addClass('bg-danger').html('Saving...').attr('disabled', 'disabled').css({
                        'cursor': 'not-allowed',
                    });
                },
                success: function(data) {
                    $(".csrf_token").val(data.token);

                    if (data.status === false) {
                        $(".ajax_res_err").text(data.msg);
                        $(".ajax_err_div").fadeIn();
                    } else if (data.status === true) {
                        $(".ajax_res_succ").text(data.msg);
                        $(".ajax_succ_div").fadeIn();

						$('select#platforms').append('<option value='+data.insert_id +'>'+web_name_new+'</option>');

                        $('.add_web_modal').modal("hide");
                    } else if (data.status === "error") {
                        window.location.assign(data.redirect);
                    }

                    $(".add_web_modal_btn").removeClass('bg-danger').html('Save').removeAttr("disabled").css("cursor", "pointer");
                }
            })
        });

	});
</script>