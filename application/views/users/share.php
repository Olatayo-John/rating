<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/share.css'); ?>">
<div class="container">
	<div class="emailmodal modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" method="post" id="upload_csv">
					<div class="modal-body">
						<h6 class="font-weight-bolder text-danger text-center">
							*CSV file must have header of only "Email"
						</h6>
						<input type="file" name="csv_file" id="csv_file" accept=".csv" class="form-control" style="border:none">
					</div>
					<div class="modal-footer justify-content-between">
						<button class="btn btn-secondary closebtn" type="button">Close</button>
						<button class="btn text-light importbtn" type="submit" style="background-color:#294a63">Import</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="smsmodal modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" method="post" id="smsupload_csv">
					<div class="modal-body">
						<h6 class="font-weight-bolder text-danger text-center">
							*CSV file must have header of only "Phonenumber"
						</h6>
						<input type="file" name="sms_csv_file" id="sms_csv_file" accept=".csv" class="form-control" style="border:none">
					</div>
					<div class="modal-footer justify-content-between">
						<button class="btn btn-secondary smsclosebtn" type="button">Close</button>
						<button class="btn text-light smsimportbtn" type="submit" style="background-color:#294a63">Import</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="mb-3 p-2 bg-white d-flex tab_div" style="justify-content:space-evenly;margin-top: 74px;">
	<a href="" class="tab_link mail_a sndasmailbtn"><i class="fas fa-envelope mr-2"></i>Send as Email</a>
	<a href="" class="tab_link sms_a sndassmsbtn"><i class=" fas fa-comment-dots mr-2"></i>Send as SMS</a>
</div>

<div class="mb-5 bg-white p-4 allform">
	<form action="<?php echo base_url('share'); ?>" method="post" id="gen_link_form" class="gen_link_form">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">
		<input type="hidden" name="userid" value="<?php echo $this->session->userdata('mr_id'); ?>" class="userid">
		<div class="import text-right d-flex justify-content-between mb-4">
			<button class="btn text-light singlemailsend" type="button" style="display: none;background-color:#294a63">Send single mail</button>
			<input type="hidden" name="link_for" class="link_for">
			<button class="btn text-light importemail" type="button" style="background-color:#294a63">Import multiple emails in CSV format</button>
			<a href="<?php echo base_url('emailsample_csv'); ?>" class="email_sample_csv btn btn-danger">
				<i class="fas fa-file-csv mr-2"></i>Download sample</a>
		</div>
		<div class="form-group">
			<label class="labelemail">E-mail</label>
			<input type="email" name="email" class="form-control email" placeholder="example@domain.com" id="email">
			<select class="form-control email_select" name="email_select" id="email_select" style="display: none;" readonly conn="false">
				<option></option>
			</select>
		</div>
		<div class="form-group">
			<label>Subject</label>
			<input type="text" name="subj" class="form-control subj">
		</div>
		<div class="form-group">
			<label>Body</label>
			<textarea class="form-control bdy" rows="8" name="bdy"></textarea>
		</div>
		<hr>
		<div class="sendlinkdiv">
			<button class="btn sendlinkbtn text-light" style="background-color:#294a63"><i class="fas fa-envelope mr-2"></i>Send Email</button>
			<button class="btn sendmultiplelinkbtn text-light" style="display: none;background-color:#294a63">
				<i class="fas fa-envelope mr-2"></i>Send Email</button>
		</div>
	</form>
	<form action="<?php echo base_url('smsshare'); ?>" method="post" id="sms_gen_link_form" class="sms_gen_link_form">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">
		<input type="hidden" name="userid" value="<?php echo $this->session->userdata('mr_id'); ?>" class="userid">
		<div class="sms_import text-right d-flex justify-content-between mb-4">
			<button class="btn text-light singlsmssend" type="button" style="display: none;background-color:#294a63">Send single sms</button>
			<input type="hidden" name="link_for" class="link_for">
			<button class="btn text-light smsimport" type="button" style="background-color:#294a63">Import multiple Phonenumber in CSV format</button>
			<a href="<?php echo base_url('smssample_csv'); ?>" class="email_sample_csv btn btn-danger">
				<i class="fas fa-file-csv mr-2"></i>Download sample</a>
		</div>
		<div class=" form-group">
			<label class="phonelabel">Phonenumber</label>
			<input type="number" name="mobile" class="form-control mobile" placeholder="Your mobile number" id="mobile">
			<span class="e_mobile text-danger font-weight-bolder" style="display: none;">Invalid mobile length</span>
			<select class="form-control sms_select" name="sms_select" id="sms_select" style="display: none;" readonly conn="false">
				<option></option>
			</select>
		</div>
		<div class="form-group">
			<label>Body</label>
			<textarea class="form-control smsbdy" rows="8" name="smsbdy"></textarea>
		</div>
		<hr>
		<div class="sendlinkdiv">
			<button class="btn text-light smssendlinkbtn" style="background-color:#294a63"><i class="fas fa-comment-dots mr-2"></i>Send SMS</button>
			<button class="btn text-light smssendmultiplelinkbtn" style="display: none;background-color:#294a63">
				<i class=" fas fa-comment-dots mr-2"></i>Send SMS</button>
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

		$.ajax({
			url: "<?php echo base_url('getlink'); ?>",
			method: "post",
			data: {
				id: id,
				[csrfName]: csrfHash
			},
			dataType: "json",
			success: function(data) {
				$('.csrf_hash').val(data.token);

				$('.subj').val("Rating");

				$(".bdy").load("<?php echo base_url("body.txt"); ?>");
				$(".smsbdy").load("<?php echo base_url("body.txt"); ?>");

				$('.gen_link_form').show();
			},
			error: function(data) {
				var protocol = window.location.protocol;
				var url_redirect = window.location.hostname + "/rating/account";
				var new_url = protocol + "//" + url_redirect;
				window.location.assign(new_url);
			}
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
				$('#csv_file').css('border', '2px solid #ced4da');
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
				},
				success: function(data) {
					$('.emailmodal').hide();
					$('#csv_file').val("");
					for (i = 0; i < data.length; i++) {
						$('#email_select').append('<option disabled class="email_options">' + data[i].Email + '</option>');
					}
					$('#email').hide();
					$('#email').val('nomailname@nodomainname.com');
					$('.labelemail').html('Emails');

					$('.sendlinkbtn').hide();
					$('.sendmultiplelinkbtn').show();

					$('#email_select').attr('conn', 'true');
					$('#email_select').show();
					$('.singlemailsend').show();

					bseu = "<?php echo base_url('send_multiple_email'); ?>";
					$("#gen_link_form").attr('action', bseu);
				},
				error: function(data) {
					alert('Error importing data');
				}
			});
		});

		$('#smsupload_csv').on('submit', function(e) {
			e.preventDefault();
			var sms_file = $('#sms_csv_file').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (sms_file == "" || sms_file == null) {
				$('#sms_csv_file').css('border', '2px solid red');
				return false;
			} else {
				$('#sms_csv_file').css('border', '2px solid #ced4da');
			}

			$.ajax({
				url: "<?php echo base_url('user/importcsv_sms'); ?>",
				method: "post",
				data: new FormData(this),
				[csrfName]: csrfHash,
				dataType: "json",
				contentType: false,
				cache: false,
				processData: false,
				beforSend: function(data) {
					$('.smsimportbtn').attr('disabled', 'disabled');
					$('.smsimportbtn').html('Importing...');
					$('.smsimportbtn').css('cursor', 'not-allowed');
					$('.smsimportbtn').removeClass('btn-success').addClass('btn-danger');
				},
				success: function(data) {
					$('#mobile').val('5555555555');
					$(".phonelabel").html("Phonenumbers");
					$('#sms_csv_file').val("");

					$('.smsmodal').hide();

					for (i = 0; i < data.length; i++) {
						$('#sms_select').append('<option disabled class="sms_options">+91' + data[i].Phonenumber + '</option>');
					}
					$('#mobile').hide();
					$('.smssendlinkbtn').hide();
					$('.smssendmultiplelinkbtn').show();
					$('#sms_select').attr('conn', 'true');
					$('#sms_select').show();
					$('.singlsmssend').show();
					bseu = "<?php echo base_url('sendmultiplesms'); ?>";
					$("#sms_gen_link_form").attr('action', bseu);
				},
				error: function(data) {
					alert('Error importing data');
				}
			});
		});

		$('button.importemail').click(function() {
			var sel_conn = $('#email_select').attr('conn');
			if (sel_conn == "true") {
				var ans = confirm("Are you sure you want to import a new data? Your imported data will be cleared.");
				if (ans == true) {
					$('.emailmodal').show();

					$('.email_options').remove();
					$('#email_select').attr('conn', 'false');
					$('#email_select').hide();

					$('.labelemail').html('E-mail');
					$('#email').val('');
					$('#email').show();
					$(".singlemailsend").hide();

					bseu = "<?php echo base_url('share'); ?>";
					$("#gen_link_form").attr('action', bseu);

					$('.sendlinkbtn').show();
					$('.sendmultiplelinkbtn').hide();
				} else {
					return false;
				}
			} else {
				$('.emailmodal').show();
			}
		});

		$('button.smsimport').click(function() {
			var sel_conn = $('#sms_select').attr('conn');
			if (sel_conn == "true") {
				var ans = confirm("Are you sure you want to import a new data? Your imported data will be cleared.");
				if (ans == true) {
					$('.smsmodal').show();

					$('.sms_options').remove();
					$('#sms_select').attr('conn', 'false');
					$('#sms_select').hide();

					$(".phonelabel").html("Phonenumber");
					$('#mobile').val('');
					$('#mobile').show();
					$(".singlsmssend").hide();

					bseu = "<?php echo base_url('smsshare'); ?>";
					$("#sms_gen_link_form").attr('action', bseu);

					$('.smssendlinkbtn').show();
					$('.smssendmultiplelinkbtn').hide();
				} else {
					return false;
				}
			} else {
				$('.smsmodal').show();
			}
		});

		$('.sendlinkbtn').click(function() {
			var email = $('.email').val();
			var sbj = $('.subj').val();
			var body = $('.bdy').val();

			if (email == "" || email == null) {
				$('.email').css('border', '2px solid red');
				return false;
			} else {
				$('.email').css('border', '2px solid #ced4da');
			}
			if (sbj == "" || sbj == null) {
				$('.subj').css('border', '2px solid red');
				return false;
			} else {
				$('.subj').css('border', '2px solid #ced4da');
			}
			if (body == "" || body == null) {
				$('.bdy').css('border', '2px solid red');
				return false;
			} else {
				$('.bdy').css('border', '2px solid #ced4da');
			}

			$.ajax({
				success: function() {
					$('.sendlinkbtn').attr('disabled', 'disabled');
					$('.sendlinkbtn').html('Sending...');
					$('.sendlinkbtn').css('cursor', 'not-allowed');
				}
			});
		});

		$('.singlemailsend').click(function() {
			$('.email_options').remove();
			$('#email_select').attr('conn', 'false');
			$('#email_select').hide();

			$('.labelemail').html('E-mail');
			$('#email').val('');
			$('#email').show();
			$(".singlemailsend").hide();

			bseu = "<?php echo base_url('share'); ?>";
			$("#gen_link_form").attr('action', bseu);

			$('.sendlinkbtn').show();
			$('.sendmultiplelinkbtn').hide();
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
				$('.email').css('border', '2px solid #ced4da');
			}
			if (subj == "" || subj == null) {
				$('.subj').css('border', '2px solid red');
				return false;
			} else {
				$('.subj').css('border', '2px solid #ced4da');
			}
			if (bdy == "" || bdy == null) {
				$('.bdy').css('border', '2px solid red');
				return false;
			} else {
				$('.bdy').css('border', '2px solid #ced4da');
			}

			var emaildata = [];
			$(".email_options").each(function() {
				var eachopt = $(this).val();
				emaildata.push(eachopt);
			});

			$.ajax({
					url: "<?php echo base_url('sendmultipleemail'); ?>",
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
					},
					error: function() {
						alert("Error sending e-mails. Please try again");
						window.location.reload();
					}
				})
				.done(function() {
					window.location.reload();
				});
		});

		$('.singlsmssend').click(function() {
			$('.sms_options').remove();
			$('#sms_select').attr('conn', 'false');
			$('#sms_select').hide();

			$('#mobile').val('');
			$('#mobile').show();
			$(".phonelabel").html("Phonenumber");
			$(".singlsmssend").hide();

			bseu = "<?php echo base_url('smsshare'); ?>";
			$("#sms_gen_link_form").attr('action', bseu);

			$('.smssendlinkbtn').show();
			$('.smssendmultiplelinkbtn').hide();
		});

		$('.smssendlinkbtn').click(function() {
			var mobile = $('.mobile').val();
			var smsbdy = $('.smsbdy').val();

			if (mobile == "" || mobile == null) {
				$('.mobile').css('border', '2px solid red');
				return false;
			}
			if (mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border', '2px solid red');
				$('.e_mobile').show();
				return false;
			} else {
				$('.mobile').css('border', '2px solid #ced4da');
				$('.e_mobile').hide();
			}
			if (smsbdy == "" || smsbdy == null) {
				$('.smsbdy').css('border', '2px solid red');
				return false;
			} else {
				$('.smsbdy').css('border', '2px solid #ced4da');
			}

			$.ajax({
				success: function() {
					$('.smssendlinkbtn').attr('disabled', 'disabled');
					$('.smssendlinkbtn').html('Sending...');
					$('.smssendlinkbtn').css('cursor', 'not-allowed');
				}
			});
		});


		$('.smssendmultiplelinkbtn').click(function(e) {
			e.preventDefault();
			var link_for = $('.link_for').val();
			var mobile = $('.mobile').val();
			var smsbdy = $('.smsbdy').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (mobile == "" || mobile == null) {
				$('.mobile').css('border', '2px solid red');
				return false;
			}
			if (mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border', '2px solid red');
				$('.e_mobile').show();
				return false;
			} else {
				$('.mobile').css('border', '2px solid #ced4da');
				$('.e_mobile').hide();
			}
			if (smsbdy == "" || smsbdy == null) {
				$('.smsbdy').css('border', '2px solid red');
				return false;
			} else {
				$('.smsbdy').css('border', '2px solid #ced4da');
			}

			var mobiledata = [];
			$(".sms_options").each(function() {
				var eachopt = $(this).val();
				mobiledata.push(eachopt);
			});

			$.ajax({
					url: "<?php echo base_url('sendmultiplesms'); ?>",
					method: "post",
					data: {
						mobiledata: mobiledata,
						smsbdy: smsbdy,
						link_for: link_for,
						[csrfName]: csrfHash,
					},
					beforeSend: function() {
						$('.smssendmultiplelinkbtn').attr('disabled', 'disabled');
						$('.smssendmultiplelinkbtn').html('Sending...');
						$('.smssendmultiplelinkbtn').css('cursor', 'not-allowed');
					},
					error: function() {
						alert("Error sending messages. Please try again");
						window.location.reload();
					}
				})
				.done(function() {
					window.location.reload();
				});
		});

	});
</script>