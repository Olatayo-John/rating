<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/edit.css'); ?>">
<div class="tab_div ml-3 mr-3 mt-3 con">
	<a href="" class="tab_link prof_a"><i class="fas fa-user-alt mr-2"></i>Profile</a>
	<a href="" class="tab_link web_a"><i class="fas fa-tachometer-alt mr-2"></i>Websites</a>
	<a href="" class="tab_link ac_a"><i class="fas fa-user-cog mr-2"></i>Account</a>
</div>

<div class="con mt-4 mr-3 ml-3 mb-3 pl-4 pt-4 prof_div">
	<h4 class="text-dark">Personal Information</h4>
	<hr class="p_i">
	<form action="<?php echo base_url('user/personal_edit'); ?>" method="post">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="form-group">
			<label><span class="text-danger">* </span>Username</label>
			<input type="text" name="uname" class="form-control uname" value="<?php echo $user_info->uname ?>" placeholder="Pick a Username">
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label>First Name</label>
				<input type="text" name="fname" class="form-control fname" value="<?php echo $user_info->fname ?>" placeholder="Your First Name">
			</div>
			<div class="form-group col-md-6">
				<label>Last Name</label>
				<input type="text" name="lname" class="form-control lname" value="<?php echo $user_info->lname ?>" placeholder="Your Last Name">
			</div>
		</div>
		<div class="form-group">
			<label><span class="text-danger">* </span>Email</label>
			<input type="email" name="email" class="form-control email" value="<?php echo $user_info->email ?>" placeholder="example@domain-name.cmom">
		</div>
		<div class="form-group">
			<label><span class="text-danger">* </span>Mobile</label>
			<input type="number" name="mobile" class="form-control mobile" value="<?php echo $user_info->mobile ?>" placeholder="0123456789">
			<div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
		</div>
		<div class="form-group">
			<div class="d-flex" style="justify-content:space-between">
				<label>Your Link<i class="fas fa-copy ml-2 copy_i" style="cursor:pointer" onclick="copylink_fun('#linkshare')"></i></label>
				<div class="linkcopyalert font-weight-bolder" style="display:none;color:#294a63">Copied to your clipboard</div>
			</div>
			<input type="text" name="linkshare" class="form-control linkshare" id='linkshare' value="<?php echo base_url("wtr/") . $user_info->form_key ?>" readonly>
		</div>
		<div class="form-group text-left">
			<button class="btn text-light save_pinfo_btn" type="submit" style="background-color:#294a63">
				<i class="fas fa-save mr-2"></i>Save</button>
		</div>
	</form>
</div>

<div class="con mt-3 mr-3 ml-3 mb-3 pl-4 pr-4 pt-4 web_div">
	<div class="d-flex btn_wrapper_div" style="justify-content:space-between">
		<div>
			<h4 class="text-dark">Websites</h4>
			<hr class="web">
		</div>
		<div style="color:#294a63;font-weight:600;">
			<span class="web_num_total"><?php echo $websites->num_rows(); ?></span> Website(s) out of <?php echo $this->session->userdata("mr_web_quota") ?> <i class="fas fa-question-circle help_i" title="For more website quota, contact us at nktech.in@gmail.com"></i>
		</div>
		<div>
			<?php if ($websites->num_rows() < $this->session->userdata("mr_web_quota")) : ?>
				<button type="button" class="text-light btn addwebmodal_btn" style="background:#294a63">
					<i class="fas fa-plus-circle mr-2"></i>New Website
				</button>
			<?php endif ?>
		</div>
	</div>

	<div class="modal edit_web_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<form method='post'>
						<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<input type="hidden" class="web_id form-control" name="web_id" value="">
						<div class="form-group">
							<label class="font-weight-bolder">Website Name</label>
							<input type="text" name="web_name_edit" class="web_name_edit form-control" placeholder="Name of the webiste" required readonly>
						</div>
						<div class="form-group">
							<label class="mb-0 font-weight-bolder">Website Link</label>
							<input type="url" name="web_link_edit" class="web_link_edit form-control" placeholder="Website link" required readonly>
						</div>
						<div class="modal_btn_actions d-flex justify-content-between">
							<button type="button" class="btn btn-secondary close_editweb_modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php if ($websites->num_rows() < $this->session->userdata("mr_web_quota")) : ?>
		<div class="modal add_web_modal">
			<div class="modal-dialog modal-dialog-top">
				<div class="modal-content">
					<div class="modal-header text-danger justify-content-center font-weight-bolder">
						You can't change or remove any of this information after
					</div>
					<div class="modal-body">
						<form method="post" action="<?php echo base_url("user/user_new_website") ?>" class="add_web_modal_form">
							<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="form-group">
								<label class="mb-0 font-weight-bolder">Website Name</label>
								<input type="text" name="web_name_new" class="web_name_new form-control" placeholder="Name of the webisite" required>
							</div>
							<div class="form-group">
								<label class="mb-0 font-weight-bolder">Website Link</label>
								<div class="text-danger font-weight-bolder mt-0 web_link_err"></div>
								<input type="url" name="web_link_new" class="web_link_new form-control" placeholder="e.g https://domainname.com" required>
							</div>
							<div class="modal_btn_actions d-flex justify-content-between">
								<button type="button" class="btn btn-secondary closewebmodal_btn">Close</button>
								<button type="submit" class="btn add_web_modal_btn text-light" style="background-color:#294a63;">
									<i class="fas fa-save mr-2"></i>Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>

	<?php if ($websites->num_rows() === 0) : ?>
		<h5 class="text-center text-uppercase pt-4 pb-3">No website(s) present</h5>
	<?php endif; ?>

	<?php if ($websites->num_rows() > 0) : ?>
		<div class="row col-md-12 mt-4 websites_foreach_div_header">
			<div class="col-md-1">
				<span class="font-weight-bolder">Status</span>
			</div>
			<div class="text-center col">
				<span class="font-weight-bolder">Website</span>
			</div>
			<div class="col-md-4 text-center">
				<span class="font-weight-bolder">Actions<i class="fas fa-question-circle ml-2" title="Only active websites will be available for giving reviews"></i></span>
			</div>
		</div>
		<hr>
		<?php foreach ($websites->result_array() as $web) : ?>
			<div class="row col-md-12 websites_foreach_div" style="padding-right:0">
				<?php if ($web['active'] == "1") : ?>
					<div class="col-md-1" style="margin:auto">
						<i class="fas fa-circle text-success" id="<?php echo $web['id'] ?>"></i>
					</div>
				<?php endif; ?>
				<?php if ($web['active'] == "0") : ?>
					<div class="col-md-1" style="margin:auto">
						<i class="fas fa-circle text-danger" id="<?php echo $web['id'] ?>"></i>
					</div>
				<?php endif; ?>
				<div class="form-group col">
					<input type="text" name="web_name" class="form-control web_input text-center text-uppercase" value="<?php echo ucfirst($web['web_name']) ?>" id="<?php echo $web['id'] ?>" placeholder="Website name" readonly>
				</div>
				<div class="col-md-4" style="padding:0">
					<div class="d-flex flex-row" style="justify-content:center">
						<button type="button" class="btn text-light edit_web_btn " id="<?php echo $web['id'] ?>" style="background:#294a63">
							View
						</button>
						<?php if ($web['active'] == "1") : ?>
							<button type="button" class="btn btn-danger status_web_btn ml-2" id="<?php echo $web['id'] ?>" status="0">
								Deactivate
							</button>
						<?php endif; ?>
						<?php if ($web['active'] == "0") : ?>
							<button type="button" class="btn text-light status_web_btn ml-2" id="<?php echo $web['id'] ?>" status="1" style="background:#294a63">
								Activate
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
</div>

<div class="con mt-3 mr-3 ml-3 mb-3 pl-4 pt-4 ac_div">
	<h4 class="text-dark">Account Settings</h4>
	<hr class="account">
	<form action="<?php echo base_url('user/account_edit'); ?>" method="post">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="form-group">
			<label><i class="fas fa-key mr-2"></i>Current Password<span class="text-danger"> *</span></label>
			<input type="text" name="c_pwd" class="form-control c_pwd" placeholder="Your current password">
		</div>
		<div class="form-group">
			<label><i class="fas fa-lock mr-2"></i>New Password<span class="text-danger"> *</span></label>
			<input type="password" minlenght="6" name="n_pwd" class="form-control n_pwd" placeholder="Password must be at least 6 characters long">
			<span class="text-danger font-weight-bolder n_pwd_err">Password is too short</span>
		</div>
		<div class="form-group">
			<label><i class="fas fa-lock mr-2"></i>Re-type Password<span class="text-danger"> *</span></label>
			<input type="password" minlenght="6" name="rtn_pwd" class="form-control rtn_pwd" placeholder="Re-type Password">
			<span class="text-danger font-weight-bolder rtn_pwd_err">Passwords do not match</span>
		</div>
		<div class="form-group text-right">
			<button class="btn btn-danger deact_btn" type="button" user_id="<?php echo $user_info->id ?>"><i class="fas fa-user-alt-slash mr-2"></i>De-activate account?</button>
		</div>
		<div class="form-group text-left">
			<button class="btn text-light saveact_btn" type="submit saveact_btn" style="background-color:#294a63">
				<i class="fas fa-save mr-2"></i>Save</button>
		</div>
	</form>
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/edit.js'); ?>"></script>
<script>
	function copylink_fun(element) {
		var link = $("<input>");
		$("body").append(link);
		link.val($(element).val()).select();
		document.execCommand("copy");
		link.remove();
		$('.linkcopyalert').fadeIn("slow").delay("5000").fadeOut("slow");
	}

	$(document).ready(function() {
		$("[data-toggle]").tooltip()

		$(document).on('click', 'button.edit_web_btn', function() {
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			var id = $(this).attr('id');

			$.ajax({
				url: "<?php echo base_url('user/edit_website'); ?>",
				method: "post",
				data: {
					[csrfName]: csrfHash,
					id: id,
				},
				dataType: "json",
				success: function(data) {
					$('.web_name_edit').val(data.web_name);
					$('.web_link_edit').val(data.web_link);
					$('.csrf_token').val(data.token);
					$('.edit_web_modal').fadeIn();
					$('.web_id').val(id);
				},
				error: function(data) {
					window.location.reload();
				}
			});
		});

		$(document).on('click', 'button.status_web_btn', function() {
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			var id = $(this).attr('id');
			var status = $(this).attr('status');

			console.log(id);
			console.log(status);

			$.ajax({
				url: "<?php echo base_url('user/website_status'); ?>",
				method: "post",
				data: {
					[csrfName]: csrfHash,
					id: id,
					status: status,
				},
				success: function(data) {
					window.location.reload();
				},
				error: function(data) {
					window.location.reload();
				}
			});
		});

		$(document).on('click', 'button.deact_btn', function() {
			var con = confirm("Are you sure you want to perform this operation? Your account will be de-activated and you'll be logged out completely");
			if (con == false) {
				return false;
			} else if (con == true) {

				var userid = $(this).attr("user_id");
				var csrfHash = $('.csrf_token').val();
				var csrfName = $('.csrf_token').attr("name");

				$.ajax({
					url: "<?php echo base_url('user/deact_account'); ?>",
					method: "post",
					data: {
						userid: userid,
						[csrfName]: csrfHash
					},
					beforeSend: function(data) {
						$('button.deact_btn').html("Deactivating...");
					},
					success: function(data) {
						var url = "<?php echo base_url('user/logout') ?>";
						window.location.assign(url);
					}
				})
			}
		});

		$(document).on('click', 'button.addwebmodal_btn', function(e) {
			e.preventDefault();
			var num = $('.web_input').length;
			var web_quota = "<?php echo $this->session->userdata("mr_web_quota"); ?>";

			if (parseInt(num) >= web_quota) {
				$(".add_web_modal_btn").hide();
				$('.web_name,.web_link').attr("readonly", "true");
				$('.add_web_modal').modal("hide");
			} else {
				$('.add_web_modal').modal("show");
			}
		});

		$(document).on('click', 'button.closewebmodal_btn', function(e) {
			e.preventDefault();
			$('.add_web_modal').modal("hide");
		});

		$(document).on('click', 'button.add_web_modal_btn', function() {
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			var web_name_new = $('.web_name_new').val();
			var web_link_new = $('.web_link_new').val();

			if (web_name_new == "" || web_name_new == null) {
				$('.web_name_new').css('border', '2px solid red');
				return false;
			} else {
				$('.web_name_new').css('border', '1px solid #ced4da');
			}
			if (web_link_new == "" || web_link_new == null) {
				$(".web_link_new").css('border', '2px solid red');
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
				$(".web_link_new").css('border', '2px solid red');
				$(".web_link_err").html("Invalid WEB URL").fadeIn();
				return false;
			}
		});

	});
</script>