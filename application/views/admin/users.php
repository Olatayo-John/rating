<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/users.css'); ?>">
<div class="mr-3 ml-3 mt-4 bg-light">
	<div class="modal addusermodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header d-flex justify-content-center mb-0">
					<h5 class="text-dark font-weight-bolder">Enter user details correctly</h5>
				</div>
				<div class="mb-0 alert-danger chkboxerr container mb-1" style="display: none;">
					<i class="fas fa-exclamation-circle"></i>
					<strong>Pick at least a method to send login credentials to user</strong>
				</div>
				<form action="<?php echo base_url('admin/add_user'); ?>" method="post" class="mt-0">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf-token">
					<div class="modal-body"></div>
			</div>
			</form>
		</div>
	</div>
	<div class="modal updateusermodal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-body">
					<div class="row d-flex justify-content-between" style="background:#141E30;">
						<div class="nameofuser_h">
							<h6 class="text-light mt-auto mb-auto" style="text-transform:uppercase"></h6>
						</div>
						<div class="close_x_div">
							<span class="text-light close_x_icon">&times</span>
						</div>
					</div>
					<div class="tab_div mt-2">
						<a href="" class="tab_link prof_a">Profile</a>
						<a href="" class="tab_link web_a">Websites</a>
						<a href="" class="tab_link ac_a">Account</a>
					</div>
					<input type="hidden" name="user_id" class="user_id">
					<input type="hidden" name="user_form_key" class="user_form_key">
					<div class="profile_div">
						<div class="form-group">
							<label><span class="text-danger font-weight-bolder">* </span>Username</label>
							<input type="text" name="uname" class="form-control uname" placeholder="Username">
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>First Name</label>
									<input type="text" name="fname" class="form-control fname" placeholder="First Name">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" name="lname" class="form-control lname" placeholder="Last Name">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><span class="text-danger font-weight-bolder">* </span>E-mail:</label>
									<input type="email" name="email" class="form-control email" placeholder="User E-mail Address" id="email">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label><span class="text-danger font-weight-bolder">* </span>Mobile:</label>
									<input type="number" name="mobile" class="form-control mobile" placeholder="User Mobile Number" id="mobile">
									<div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
								</div>
							</div>
						</div>
						<div class="updatebtngrp d-flex justify-content-between mb-2">
							<button class="btn btn-secondary closeupdatebtn bradius">Close</button>
							<button class="btn text-light user_profileupdate bradius" style="background:#141E30">Update</button>
						</div>
					</div>
					<div class="website_div">
						<div class="add_web text-right">
							<button type="button" class="add_web_btn text-light" style="background-color:#141E30;padding:6px;border:none">
								<i class="fas fa-plus-circle"></i>
								Add Website
							</button>
						</div>
						<div class="website_form_div">
						</div>
						<div class="updatebtngrp d-flex justify-content-between mb-2 web_btngrp">
							<button class="btn btn-secondary closeupdatebtn bradius">Close</button>
							<button class="btn text-light user_webpdate bradius" style="background:#141E30">Update</button>
						</div>
					</div>
					<div class="account_div">
						<div class="form-group pwddiv">
							<label>New Password</label>
							<input type="text" name="u_pwd" class="form-control u_pwd">
							<div class="text-danger font-weight-bolder pwderr">Password will be changed on this user!</div>
						</div>
						<div class="form-group mt-2">
							<button class="btn btn-dark genpwdbtn" type="button">Generate password</button>
						</div>
						<div class="form-group mt-2 text-right">
							<button class="btn btn-danger delact_btn" type="button">Delete account</button>
							<button class="btn btn-danger deact_btn" type="button">De-activate account</button>
						</div>
						<div class="updatebtngrp d-flex justify-content-between mb-2">
							<button class="btn btn-secondary closeupdatebtn bradius">Close</button>
							<button class="btn text-light user_accupdate bradius" style="background:#141E30">Update</button>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="mb-3 mr-3 ml-3 pt-3 col-md-6 ml-auto">
		<div class="d-flex flex-row" style="border-bottom: 1px solid #141E30">
			<span class="" style="border-radius: 0;display:inline-flex; "><i class="fas fa-search"></i></span>
			<input type="text" name="search_user" id="search_user" class="form-control search_user" placeholder="Search by any field" style="border-radius: 0" autofocus>
		</div>
	</div>
	<div class="mt-3 mr-3 ml-3 mb-3">
		<a href="<?php echo base_url('admin/users_export_csv'); ?>" class="btn text-light csvbtn" style="background:#141E30;">
			<i class="fas fa-file-csv mr-2"></i>CSV Download
		</a>
		<button class="btn text-light reload_btn" data-toggle="tooltip" title="Reload table" style="background:#141E30;">
			<i class="fas fa-sync-alt"></i>
		</button>
	</div>
	<div class="container-fluid table-responsive">
		<table class="table table-center table-hover table-md table-light table-bordered">
			<tr class="font-weight-bolder text-light text-center" style="background: #141E30">
				<th>
					<span>Status</span>
				</th>
				<th>
					<div class="inh">
						<i class="fas fa-sort" name="uname" type="desc"></i>
						<span>User</span>
					</div>
				</th>
				<th>
					<div class="inh">
						<i class="fas fa-sort " name="fname" type="desc"></i>
						<span>Full Name</span>
					</div>
				</th>
				<th>
					<div class="cmp">
						<i class="fas fa-sort" name="mobile" type="desc"></i>
						<span>Mobile</span>
					</div>
				</th>
				<th>
					<div class="cmp">
						<i class="fas fa-sort" name="email" type="desc"></i>
						<span>E-Mail</span>
					</div>
				</th>
				<th>
					<div class="cmp">
						<i class="fas fa-sort" name="sub" type="desc"></i>
						<span>Subscribed?</span>
					</div>
				</th>
				<th class="text-danger text-center font-weight-bolder">
					Action
				</th>
			</tr>

			<?php if ($users->num_rows() <= '0') : ?>
				<tr class="text-dark">
					<td colspan='7' class='font-weight-bolder text-dark text-center'>No data found</td>
				</tr>
			<?php endif; ?>
			<?php if ($users->num_rows() > '0') : ?>
				<?php foreach ($users->result_array() as $info) : ?>
					<tr class="text-dark text-center">
						<td class="">
							<?php if ($info['active'] == 0) : ?>
								<i class="fas fa-circle text-danger"></i>
							<?php elseif ($info['active'] == 1) : ?>
								<i class="fas fa-circle text-success"></i>
							<?php endif; ?>
						</td>
						<td class="text-uppercase"><?php echo $info['uname'] ?></td>
						<td class=""><?php echo $info['fname'] . " " . $info['lname']  ?></td>
						<td class=""><?php echo $info['mobile'] ?></td>
						<td class=""><?php echo $info['email'] ?></td>
						<td class="">
							<?php if ($info['sub'] == 0) : ?>
								No
							<?php elseif ($info['sub'] == 1) : ?>
								Yes
							<?php endif; ?>
						</td>
						<td class="font-weight-bolder">
							<div class="d-flex" style="justify-content:space-around">
								<button class="btn text-light editbtn" id="<?php echo $info['id'] ?>" form_key="<?php echo $info['form_key'] ?>" style="background:#141E30">
									<i class="fas fa-user-alt text-light "></i>
								</button>
								<button class="btn text-light delbtn" id="<?php echo $info['id'] ?>" form_key="<?php echo $info['form_key'] ?>" style="background:#141E30">
									<i class="fas fa-trash-alt text-danger "></i>
								</button>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
		<div class="table_pag_div">
			<?php echo $links; ?>
		</div>
	</div>
</div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/users.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// $(".updateusermodal").show();
		$(document).on('click', 'button.reload_btn', function() {
			reload_table();
		});

		function reload_table() {
			var csrfName = $('.csrf-token').attr('name');
			var csrfHash = $('.csrf-token').val();
			$.ajax({
				method: "POST",
				url: "<?php echo base_url('admin/reload_table') ?>",
				data: {
					[csrfName]: csrfHash
				},
				success: function(data) {
					$('.table').html(data);
					$(".table_pag_div").show();
				}
			})
		}

		function load_data(query) {
			var csrfName = $('.csrf-token').attr('name');
			var csrfHash = $('.csrf-token').val();
			$.ajax({
				method: "POST",
				url: "<?php echo base_url('admin/users_search_user') ?>",
				data: {
					query: query,
					[csrfName]: csrfHash
				},
				success: function(data) {
					$('.table').html(data);
				}
			})
		}

		$('#search_user').keyup(function() {
			var search = $(this).val();
			if (search != '') {
				$(".table_pag_div").hide();
				load_data(search);
			} else {
				$(".table_pag_div").show();
				reload_table();
			}
		});

		$(document).on('click', 'i.fa-sort', function() {
			var param = $(this).attr('name');
			var type = $(this).attr('type');
			var csrfName = $('.csrf-token').attr('name');
			var csrfHash = $('.csrf-token').val();
			$.ajax({
				url: "<?php echo base_url('admin/users_filter_param') ?>",
				method: "post",
				data: {
					param: param,
					type: type,
					[csrfName]: csrfHash,
				},
				success: function(data) {
					$('.table').html(data);
					if (type == 'desc') {
						$('.fas').attr('type', 'asc');
					} else {
						$('.fas').attr('type', 'desc');
					}
				},
				error: function(data) {
					alert('Error filtering');
				}
			});
		});

		$(document).on('click', 'button.editbtn', function() {
			var user_id = $(this).attr("id");
			var form_key = $(this).attr("form_key");
			var csrfName = $('.csrf-token').attr('name');
			var csrfHash = $('.csrf-token').val();
			//$('.updateusermodal').modal('show');

			$.ajax({
				url: "<?php echo base_url('admin/get_user') ?>",
				method: "POST",
				data: {
					user_id: user_id,
					form_key: form_key,
					[csrfName]: csrfHash
				},
				dataType: "json",
				success: function(data) {
					// console.log(data);
					//console.log(data.infos);
					//console.log(data.webs);

					$('.csrf-token').val(data.token);
					$('.user_id').val(data.infos[0].id);
					$('.user_form_key').val(data.infos[0].form_key);
					$('.uname').val(data.infos[0].uname);
					$('.fname').val(data.infos[0].fname);
					$('.lname').val(data.infos[0].lname);
					$('.mobile').val(data.infos[0].mobile);
					$('.email').val(data.infos[0].email);

					if (data.infos[0].fname !== null || data.infos[0].lname !== null) {
						$('div.nameofuser_h h6').html(data.infos[0].fname + " " + data.infos[0].lname);
					} else {
						$('div.nameofuser_h h6').html(data.infos[0].uname);
					}

					if (data.webs.length == 0) {
						$("div.website_form_div").append('<p class="text-center text-dark mt-4 font-weight-bolder">USER HAS NO DATA</p>');
						$("button.user_webpdate").hide();
					} else {
						for (let index = 0; index < data.webs.length; index++) {
							console.log(data.webs[index]);
							$("div.website_form_div").append('<div class="form-group web_form_group"><span class="text-danger">* </span><label class="web_form_label">' + data.webs[index].web_name + '</label><input type="text" name="' + data.webs[index].web_name + '" class="form-control web_form_input ' + data.webs[index].web_name + '" web_id="' + data.webs[index].id + '" placeholder="https://domain-name.com" value="' + data.webs[index].web_link + '" required></div>');
						}
						$("button.user_webpdate").show();
					}
					$('.updateusermodal').modal('show');
				}
			});
		});

		$(document).on('click', '.updatebtn', function() {
			var u_user_id = $('.u_user_id').val();
			var uname = $('.uname').val();
			var full_name = $('.full_name').val();
			var email = $('.email').val();
			var mobile = $('.mobile').val();
			var c_name = $('.c_name').val();
			var c_add = $('.c_add').val();
			var c_email = $('.c_email').val();
			var c_mobile = $('.c_mobile').val();
			var c_web = $('.c_web').val();
			var fb_link = $('.fb_link').val();
			var google_link = $('.google_link').val();
			var glassdoor_link = $('.glassdoor_link').val();
			var trust_pilot_link = $('.trust_pilot_link').val();
			var u_pwd = $('.u_pwd').val();
			var csrfName = $('.csrf-token').attr('name');
			var csrfHash = $('.csrf-token').val();

			if (email == "" || email == null) {
				$('.email').css('border', '2px solid red');
				document.getElementById("email").scrollIntoView();
				return false;
			} else {
				$('.email').css('border', '0 solid red');
			}
			if (mobile == "" || mobile == null) {
				$('.mobile').css('border', '2px solid red');
				document.getElementById("mobile").scrollIntoView();
				return false;
			}
			if (mobile.length < 10 || mobile.length > 10) {
				document.getElementById("mobile").scrollIntoView();
				$('.mobileerr').show();
				return false;
			} else {
				$('.mobile').css('border', '0 solid red');
				$('.mobileerr').hide();
			}
			if (uname == "" || uname == null) {
				$('.uname').css('border', '2px solid red');
				document.getElementById("uname").scrollIntoView();
				return false;
			} else {
				$('.uname').css('border', '0 solid red');
			}

			$.ajax({
					url: "<?php echo base_url('admin/update_user') ?>",
					method: "POST",
					data: {
						u_user_id: u_user_id,
						uname: uname,
						full_name: full_name,
						email: email,
						mobile: mobile,
						c_name: c_name,
						c_add: c_add,
						c_email: c_email,
						c_mobile: c_mobile,
						c_web: c_web,
						fb_link: fb_link,
						google_link: google_link,
						glassdoor_link: glassdoor_link,
						trust_pilot_link: trust_pilot_link,
						u_pwd: u_pwd,
						[csrfName]: csrfHash
					},
					beforeSend: function() {
						$('.updatebtn').removeClass("btn-success").addClass("btn-danger");
						$('.updatebtn').html("Updating...");
						$('.updatebtn').attr("disabled", "disabled");
						$('.updatebtn').css("cursor", "not-allowed");
					},
					error: function(data) {
						alert("Error updating. Please refresh page");
					}
				})
				.done(function() {
					window.location.reload();
				});
		});

		$(document).on('click', 'button.delbtn', function() {
			var user_id = $(this).attr('id');
			var form_key = $(this).attr('form_key');
			var csrfHash = $('.csrf-token').val();
			var csrfName = $('.csrf-token').attr('name');
			var con = confirm("Are you sure you want to delete this user and all of its data?");
			if (con == false) {
				return false;
			} else if (con == true) {
				//console.log(user_id);
				//console.log(form_key);
				$.ajax({
						url: "<?php echo base_url('admin/delete_user'); ?>",
						method: "post",
						data: {
							user_id: user_id,
							form_key: form_key,
							[csrfName]: csrfHash
						},
						error: function(data) {
							alert('Failed to delete. Please refresh page');
							window.location.reload();
						}
					})
					.done(function() {
						window.location.reload();
					});
			}
		});

	});
</script>