<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf-token">


<div class="modal vusermodal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<!-- <div class="modal-header">
				<button type="button" class="close close_SmsModalBtn" aria-hidden="true">&times;</button>
			</div> -->
			<div class="modal-body p-0">
				<div class="row set_wrapper m-0">
					<div class="tab_div col-md-2 p-0">
						<a href="" class="tab_link prof_a" tabDivN="prof_div">Profile</a>
						<a href="" class="tab_link web_a" tabDivN="web_div">Platforms</a>
						<a href="" class="tab_link rr_a" tabDivN="rr_div">Ratings</a>
						<a href="" class="tab_link ls_a" tabDivN="ls_div">Links</a>
						<a href="" class="tab_link ac_a text-danger font-weight-bolder" tabDivN="ac_div">Account</a>
					</div>

					<div class="info_div col-md-10 p-3">
						<div class="modalcloseDiv">
							<h6 class="h_userName"></h6>
							<i class="fas fa-times closevuserbtn text-danger"></i>
						</div>
						<input type="hidden" id="currentUserId" user_id="" form_key="" user_email="" user_name="">

						<div class="prof_div einfoDiv">
							<?php include("viewuser/profile.php") ?>
						</div>

						<div class="web_div einfoDiv pb-5">
							<?php include("viewuser/platform.php") ?>
						</div>

						<div class="rr_div einfoDiv pb-5">
							<?php include("viewuser/ratings.php") ?>
						</div>

						<div class="ls_div einfoDiv pb-5">
							<?php include("viewuser/links.php") ?>
						</div>

						<div class="ac_div einfoDiv">
							<?php include("viewuser/account.php") ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="d-flex pb-4" style="justify-content:space-between;">
	<div style="font-weight: bold;text-transform: uppercase;color:#294a63">
		<h4><?php echo $this->session->userdata("mr_cmpy") ?></h4>
	</div>
	<div>
		<a href="<?php echo base_url('add'); ?>" title="New User" class="btn text-light" style="background:#294a63;">
			<i class="fas fa-plus pr-2"></i>New User
		</a>
	</div>
</div>


<table id="admintable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true" class="table-md">
	<thead class="text-light" style="background:#294a63">
		<tr>
			<th data-field="name" data-sortable="true">User</th>
			<th data-field="sub" data-sortable="true">Subscription</th>
			<th data-field="action" scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($adminusers->result() as $user) : ?>
			<tr id="<?php echo $user->id ?>" data-formkey="<?php echo $user->form_key ?>" data-iscmpy="<?php echo $user->iscmpy ?>" data-cmpyid="<?php echo $user->cmpyid ?>">
				<td>
					<?php if (!empty($user->fname) || !empty($user->lname)) : ?>
						<?php echo $user->fname . " " . $user->lname ?>
					<?php else : ?>
						<?php echo $user->uname ?>
					<?php endif; ?>
				</td>
				<td class="w-25">
					<?php if ($user->sub === '1') : ?>
						<i class="fa-solid fa-toggle-on text-success subI" mod='active' sub="<?php echo $user->sub ?>" sub_id="<?php echo $user->id ?>" data-formkey="<?php echo $user->form_key ?>"></i>
					<?php elseif ($user->sub === '0') : ?>
						<i class="fa-solid fa-toggle-off text-danger subI" mod='not_active' sub="<?php echo $user->sub ?>" sub_id="<?php echo $user->id ?>" data-formkey="<?php echo $user->form_key ?>"></i>
					<?php endif; ?>
				</td>
				<td class="w-25">
					<div class="">
						<a href="">
							<i class="fa fa-reorder editUserI" title="Show" id="<?php echo $user->id ?>" data-formkey="<?php echo $user->form_key ?>" data-iscmpy="<?php echo $user->iscmpy ?>" data-cmpyid="<?php echo $user->cmpyid ?>"></i>
						</a>
						<?php if ($user->active == '0') : ?>
							<span class="text-warning"> Unverified</span>
						<?php endif; ?>
						<?php if ($user->active == '2') : ?>
							<span class="text-danger"> Deactivated</span>
						<?php endif; ?>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>



<script type="text/javascript">
	var csrfName = $('.csrf-token').attr('name');
	var csrfHash = $('.csrf-token').val();

	$(document).ready(function() {

		//view and get user details
		$(document).on('click', 'i.editUserI', function(e) {
			e.preventDefault();

			var user_id = $(this).attr("id");
			var form_key = $(this).attr("data-formkey");
			var iscmpy = $(this).attr("data-iscmpy");
			var cmpyid = $(this).attr("data-cmpyid");

			if (user_id == '' || form_key == undefined) {
				var vvv = "<?php echo base_url('/logs') ?>";
				window.location.assign(vvv);
			} else {
				$.ajax({
					url: "<?php echo base_url("admin-view-user"); ?>",
					method: "post",
					dataType: "json",
					data: {
						[csrfName]: csrfHash,
						user_id: user_id,
						form_key: form_key,
						iscmpy: iscmpy,
						cmpyid: cmpyid,
					},
					beforeSend: function(res) {
						clearAlert();

						$('#userprofile_Form,#usercmpy_sadminForm,#userquota_sadminForm,#useraccount_Form').trigger("reset");

						$('.pwderr,i.fa-eye,i.fa-eye-slash').hide("");
					},
					success: function(res) {
						if (res.status === 'error') {
							window.location.assign(res.redirect);
						} else if (res.status === false) {
							$(".ajax_res_err").append(res.msg);
							$(".ajax_err_div").fadeIn();
						} else if (res.status === true) {
							//destroy tables
							$('#webtable,#lstable,#rrtable').bootstrapTable('destroy');

							//hide un-selected tabs
							$('div.einfoDiv').hide();
							$('div.prof_div').show();

							$('.tab_link').css({
								'font-weight': 'initial',
								'background': 'transparent',
								'color': '#fff',
							});
							$('a.prof_a').css({
								'font-weight': '500',
								'background': '#fff',
								'color': '#294a63',
							});

							//populate profile
							$(".fname").val(res.uinfos.fname);
							$(".lname").val(res.uinfos.lname);
							$(".email").val(res.uinfos.email);
							$(".mobile").val(res.uinfos.mobile);
							$(".uname").val(res.uinfos.uname);
							$('#userprofile_Form').find('select[name=gender] option[value=' + res.uinfos.gender + ']').attr('selected', 'selected').end();
							$(".dob").val(res.uinfos.dob);
							var seg = $(".linkshare").attr("data-host");
							$(".linkshare").val(seg + res.uinfos.form_key);

							//populate web
							$(".webt").text(res.uwebs.length);
							$(function() {
								var data = res.uwebs;
								$('#webtable').bootstrapTable({
									data: data
								});

							});

							//populate profileratings
							$(".rrt").text(res.uratings.length);
							$(function() {
								var data = res.uratings;
								$('#rrtable').bootstrapTable({
									data: data
								});

							});

							//populate linkssent
							$(".lst").text(res.ulinks.length);
							$(".emailt").text(res.temail.length);
							$(".smst").text(res.tsms.length);
							$(".whpt").text(res.twhp.length);
							$(function() {
								var data = res.ulinks;
								$('#lstable').bootstrapTable({
									data: data
								});

							});

							//populate account
							//activate and de-activate acct
							if (res.uinfos.active == "1") {
								$(".act_btn").hide();
								$(".deact_btn").show();
							} else if (res.uinfos.active == "0" || res.uinfos.active == "2") {
								$(".act_btn").show();
								$(".deact_btn").hide();
							}

							//activate and de-activate user sub
							if (res.uinfos.sub == "0") {
								$(".subact_btn").show();
								$(".subdeact_btn").hide();
							} else if (res.uinfos.sub == "1") {
								$(".subact_btn").hide();
								$(".subdeact_btn").show();
							}

							$("#currentUserId").attr({
								'user_id': res.uinfos.id,
								'form_key': res.uinfos.form_key,
								'user_email': res.uinfos.email,
								'user_name': res.uinfos.uname
							});
							$('.h_userName').text(res.uinfos.uname);


							$(".vusermodal").modal("show");
						}

						$('.csrf-token').val(res.token);
					},
					error: function(res) {
						var con = confirm('Some error occured. Refresh?');
						if (con === true) {
							window.location.reload();
						} else if (con === false) {
							return false;
						}
					},
				});
			}
		});

		//activate or deactivate sub
		$(document).on('click', 'i.subI', function(e) {
			e.preventDefault();

			var user_sub = $(this).attr("sub");
			var user_id = $(this).attr("sub_id");
			var user_formKey = $(this).attr("data-formkey");
			var mod = $(this).attr("mod");

			$.ajax({
				url: "<?php echo base_url("user-subscription"); ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					user_sub: user_sub,
					user_id: user_id,
					user_formKey: user_formKey,
				},
				beforeSend: function(res) {
					clearAlert();
				},
				success: function(res) {
					if (res.status === 'error') {
						window.location.assign(res.redirect);
					} else if (res.status === false) {
						$(".ajax_res_err").append(res.msg);
						$(".ajax_err_div").fadeIn();
					} else if (res.status === true) {
						$(".ajax_res_succ").append(res.msg);
						$(".ajax_succ_div").fadeIn();

						if (mod === 'not_active') {
							$('i.subI[sub_id="' + user_id + '"]').removeClass('fa-toggle-off text-danger').addClass("fa-toggle-on text-success").attr({
								'mod': 'active',
								'sub': '1'
							});
						} else if (mod === 'active') {
							$('i.subI[sub_id="' + user_id + '"]').removeClass("fa-toggle-on text-success").addClass("fa-toggle-off text-danger").attr({
								'mod': 'not_active',
								'sub': '0'
							});
						}
					}

					$('.csrf-token').val(res.token);
				},
				error: function(res) {
					var con = confirm('Some error occured. Refresh?');
					if (con === true) {
						window.location.reload();
					} else if (con === false) {
						return false;
					}
				},
			});
		});

	});
</script>