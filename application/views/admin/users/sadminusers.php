<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf-token">


<div class="modal vusermodal">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close_SmsModalBtn" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body p-0">
				<div class="row set_wrapper m-0">
					<div class="tab_div col-md-2">
						<a href="" class="tab_link prof_a">Profile</a>
						<a href="" class="tab_link web_a">Websites</a>
						<a href="" class="tab_link rr_a">Ratings</a>
						<a href="" class="tab_link ls_a">Links</a>
						<a href="" class="tab_link ac_a text-danger font-weight-bolder">Account</a>
					</div>
					<div class="info_div col-md-10 p-3">
						<div class="closemodalbtndiv">
							<i class="fas fa-times closevuserbtn"></i>
						</div>
						<div class="prof_div">
							<?php include("viewuser/profile_edit.php") ?>
						</div>

						<div class="web_div pb-5">
							<?php include("viewuser/websites.php") ?>
						</div>

						<div class="rr_div pb-5">
							<?php include("viewuser/ratings.php") ?>
						</div>

						<div class="ls_div pb-5">
							<?php include("viewuser/links.php") ?>
						</div>

						<div class="ac_div">
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
		<a href="<?php echo base_url('newuser'); ?>" class="btn text-light" style="background:#294a63;">
			<i class="fas fa-user-plus pr-2"></i>New User
		</a>
	</div>
</div>


<table id="admintable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true" class="table-sm">
	<thead class="text-light" style="background:#294a63">
		<tr>
			<th data-field="name" data-sortable="true">Full Name / Username</th>
			<th data-field="email" data-sortable="true">Email</th>
			<th data-field="mobile" data-sortable="true">Mobile</th>
			<th data-field="cmpy" data-sortable="true">Company</th>
			<th data-field="active" data-sortable="true">Active</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($allusers->result() as $user) : ?>
			<tr id="<?php echo $user->uid ?>" data-formkey="<?php echo $user->form_key ?>" data-iscmpy="<?php echo $user->iscmpy ?>" data-cmpyid="<?php echo $user->cmpyid ?>" class="classroone">
				<td>
					<?php if (!empty($user->fname) || !empty($user->lname)) : ?>
						<?php echo $user->fname . " " . $user->lname ?>
					<?php else : ?>
						<?php echo $user->uname ?>
					<?php endif; ?>
				</td>
				<td><a href="mailto:<?php echo $user->email ?>"><?php echo $user->email ?></a></td>
				<td><?php echo $user->mobile ?></td>
				<td><?php echo $user->cmpy ?></td>
				<td><?php echo ($user->active === '0') ? '<i title="Account not verified" class="fas fa-circle text-warning acti"></i>' : ($user->active === '1' ? '<i title="Account active" class="fas fa-circle text-success acti"></i>' : ($user->active === '2' ? '<i title="Account not activate" class="fas fa-circle text-danger acti"></i>' : "undefined")) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>


<script type="text/javascript">
	var csrfName = $('.csrf-token').attr('name');
	var csrfHash = $('.csrf-token').val();

	function detailFormatter(index, row) {
		var html = []
		html.push('<div><a href="" id="' + row._id + '" formkey="' + row._data.formkey + '" iscmpy="' + row._data.iscmpy + '" cmpyid="' + row._data.cmpyid + '" class="vuser pr-1" style="color:#294a63">View</a></div>');
		return html.join('');
	}

	$(document).ready(function() {
		$(document).on('click', '.vuser', function(e) {
			e.preventDefault();

			var user_id = $(this).attr("id");
			var form_key = $(this).attr("formkey");
			var iscmpy = $(this).attr("iscmpy");
			var cmpyid = $(this).attr("cmpyid");

			$.ajax({
				url: "<?php echo base_url("viewuser"); ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					user_id: user_id,
					form_key: form_key,
					iscmpy: iscmpy,
					cmpyid: cmpyid,
				},
				error: function(res) {
					window.location.reload();
				},
				success: function(res) {
					//depopulate field

					$('.rspwd').val("");
					$('.rspwd,.email,.mobile').css('border', '1px solid #ced4da');
					$('.pwderr,i.fa-eye,i.fa-eye-slash').hide("");

					$('#webtable,#lstable,#rrtable').bootstrapTable('destroy');

					$('div.prof_div').show();
					$('div.web_div,div.ls_div,div.rr_div,div.ac_div').hide();
					$('.tab_link').css('font-weight', 'initial');
					$("a.prof_a").css('font-weight', 'bold');

					//populate profile
					$(".fname").val(res.uinfos.fname);
					$(".lname").val(res.uinfos.lname);
					$(".email").val(res.uinfos.email);
					$(".mobile").val(res.uinfos.mobile);
					$(".uname").val(res.uinfos.uname);
					if (res.uinfos.iscmpy === "1") {
						$(".cmpydiv").show();
						$(".cmpy").val(res.uinfos.cmpy);
					} else {
						$(".cmpydiv").hide();
						$(".cmpy").val("");
					}
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
					$(".emailt").text(res.udetails.total_email);
					$(".smst").text(res.udetails.total_sms);
					$(function() {
						var data = res.ulinks;
						$('#lstable').bootstrapTable({
							data: data
						});

					});

					//populate account
					if (res.uinfos.active == "0") {
						$(".act_btn").show();
						$(".deact_btn").hide();
					} else if (res.uinfos.active == "1") {
						$(".act_btn").hide();
						$(".deact_btn").show();
					} else if (res.uinfos.active == "2") {
						$(".act_btn").show();
						$(".deact_btn").hide();
					}

					if (res.uinfos.sub == "0") {
						$(".subact_btn").show();
						$(".subdeact_btn").hide();
					} else if (res.uinfos.sub == "1") {
						$(".subact_btn").hide();
						$(".subdeact_btn").show();
					}

					$(".deact_btn,.act_btn,.updatepwdbtn,.subdeact_btn,.subact_btn,.save_pinfo_btn").attr('user_id', res.uinfos.id);
					$(".save_pinfo_btn,.subdeact_btn,.subact_btn,.deact_btn,.act_btn").attr('form_key', res.uinfos.form_key);
					$(".updatepwdbtn").attr('user_email', res.uinfos.email);
					$(".updatepwdbtn").attr('user_name', res.uinfos.uname);


					$(".vusermodal").modal("show");

					$('.csrf-token').val(res.token);
				}
			});
		});

		$(document).on('click', '.closevuserbtn', function() {
			$(".vusermodal").modal("hide");
		});

		//disabled
		$(document).on('click', '.duser', function(e) {
			e.preventDefault();
			var uid = $(this).attr("id");
			var formkey = $(this).attr("formkey");
			var con = confirm("Are you sure you want to delete this user along with its data? Quota used by this user will not be refunded");
			if (con === false) {
				return false;
			} else {
				$.ajax({
					url: "<?php echo base_url("deleteuser"); ?>",
					method: "post",
					dataType: "json",
					data: {
						[csrfName]: csrfHash,
						uid: uid,
						formkey: formkey,
					},
					error: function(data) {
						window.location.reload();
					},
					success: function(data) {
						if (data.res === 'error') {
							$(".ajax_succ_div,.ajax_err_div").hide();
							$(".ajax_res_err").text(data.msg);
							$(".ajax_err_div").fadeIn();
						} else if (data.res === 'success') {
							window.location.reload();
						}

						$('.csrf-token').val(data.token);
					}
				})
			}
		});

		//disabled
		$(document).on('click', '.acti_', function(e) {
			var uact = $(this).attr("uact");
			var uid = $(this).attr("uid");
			var formkey = $(this).attr("uformkey");

			$.ajax({
				url: "<?php echo base_url("userstatus"); ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					uact: uact,
					uid: uid,
					formkey: formkey,
				},
				error: function(data) {
					window.location.reload();
				},
				success: function(data) {
					if (data.res === 'failed') {
						$(".ajax_succ_div,.ajax_err_div").hide();
						$(".ajax_res_err").text(data.msg);
						$(".ajax_err_div").fadeIn();
					} else if (data.res === 'success') {

						if (uact === '0') {
							$('i[uid=' + uid + ']').removeClass("text-warning").addClass("text-success").attr("uact", "1");
							$resmsg = "User account verified by you!";
						}
						if (uact === '1') {
							$('i[uid=' + uid + ']').removeClass("text-success").addClass("text-danger").attr("uact", "2");
							$resmsg = "User account de-activated!";
						}
						if (uact === '2') {
							$('i[uid=' + uid + ']').removeClass("text-danger").addClass("text-success").attr("uact", "1");
							$resmsg = "User account activated!";
						}

						$(".ajax_err_div,ajax_succ_div").hide();
						$(".ajax_res_succ").text($resmsg);
						$(".ajax_succ_div").fadeIn();
					}

					$('.csrf-token').val(data.token);
				}
			});
		});
	});
</script>