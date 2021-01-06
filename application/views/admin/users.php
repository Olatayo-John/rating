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
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body" style="padding: 1rem">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><span class="text-danger font-weight-bolder">* </span>Username</label>
								<input type="text" name="uname" class="form-control uname" placeholder="Pick a username" id="uname">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Full Name</label>
								<input type="text" name="full_name" class="form-control full_name" placeholder="Your full name">
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
					<div class="form-group">
						<label>Company Name</label>
						<input type="text" name="c_name" class="form-control c_name" placeholder="Company Name">
					</div>
					<div class="form-group">
						<label>Company Address</label>
						<input type="text" name="c_add" class="form-control c_add" placeholder="Company Address">
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Company E-mail</label>
								<input type="email" name="c_email" class="form-control c_email" placeholder="Company E-mail Address">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Company Mobile</label>
								<input type="number" name="c_mobile" class="form-control c_mobile" placeholder="Company Mobile">
								<div class="text-danger font-weight-bolder c_mobileerr" style="display: none;">Invalid mobile length</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Company Website</label>
						<input type="text" name="c_web" class="form-control c_web" placeholder="https://domain-name.com">
					</div>
					<div class="form-group">
						<label>Google Link</label>
						<input type="text" name="google_link" class="form-control google_link" placeholder="https://domain-name.com">
					</div>
					<div class="form-group">
						<label>Facebook Link</label>
						<input type="text" name="fb_link" class="form-control fb_link" placeholder="https://domain-name.com">
					</div>
					<div class="form-group">
						<label>Glassdoor Link</label>
						<input type="text" name="glassdoor_link" class="form-control glassdoor_link" placeholder="https://domain-name.com">
					</div>
					<div class="form-group">
						<label>Trust Pilot Link</label>
						<input type="text" name="trust_pilot_link" class="form-control trust_pilot_link" placeholder="https://domain-name.com">
					</div>
					<div class="form-group mb-0 row pwddiv">
						<div class="col-md-8">
							<label>Password</label>
							<input type="text" name="u_pwd" class="form-control u_pwd">
						</div>
						<div class="text-danger font-weight-bolder pwderr ml-3">Password will be changed on this user</div>
						<div class="col-md-6 mt-2">
							<button class="btn btn-dark genpwdbtn" type="button">Generate new password</button>
						</div>
					</div>
				</div>
				<div class="updatebtngrp d-flex justify-content-between mb-2">
					<button class="btn btn-dark closeupdatebtn bradius ml-2">Close</button>
					<input type="hidden" name="u_user_id" class="u_user_id">
					<button class="btn btn-success updatebtn bradius mr-2">Update</button>
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
		<a href="<?php echo base_url('admin/users_export_csv'); ?>" class="btn text-light csvbtn" style="background: linear-gradient(to right, #243B55, #141E30);">
			<i class="fas fa-file-csv mr-2"></i>CSV Download
		</a>
		<button class="btn text-light reload_btn" data-toggle="tooltip" title="Reload table" style="background: linear-gradient(to right, #243B55, #141E30);">
			<i class="fas fa-sync-alt"></i>
		</button>
	</div>
	<div class="container-fluid table-responsive">
		<table class="table table-center table-hover table-md table-light">
			<tr class="font-weight-bolder text-light" style="background: linear-gradient(to right, #243B55, #141E30);">
				<th><div class="inh">	
					<i class="fas fa-sort" name="uname" type="desc"></i>
					<span>User</span>
				</div></th>
				<th><div class="inh">	
					<i class="fas fa-sort " name="mobile" type="desc"></i>
					<span>User Mobile</span>
				</div></th>
				<th><div class="inh">				
					<i class="fas fa-sort" name="c_name" type="desc"></i>
					<span>Company</span>
				</div></th>
				<th><div class="cmp">					
					<i class="fas fa-sort" name="c_mobile" type="desc"></i>
					<span>Company Mobile</span>
				</div></th>
				<th><div class="cmp">				
					<i class="fas fa-sort" name="c_email" type="desc"></i>
					<span>Company Mail</span>
				</div></th>
				<th><div class="inh">				
					<i class="fas fa-sort" name="active" type="desc"></i>
					<span>Active?</span>
				</div></th>
				<th><div class="cmp">				
					<i class="fas fa-sort" name="sub" type="desc"></i>
					<span>Subscribed?</span>
				</div></th>
				<th class="text-danger text-center font-weight-bolder">
					Action
				</th>
			</tr>

			<?php if($users->num_rows() == '0'): ?>
				<tr class="text-dark">
					<td colspan='6' class='font-weight-bolder text-dark text-center'>No data found</td>
				</tr>
			<?php endif; ?>
			<?php if($users->num_rows() > '0'): ?>
				<?php foreach($users->result_array() as $info): ?>
					<tr class="text-dark text-center">
						<td class="text-uppercase"><?php echo $info['uname'] ?></td>
						<td class=""><?php echo $info['mobile'] ?></td>
						<td class="text-uppercase"><?php echo $info['c_name'] ?></td>
						<td class=""><?php echo $info['c_mobile'] ?></td>
						<td class=""><?php echo $info['c_email'] ?></td>
						<td class=""><?php echo $info['active'] ?></td>
						<td class=""><?php echo $info['sub'] ?></td>
						<td class="font-weight-bolder">
							<div class="d-flex">
								<button class="btn btn-light editbtn" id="<?php echo $info['id'] ?>" form_key="<?php echo $info['form_key'] ?>">
									<i class="fas fa-user-edit text-success "></i>
								</button>
								<button class="btn btn-light delbtn" id="<?php echo $info['id'] ?>" form_key="<?php echo $info['form_key'] ?>">
									<i class="fas fa-trash-alt text-danger "></i>
								</button>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			</table><?php echo $links; ?>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/users.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click','button.reload_btn',function() {
			reload_table();
		});

		function reload_table(){
			var csrfName= $('.csrf-token').attr('name');
			var csrfHash= $('.csrf-token').val();
			$.ajax({
				method: "POST",
				url: "<?php echo base_url('admin/reload_table') ?>",
				data: {
					[csrfName]:csrfHash
				},
				success: function(data){
					$('.table').html(data);
				}
			})
		}

		function load_data(query){
			var csrfName= $('.csrf-token').attr('name');
			var csrfHash= $('.csrf-token').val();
			$.ajax({
				method: "POST",
				url: "<?php echo base_url('admin/users_search_user') ?>",
				data: {
					query:query,
					[csrfName]:csrfHash
				},
				success: function(data){
					$('.table').html(data);
				}
			})
		}

		$('#search_user').keyup(function() {
			var search = $(this).val();
			if (search != '') {
				load_data(search);
			}else{
				reload_table();
			}
		});

		$(document).on('click','i.fa-sort',function() {
			var param= $(this).attr('name');
			var type= $(this).attr('type');
			var csrfName= $('.csrf-token').attr('name');
			var csrfHash= $('.csrf-token').val();
			$.ajax({
				url: "<?php echo base_url('admin/users_filter_param') ?>",
				method: "post",
				data: {
					param:param,
					type:type,
					[csrfName]:csrfHash,
				},
				success: function(data) {
					$('.table').html(data);
					if (type == 'desc') {
						$('.fas').attr('type','asc');
					}else{
						$('.fas').attr('type','desc');
					}
				},
				error: function(data) {
					alert('Error filtering');
				}
			});
		});

		$(document).on('click','button.editbtn',function() {
			var user_id= $(this).attr("id");
			var csrfName = $('.csrf-token').attr('name'); 
			var csrfHash = $('.csrf-token').val();
			$('.updateusermodal').modal('show');

			$.ajax({
				url: "<?php echo base_url('admin/get_user') ?>",
				method: "POST",
				data: {
					user_id:user_id,
					[csrfName]:csrfHash
				},
				dataType: "json",
				success: function(data)
				{
					$('.u_user_id').val(data.id);
					$('.csrf-token').val(data.token);
					if (data.admin == "0") {
						$('.u_dept').html("User").val("0");
						$('.u_dept_two').html("Admin").val("1");
					}else {
						$('.u_dept').html("Admin").val("1");
						$('.u_dept_two').html("User").val("0");
					}
					$('.uname').val(data.uname);
					$('.full_name').val(data.full_name);
					$('.u_mobile').val(data.u_mobile);
					$('.email').val(data.email);
					$('.mobile').val(data.mobile);
					$('.c_name').val(data.c_name);
					$('.c_add').val(data.c_add);
					$('.c_email').val(data.c_email);
					$('.c_mobile').val(data.c_mobile);
					$('.c_web').val(data.c_web);
					$('.fb_link').val(data.fb_link);
					$('.google_link').val(data.google_link);
					$('.glassdoor_link').val(data.glassdoor_link);
					$('.trust_pilot_link').val(data.trust_pilot_link);
					$('.form_key').val(data.form_key);
					$('.active').val(data.active);
					$('.sub').val(data.sub);
					$('.updateusermodal').modal('show');
				}
			});
		});

		$(document).on('click','.updatebtn', function(){
			var u_user_id= $('.u_user_id').val();
			var uname= $('.uname').val();
			var full_name= $('.full_name').val();
			var email= $('.email').val();
			var mobile= $('.mobile').val();
			var c_name= $('.c_name').val();
			var c_add= $('.c_add').val();
			var c_email= $('.c_email').val();
			var c_mobile= $('.c_mobile').val();
			var c_web= $('.c_web').val();
			var fb_link= $('.fb_link').val();
			var google_link= $('.google_link').val();
			var glassdoor_link= $('.glassdoor_link').val();
			var trust_pilot_link= $('.trust_pilot_link').val();
			var u_pwd= $('.u_pwd').val();
			var csrfName = $('.csrf-token').attr('name'); 
			var csrfHash = $('.csrf-token').val();			

			if (email == "" || email == null) {
				$('.email').css('border','2px solid red');
				document.getElementById("email").scrollIntoView();
				return false;
			}else{
				$('.email').css('border','0 solid red');
			}
			if (mobile == "" || mobile == null) {
				$('.mobile').css('border','2px solid red');
				document.getElementById("mobile").scrollIntoView();
				return false;
			}if (mobile.length < 10 || mobile.length > 10) {
				document.getElementById("mobile").scrollIntoView();
				$('.mobileerr').show();
				return false;
			}else{
				$('.mobile').css('border','0 solid red');
				$('.mobileerr').hide();
			}
			if (uname == "" || uname == null) {
				$('.uname').css('border','2px solid red');
				document.getElementById("uname").scrollIntoView();
				return false;
			}else{
				$('.uname').css('border','0 solid red');
			}

			$.ajax({
				url: "<?php echo base_url('admin/update_user') ?>",
				method: "POST",
				data: {
					u_user_id:u_user_id,
					uname:uname,
					full_name:full_name,
					email:email,
					mobile:mobile,
					c_name:c_name,
					c_add:c_add,
					c_email:c_email,
					c_mobile:c_mobile,
					c_web:c_web,
					fb_link:fb_link,
					google_link:google_link,
					glassdoor_link:glassdoor_link,
					trust_pilot_link:trust_pilot_link,
					u_pwd:u_pwd,
					[csrfName]:csrfHash
				},
				beforeSend: function() {
					$('.updatebtn').removeClass("btn-success").addClass("btn-danger");
					$('.updatebtn').html("Updating...");
					$('.updatebtn').attr("disabled","disabled");
					$('.updatebtn').css("cursor","not-allowed");
				},
				error: function(data)
				{
					alert("Error updating. Please refresh page");
				}
			})
			.done(function() {
				window.location.reload();
			});
		});

		$(document).on('click','button.delbtn', function() { 
			var user_id= $(this).attr('id');
			var form_key= $(this).attr('form_key');
			var csrfHash= $('.csrf-token').val();
			var csrfName= $('.csrf-token').attr('name');
			var con= confirm("Are you sure you want to delete this user and all of its data?");
			if (con == false) {
				return false;
			}else if(con == true){
			//console.log(user_id);
			//console.log(form_key);
			$.ajax({
				url: "<?php echo base_url('admin/delete_user'); ?>",
				method: "post",
				data: {
					user_id:user_id,
					form_key:form_key,
					[csrfName]:csrfHash
				},
				error: function(data) {
					alert('Failed to delete. Please refresh page');
				}
			})
			.done(function() {
				window.location.reload();
			});
		}       
	});

	});
</script>