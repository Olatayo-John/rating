<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/edit.css'); ?>">
<div class="tab_div ml-3 mr-3 mt-3 con">
	<a href="" class="tab_link prof_a">Profile</a>
	<a href="" class="tab_link web_a">Websites</a>
	<a href="" class="tab_link ac_a">Account</a>
</div>

<div class="con mt-4 mr-3 ml-3 mb-3 pl-4 pt-4 prof_div">
	<h4 class="text-dark mb-4 p_i mb-3">Personal Information</h4>
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
		<div class="form-group text-left">
			<button class="btn text-light save_pinfo_btn" type="submit" style="background-color:#00695C">Save</button>
		</div>
	</form>
</div>
<div class="con mt-3 mr-3 ml-3 mb-3 pl-4 pr-4 pt-4 web_div">
	<h4 class="text-dark web mb-3">Websites</h4>

	<div class="mb-5 some_name_div mt-4">
		<div class="add_web">
			<button type="button" class="add_web_btn text-light" style="background-color:#00695C;padding:6px;border:none">
				<i class="fas fa-plus-circle"></i>
				Add Website
			</button>
		</div>
		<div class="search_div">
			<input type="text" name="website_search" class="website_search form-control" placeholder="Search by website name...">
		</div>
		<div class="search_icon_div">
			<i class="fas fa-search search_icon"></i>
		</div>
	</div>

	<div class="modal add_web_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<form method="post" action="<?php echo base_url("user/add_website") ?>" class="add_web_modal_form">
						<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="form-group">
							<label>Website Name</label>
							<input type="text" name="web_name" class="web_name form-control" placeholder="Name of the webiste" required>
						</div>
						<div class="form-group">
							<label class="mb-0">Website Link</label>
							<div class="text-danger font-weight-bolder mt-0">Link must start with http or https</div>
							<input type="url" name="web_link" class="web_link form-control" placeholder="Website link" required>
						</div>
						<div class="modal_btn_actions d-flex justify-content-between">
							<button type="button" class="btn btn-secondary close_web_modal">Close</button>
							<button type="submit" class="btn add_web_modal_btn text-light" style="background-color:#00695C;">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal edit_web_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<form action="<?php echo base_url("user/update_website") ?>" method='post'>
						<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<input type="hidden" class="web_id form-control" name="web_id" value="">
						<div class="form-group">
							<label>Website Name</label>
							<input type="text" name="web_name_edit" class="web_name_edit form-control" placeholder="Name of the webiste" required>
						</div>
						<div class="form-group">
							<label class="mb-0">Website Link</label>
							<div class="text-danger font-weight-bolder mt-0">Link must start with http or https</div>
							<input type="url" name="web_link_edit" class="web_link_edit form-control" placeholder="Website link" required>
						</div>
						<div class="modal_btn_actions d-flex justify-content-between">
							<button type="button" class="btn btn-secondary close_editweb_modal">Close</button>
							<button type="submit" class="btn update_web_modal_btn text-light" id="" style="background-color:#00695C;">Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal delete_web_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<p class="text-center font-weight-bolder text-danger">Are you sure you want to perform this operation?</p>
					<p class="text-center font-weight-bolder">This website and all of its data will be completly deleted!</p>
					<div class="d-flex justify-content-between">
						<button type="button" class="btn btn-secondary close_delweb_modal">No</button>
						<button type="submit" class="btn yes_delweb_modal_btn text-light" id="" style="background-color:#00695C;">Yes</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if ($websites->num_rows() < 0) : ?>
		<h4 class="text-center text-uppercase mt-3">No website present</h4>
	<?php endif; ?>
	<?php if ($websites->num_rows() > 0) : ?>
		<?php foreach ($websites->result_array() as $web) : ?>
			<div class="row col-md-12" style="padding-right:0">
				<?php if ($web['active'] == "1") : ?>
					<div class="col-md-1" style="margin:auto">
						<i class="fas fa-circle text-success" style="font-size: 20px;"></i>
					</div>
				<?php endif; ?>
				<?php if ($web['active'] == "0") : ?>
					<div class="col-md-1" style="margin:auto">
						<i class="fas fa-circle text-danger" style="font-size: 20px;"></i>
					</div>
				<?php endif; ?>
				<div class="form-group col">
					<input type="text" name="web_name" class="form-control web_input" value="<?php echo $web['web_name'] ?>" id="<?php echo $web['id'] ?>" placeholder="Website name" readonly>
				</div>
				<div class="col-md-4" style="padding:0">
					<div class="d-flex flex-row" style="justify-content:flex-end">
						<button type="button" class="btn btn-dark edit_web_btn " id="<?php echo $web['id'] ?>">
							Edit
						</button>
						<button type="button" class="btn btn-dark delete_web_btn ml-2" id="<?php echo $web['id'] ?>">
							Delete
						</button>
						<?php if ($web['active'] == "1") : ?>
							<button type="button" class="btn btn-danger status_web_btn ml-2" id="<?php echo $web['id'] ?>" status="0">
								Deactivate
							</button>
						<?php endif; ?>
						<?php if ($web['active'] == "0") : ?>
							<button type="button" class="btn btn-success status_web_btn ml-2" id="<?php echo $web['id'] ?>" status="1">
								Activate
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<div class="con mt-3 mr-3 ml-3 mb-3 pl-4 pt-4  ac_div">
	<h4 class="text-dark account mb-3">Account Settings</h4>
	<form action="<?php echo base_url('user/account_edit'); ?>" method="post">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="form-group">
			<label><i class="fas fa-key mr-2"></i>Current Password<span class="text-danger">* </span></label>
			<input type="text" name="c_pwd" class="form-control c_pwd" placeholder="Your current password">
		</div>
		<div class="form-group">
			<label><i class="fas fa-lock mr-2"></i>New Password</label>
			<input type="number" name="n_pwd" class="form-control n_pwd" placeholder="Password must be at least 6 characters long">
			<span class="text-danger font-weight-bolder n_pwd_err">Password is too short</span>
		</div>
		<div class="form-group">
			<label><i class="fas fa-lock mr-2"></i>Re-type Password</label>
			<input type="text" name="rtn_pwd" class="form-control rtn_pwd">
			<span class="text-danger font-weight-bolder rtn_pwd_err">Passwords do not match</span>
		</div>
		<div class="form-group text-right">
			<button class="btn btn-danger deact_btn" type="button" user_id="<?php echo $user_info->id ?>">De-activate account?</button>
		</div>
		<div class="form-group text-left">
			<button class="btn text-light saveact_btn" type="submit saveact_btn" style="background-color:#00695C">Save</button>
		</div>
	</form>
</div>

<div class="addweb_div" id="addweb_div">
	<div class="modal-body">
		<p>Are you sure you want to perform this operation?</p>
		<p>Your account will be de-activated and you'll be logged out completely</p>
		<div class="d-flex justify-content-between">
			<button class="btn btn-dark deact_close_btn">No</button>
			<button class="btn btn-danger yes_btn">Yes</button>
		</div>
	</div>
</div>



<script type="text/javascript" src="<?php echo base_url('assets/js/edit.js'); ?>"></script>

<script>
	$(document).ready(function() {
		$('.website_search').keyup(function() {
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			var search_data = $(this).val();

			console.log(search_data);

			if (search_data == "" || search_data == null) {
				reload_table_function();
			} else {
				search_function(search_data);
			}
		});

		function reload_table_function() {}

		function search_function(search_data) {
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			$.ajax({
				url: "<?php echo base_url('user/search_website'); ?>",
				method: "post",
				data: {
					[csrfName]: csrfHash,
					search_data: search_data,
				},
				dataType: "json",
				success: function(data) {
					$('.').html(data);
				},
				error: function(data) {
					alert("Error searching...");
				}
			});
		}

		$('button.edit_web_btn').click(function() {
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

		$('button.update_web_modal_btn').click(function(e) {
			// e.preventDefault();
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			var id = $('.web_id').val();
			var web_name_edit = $('.web_name_edit').val();
			var web_link_edit = $('.web_link_edit').val();

			if (web_name_edit == "" || web_name_edit == null) {
				$('.web_name_edit').css('border', '2px solid red');
				return false;
			} else {
				$('.web_name_edit').css('border', '1px solid #ced4da');
			}
			if (web_link_edit == "" || web_link_edit == null) {
				$('.web_link_edit').css('border', '2px solid red');
				return false;
			} else {
				$('.web_link_edit').css('border', '1px solid #ced4da');
			}
		});

		$(document).on('click', 'button.yes_delweb_modal_btn', function() {
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			var id = $(this).attr('id');

			console.log(id);

			$.ajax({
				url: "<?php echo base_url('user/delete_website'); ?>",
				method: "post",
				data: {
					[csrfName]: csrfHash,
					id: id,
				},
				success: function(data) {
					window.location.reload();
				},
				error: function(data) {
					window.location.reload();
				}
			});
		});

		$('button.status_web_btn').click(function() {
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
	});
</script>