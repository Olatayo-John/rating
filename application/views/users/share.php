<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/share.css'); ?>">


<div class="wrapper_div">
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
				<button class="btn email_sendBtn text-light" type="submit" style="background-color:#294a63">Send</button>
				<button class="btn email_sendBtn_m text-light" type="submit" style="background-color:#294a63">Send</button>
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

			<div class=" form-group">
				<label class="phonelabel">Phonenumber</label>
				<input type="number" name="mobile" class="form-control mobile" placeholder="Your mobile number" id="mobile" required value="1234567890">
				<span class="e_mobile">Invalid mobile length</span>
				<select class="form-control sms_select" name="sms_select" id="sms_select" style="display: none;" readonly conn="false">
				</select>
			</div>

			<div class="form-group">
				<label>Body</label>
				<textarea class="form-control smsbdy" rows="8" name="smsbdy" required></textarea>
			</div>

			<hr>
			<div class="text-right">
				<button class="btn text-light sms_sendBtn" type="submit" style="background-color:#294a63">Send</button>
				<button class="btn text-light sms_sendBtn_m" type="submit" style="background-color:#294a63">Send</button>
			</div>
		</form>

		<!-- whatsapp -->
		<form action="<?php echo base_url('share-whatsapp'); ?>" method="post" id="whatsappForm" class="whatsappForm as-whatsapp genform">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">
			<input type="hidden" name="userid" value="<?php echo $this->session->userdata('mr_id'); ?>" class="userid">

			<div class="form-group">
				<label class="phonelabel">Whatsapp Number</label>
				<input type="number" name="whpMobile" class="form-control whpMobile" placeholder="Whatsapp number" required value="1234567890">
				<span class="e_whpMobile err">Invalid mobile length</span>
			</div>

			<div class="form-group">
				<label>Body</label>
				<textarea class="form-control whpbdy" rows="8" name="whpbdy" required></textarea>
			</div>

			<hr>
			<div class="text-right">
				<button class="btn text-light whp_sendBtn" type="submit" style="background-color:#294a63">Send</button>
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
		$.ajax({
			url: "<?php echo base_url('getlink'); ?>",
			method: "post",
			data: {
				id: id,
				[csrfName]: csrfHash
			},
			dataType: "json",
			beforeSend: function(){
				clearAlert();
			},
			success: function(data) {
				$('.csrf_hash').val(data.token);

				if (data.status === true) {
					$('.subj').val("Rating");

					$(".emailbdy,.smsbdy,.whpbdy").load("<?php echo base_url("body.txt"); ?>");

				} else if (data.status == false) {
					$(".ajax_succ_div,.ajax_err_div").fadeOut();
					$('.ajax_res_err').html(data.msg);
					$('.ajax_err_div').fadeIn();
				} else if (data.status == "error") {
					window.location.assign(data.redirect);
				}
			},
			error: function(data) {
				window.location.assign(data.redirect);
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

					$('.emailmodal').modal('show');
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
							$('.emailmodal').hide();

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
							$('.smsmodal').hide();

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

			var email = $('.email').val();
			var sbj = $('.subj').val();
			var body = $('.emailbdy').val();

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
					$('.email_sendBtn').attr('disabled', 'disabled').html('Sending...').css('cursor', 'not-allowed');
				}
			});

		});

		//send single sms
		$('form#smsForm').submit(function(e) {
			// e.preventDefault();

			var mobile = $('.mobile').val();
			var smsbdy = $('.smsbdy').val();

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
					$('.sms_sendBtn').attr('disabled', 'disabled').html('Sending...').css('cursor', 'not-allowed');
				}
			});

		});

		//send single whatsapp
		// $('form#whatsappForm').submit(function(e) {
		$('button.whp_sendBtn').click(function(e) {
			e.preventDefault();

			var mobile = $('.whpMobile').val();
			var whpbdy = $('.whpbdy').val();

			if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
				$('.e_whpMobile').show();
				return false;
			} else {
				$('.e_whpMobile').hide();
			}

			if (whpbdy == "" || whpbdy == null) {
				return false;
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
					$('.whp_sendBtn').attr('disabled', 'disabled').html('Sending...').css('cursor', 'not-allowed');

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

			var subj = $('.subj').val();
			var bdy = $('.emailbdy').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (subj == "" || subj == null) {
				return false;
			}

			if (bdy == "" || bdy == null) {
				return false;
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
					$('.email_sendBtn_m').attr('disabled', 'disabled').html('Sending...').css('cursor', 'not-allowed');

					clearAlert();
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

			var mobile = $('.mobile').val();
			var smsbdy = $('.smsbdy').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (smsbdy == "" || smsbdy == null) {
				return false;
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
					$('.sms_sendBtn_m').attr('disabled', 'disabled').html('Sending...').css('cursor', 'not-allowed');

					clearAlert();
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

	});
</script>