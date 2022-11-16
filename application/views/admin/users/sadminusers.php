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
						<a href="" class="tab_link cmpy_a" tabDivN="cmpy_div">Company</a>
						<a href="" class="tab_link qt_a" tabDivN="qt_div">Quota</a>
						<a href="" class="tab_link web_a" tabDivN="web_div">Websites</a>
						<a href="" class="tab_link rr_a" tabDivN="rr_div">Ratings</a>
						<a href="" class="tab_link ls_a" tabDivN="ls_div">Links</a>
						<a href="" class="tab_link ac_a text-danger font-weight-bolder" tabDivN="ac_div">Account</a>
					</div>

					<div class="info_div col-md-10 p-3">
						<div class="modalcloseDiv">
							<h6 class="h_userName"></h6>
							<i class="fas fa-times closevuserbtn text-danger"></i>
						</div>
						<input type="hidden" id="currentUserId" user_id="" form_key="" user_email="" user_name="" user_iscmpy="" user_cmpyid="" user_isadmin="">

						<div class="prof_div einfoDiv">
							<?php include("viewuser/profile.php") ?>
						</div>

						<div class="cmpy_div einfoDiv">
							<?php include("viewuser/company.php") ?>
						</div>

						<div class="qt_div einfoDiv">
							<?php include("viewuser/quota.php") ?>
						</div>

						<div class="web_div einfoDiv pb-5">
							<?php include("viewuser/websites.php") ?>
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
		<!-- <h4><?php echo $this->session->userdata("mr_cmpy") ?> Users</h4> -->
	</div>
	<div>
		<a href="<?php echo base_url('add'); ?>" title="New User" class="btn text-light" style="background:#294a63;">
			<i class="fas fa-user-plus pr-2"></i>New User
		</a>
	</div>
</div>


<table id="admintable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true">
	<thead class="text-light" style="background:#294a63">
		<tr>
			<th data-field="name" data-sortable="true">User</th>
			<th data-field="type" data-sortable="true">Type</th>
			<th data-field="action" scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($allusers->result() as $user) : ?>
			<tr id="<?php echo $user->id ?>" data-formkey="<?php echo $user->form_key ?>" data-iscmpy="<?php echo $user->iscmpy ?>" data-cmpyid="<?php echo $user->cmpyid ?>">
				<td>
					<?php if (!empty($user->fname) || !empty($user->lname)) : ?>
						<?php echo $user->fname . " " . $user->lname ?>
					<?php else : ?>
						<?php echo $user->uname ?>
					<?php endif; ?>
				</td>
				<td class="w-25">
					<?php if ($user->admin === '1') : ?>
						<span><?php echo strtoupper($user->cmpy) ?> Admin</span>
					<?php elseif (!empty($user->cmpyid) && $user->iscmpy === '1') : ?>
						<span><?php echo ucwords($user->cmpy) ?> User</span>
					<?php else : ?>
						<span>Regular User</span>
					<?php endif; ?>
				</td>
				<td class="w-25">
					<div>
						<a href="">
							<i class="fa fa-reorder editUserI" title="Show" id="<?php echo $user->id ?>" data-formkey="<?php echo $user->form_key ?>" data-iscmpy="<?php echo $user->iscmpy ?>" data-cmpyid="<?php echo $user->cmpyid ?>" data-admin="<?php echo $user->admin ?>"></i>
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
			var isadmin = $(this).attr("data-admin");

			if (user_id == 'undefined' || form_key == 'undefined') {
				var vvv = "<?php echo base_url('/logs') ?>";
				window.location.assign(vvv);
			} else {
				$.ajax({
					url: "<?php echo base_url("sadmin-view-user"); ?>",
					method: "post",
					dataType: "json",
					data: {
						[csrfName]: csrfHash,
						user_id: user_id,
						form_key: form_key,
						iscmpy: iscmpy,
						cmpyid: cmpyid,
						isadmin: isadmin
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

							//populate company
							if (res.uinfos.admin !== '1') {
								$(".cmpyLogoImg").attr('src', '');

								$('.cmpy_a').hide();
							} else {
								$(".cmpyName").val(res.uinfos.cmpyName);
								$(".cmpyEmail").val(res.uinfos.cmpyEmail);
								$(".cmpyMobile").val(res.uinfos.cmpyMobile);
								var logoPath = '<?php echo base_url('uploads/') ?>' + res.uinfos.cmpyLogo;
								$(".cmpyLogoImg").attr('src', logoPath);

								$(".h_cmpyLogoName").val(res.uinfos.cmpyLogo);
								$(".h_userid").val(res.uinfos.userid);
								$(".h_form_key").val(res.uinfos.form_key);
								$(".h_cmpydetailID").val(res.uinfos.cmpydetailID);

								$('.cmpy_a').show();
							}

							//populate quota
							if (res.uinfos.cmpyid !== null) {
								$('.company').text('');

								$('.qt_a').hide();
							} else {
								$(".email_quota").val(res.uquota.email_quota);
								$(".sms_quota").val(res.uquota.sms_quota);
								$(".whatsapp_quota").val(res.uquota.whatsapp_quota);
								$(".web_quota").val(res.uquota.web_quota);
								$('.company').text(res.uinfos.cmpyName);

								if (res.uinfos.admin !== '1') {
									$('.cmpy_qt_info').hide();
								} else {
									$('.cmpy_qt_info').show();
								}

								$('.qt_a').show();
							}


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
								'user_name': res.uinfos.uname,
								'user_iscmpy': res.uinfos.iscmpy,
								'user_cmpyid': res.uinfos.cmpyid,
								'user_isadmin': res.uinfos.admin
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
	});
</script>