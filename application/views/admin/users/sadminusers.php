<div class="mr-3 ml-3 bg-white" style="margin-top: 74px;">
	<div class="modal addusermodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo base_url('admin/add_user'); ?>" method="post" class="mt-0">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf-token">
					<div class="modal-body">
						<div class="form-group mt-3">
							<label>Website Name</label>
							<input type="text" name="web_name_add" class="web_name_add form-control" placeholder="Name of the webiste" required>
							<div class="text-danger weblinkadd_err font-weight-bolder"></div>
						</div>
						<div class="form-group">
							<label class="mb-0">Website Link</label>
							<input type="url" name="web_link_add" class="web_link_add form-control" placeholder="https://domainname.com" required>
							<div class="addweberr text-left" id="weberr" style="display:all">
								<span class="text-danger font-weight-bolder addweberr_span"></span>
							</div>
						</div>
						<div class="updatebtngrp d-flex justify-content-between mb-2 web_btngrp">
							<button class="btn btn-secondary close_add_web_btn bradius" type="button">Close</button>
							<div class="spinner-border web_add_spinner" style="position:absolute;right:70px;width:20px;height:20px;top:unset;left:unset;display:none;margin-top:5px;">
								<span class="sr-only">Loading...</span>
							</div>
							<button class="btn text-light web_addbtn bradius" userid="" userformkey="" useractive="" type="submit" style="background:#294a63">Add</button>
						</div>
					</div>
			</div>
			</form>
		</div>
	</div>

	<div class="modal edit_web_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<input type="hidden" name="modal_webid" class="modal_webid" value="">
					<div class="form-group mt-3">
						<label>Website Name</label>
						<input type="text" name="web_name_edit" class="web_name_edit form-control" placeholder="Name of the webiste" required>
					</div>
					<div class="form-group">
						<label class="mb-0">Website Link</label>
						<div class="weberr text-left" id="weberr" style="display:all">
						</div>
						<input type="url" name="web_link_edit" class="web_link_edit form-control" placeholder="Website link" required>
					</div>
					<div class="updatebtngrp d-flex justify-content-between mb-2 web_btngrp">
						<button class="btn btn-secondary close_edit_web_modal bradius">Close</button>
						<div class="spinner-border web_update_spinner" style="position:absolute;right:120px;width:20px;height:20px;top:unset;left:unset;display:none;margin-top:5px;">
							<span class="sr-only">Loading...</span>
						</div>
						<button class="btn text-light user_webpdate bradius" style="background:#294a63">Update</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal updateusermodal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-body">
					<div class="row d-flex justify-content-between" style="background:#294a63;">
						<div class="nameofuser_h">
							<h6 class="text-light mt-auto mb-auto" style="text-transform:uppercase"></h6>
						</div>
						<div class="close_x_div">
							<span class="text-light close_x_icon">&times</span>
						</div>
					</div>

					<div class="tab_div mt-2">
						<a href="" class="tab_link prof_a"><i class="fas fa-user-alt mr-2"></i>Profile</a>
						<a href="" class="tab_link web_a"><i class="fas fa-tachometer-alt mr-2"></i>Websites</a>
						<a href="" class="tab_link pay_a"><i class="fas fa-wallet mr-2"></i>Quota</a>
						<a href="" class="tab_link ac_a"><i class="fas fa-user-cog mr-2"></i>Account</a>
					</div>
					<hr>

					<input type="hidden" name="user_id" class="user_id">
					<input type="hidden" name="user_form_key" class="user_form_key">

					<div class="profile_div">
						<div class="form-group">
							<label><span class="text-danger font-weight-bolder">* </span>Username</label>
							<input type="text" name="uname" class="form-control uname" placeholder="Username" readonly disabled style="cursor:not-allowed">
							<span class="unameerr text-danger" style="display:none">Username already exist</span>
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
									<input type="number" name="mobile" class="form-control mobile" placeholder="User Mobile Number" id="mobile" maxlength="10">
									<div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="d-flex" style="justify-content:space-between">
								<label>Link<i class="fas fa-copy ml-2 copy_i" style="cursor:pointer" onclick="copylink_fun('#linkshare')"></i></label>
								<div class="linkcopyalert font-weight-bolder" style="display:none;color:#294a63">Copied to your clipboard</div>
							</div>
							<input type="text" name="linkshare" class="form-control linkshare" id='linkshare' readonly disabled style="cursor:not-allowed">
						</div>
						<hr>
						<div class="updatebtngrp d-flex justify-content-between mb-2">
							<button class="btn btn-secondary closeupdatebtn bradius">Close</button>
							<div class="spinner-border prof_update_spinner" style="position:absolute;right:120px;width:20px;height:20px;top:unset;left:unset;display:none;margin-top:5px;">
								<span class="sr-only">Loading...</span>
							</div>
							<button class="btn text-light user_profileupdate bradius" type="submit" style="background:#294a63">Update</button>
						</div>
					</div>

					<div class="website_div">
						<div class="d-flex justify-content-between mb-3">
							<div class="action_div">
								<button type="button" class="action_web_btn text-light" style="background-color:#294a63;padding:6px;border:none;border-radius: 50%;">
									<i class="fas fa-ellipsis-h"></i>
								</button>
							</div>
							<div>
								<span class="web_num_total"></span> Website(s) out of <span class="webnumtotal"></span>
								<i class="fas fa-question-circle help_i" title="For more website quota, contact us at nktech.in@gmail.com"></i>
							</div>
							<div class="add_web">
								<button type="button" class="add_web_btn text-light" style="background-color:#294a63;padding:6px;border:none">
									<i class="fas fa-plus-circle"></i>
									Add Website
								</button>
							</div>
						</div>

						<div class="website_form_div">
						</div>
						<div class="updatebtngrp text-right mb-2 web_btngrp">
							<button class="btn btn-secondary closeupdatebtn bradius">Close</button>
						</div>
					</div>

					<div class="payment_div">
						<div class="form-group pt-4">
							<label><span class="text-danger font-weight-bolder">* </span>Current Website Quota<i class="fas fa-question-circle ml-2" title="To update quota, de-activate user subscription"></i></label>
							<input type="text" name="web_quota" class="form-control web_quota" placeholder="Web Quota">
							<div class="text-danger font-weight-bolder web_quota_err" style="display: none;"></div>

						</div>
						<div class="row">
							<div class="col">
								<label><span class="text-danger font-weight-bolder">* </span>Quota Bought</label>
								<input type="text" name="bought" class="form-control bought" required>
							</div>
							<div class="col">
								<label><span class="text-danger font-weight-bolder">* </span>Quota Used</label>
								<input type="text" name="used" class="form-control used" required>
							</div>
							<div class="col">
								<label><span class="text-danger font-weight-bolder">* </span>Quota Balance</label>
								<input type="text" name="bal" class="form-control bal" required>
							</div>
						</div>
						<span class="quotaerr text-danger" style="display:blbck"></span>
						<div class="form-group d-flex pt-4" style="flex-direction: column;">
							<div>
								<div class="font-weight-bolder text-danger verifysub_btn">User subscription is not active</div>
								<div class="font-weight-bolder text-success unverifysub_btn">User subscription is active</div>
							</div>
							<div>
								<button class="btn text-light verifysub_btn" type="button" style='background:#294a63'>Activate user subscription?</button>
								<button class="btn btn-danger unverifysub_btn" type="button">De-activate user subscription?</button>
							</div>
						</div>
						<hr>
						<div class="updatebtngrp d-flex justify-content-between mb-2">
							<button class="btn btn-secondary closeupdatebtn bradius">Close</button>
							<div class="spinner-border quotaupdate_spinner" style="position:absolute;right:120px;width:20px;height:20px;top:unset;left:unset;display:none;margin-top:5px;">
								<span class="sr-only">Loading...</span>
							</div>
							<button type="button" class="btn subbtn_update text-light" style='background:#294a63'>Update</button>
						</div>
					</div>

					<div class="account_div">
						<div class="form-group pwddiv">
							<label><i class="fas fa-lock mr-2"></i>New Password</label>
							<input type="text" name="u_pwd" class="form-control u_pwd new_pwd">
							<div class="text-danger font-weight-bolder pwderr">Password will be changed on this user!</div>
							<div class="text-danger font-weight-bolder new_pwderr" style="display:none">Password must be over 6 characters!</div>
						</div>
						<div class="form-group mt-2">
							<button class="btn text-light genpwdbtn" type="button" style="background:#294a63"><i class="fas fa-key mr-2"></i>Generate password</button>
						</div>
						<hr>
						<div class="act_info font-weight-bolder"></div>
						<div class="form-group mt-2">
							<button class="btn btn-danger delact_btn" type="button"><i class="fas fa-trash-alt mr-2"></i>Delete account</button>
							<button class="btn btn-danger deacti_act_btn" type="button"><i class="fas fa-user-alt-slash mr-2"></i>De-activate account</button>
							<button class="btn text-light acti_act_btn" type="button" style='background:#294a63'><i class="fas fa-user-check mr-2"></i>Activate account</button>
						</div>
						<hr>
						<div class="updatebtngrp d-flex justify-content-between mb-2">
							<button class="btn btn-secondary closeupdatebtn bradius">Close</button>
							<div class="spinner-border acct_update_spinner" style="position:absolute;right:120px;width:20px;height:20px;top:unset;left:unset;display:none;margin-top:5px;">
								<span class="sr-only">Loading...</span>
							</div>
							<button class="btn text-light user_accupdate bradius" style="background:#294a63;display:none">Update</button>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>

	<div class="d-flex pt-5 mb-3 pt-0 pb-0 pl-0 pr-0 col-md-12">
		<div class="col">
			<a href="<?php echo base_url('admin/users_export_csv'); ?>" class="btn text-light csvbtn" style="background:#294a63;">
				<i class="fas fa-file-csv mr-2"></i>CSV Download
			</a>
			<button class="btn text-light reload_btn" data-toggle="tooltip" title="Reload table" style="background:#294a63;">
				<i class="fas fa-sync-alt"></i>
			</button>
		</div>
		<div class="col">
			<div class="d-flex flex-row" style="border-bottom: 1px solid #294a63">
				<span class="" style="border-radius: 0;display:inline-flex; "><i class="fas fa-search"></i></span>
				<input type="text" name="search_user" id="search_user" class="form-control search_user" placeholder="Search by any field" style="border-radius: 0" autofocus>
				<span class="clearsearch" style="border-radius: 0;display:none;margin:auto;"><i class="fas fa-times"></i></span>
			</div>
		</div>

	</div>

	<div class="container-fluid table-responsive">
		<table class="table table-center table-hover table-md table-light table-bordered usertable">
			<tr class="font-weight-bolder text-light text-center" style="background: #294a63">
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
								<i class="fas fa-circle text-warning <?php echo $info['form_key'] ?>"></i>
							<?php elseif ($info['active'] == 1) : ?>
								<i class="fas fa-circle text-success <?php echo $info['form_key'] ?>"></i>
							<?php elseif ($info['active'] == 2) : ?>
								<i class="fas fa-circle text-danger <?php echo $info['form_key'] ?>"></i>
							<?php endif; ?>
						</td>
						<td class="text-uppercase"><?php echo $info['uname'] ?></td>
						<td class=""><?php echo ucfirst($info['fname']) . " " . ucfirst($info['lname'])  ?></td>
						<td class=""><?php echo $info['mobile'] ?></td>
						<td class=""><?php echo $info['email'] ?></td>
						<td class="">
							<?php if ($info['sub_active'] == 0) : ?>
								No
							<?php elseif ($info['sub_active'] == 1) : ?>
								Yes
							<?php endif; ?>
						</td>
						<td class="font-weight-bolder">
							<div class="d-flex" style="justify-content:space-around">
								<button class="btn text-light editbtn" id="<?php echo $info['id'] ?>" form_key="<?php echo $info['form_key'] ?>" style="background:#294a63">
									<i class="fas fa-user-alt text-light "></i>
								</button>
								<button class="btn text-light delbtn" id="<?php echo $info['id'] ?>" form_key="<?php echo $info['form_key'] ?>" style="background:#294a63">
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
					$('table.usertable').html(data);
					$(".table_pag_div").show();
					$('#search_user').val("");
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
				$(".clearsearch").show();
				load_data(search);
			} else {
				$(".table_pag_div").show();
				$(".clearsearch").hide();
				reload_table();
			}
		});

		$('.clearsearch').click(function() {
			$("#search_user").val("");

			reload_table();

			$(this).fadeOut();
		});

		$(document).on('click', 'i.fa-sort', function() {
			$('#search_user').val("");
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
					window.location.reload();
				}
			});
		});

		$(document).on('click', 'button.editbtn', function() {
			$('.website_form_div').html("");
			$(".prof_update_spinner").hide();
			$(".new_pwd").val("");
			$(".user_accupdate").hide();
			$(".weberr,.web_quota_err,.mobileerr,.new_pwderr").hide();
			$('.uname,.email,.mobile,.web_quota,u_pwd').css('border', '1px solid #ced4da');
			$("tr.tr_nopayment,tr.tr_payment").remove();

			var user_id = $(this).attr("id");
			var form_key = $(this).attr("form_key");
			var csrfName = $('.csrf-token').attr('name');
			var csrfHash = $('.csrf-token').val();

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
					var baseurl = "<?php echo base_url("wtr/"); ?>";

					$('.csrf-token').val(data.token);
					$('.user_id').val(data.infos[0].id);
					$('.user_form_key').val(data.infos[0].form_key);

					//data for profie tab
					$('.uname').val(data.infos[0].uname);
					$('.fname').val(data.infos[0].fname);
					$('.lname').val(data.infos[0].lname);
					$('.mobile').val(data.infos[0].mobile);
					$('.email').val(data.infos[0].email);
					$('.linkshare').val(baseurl + data.infos[0].form_key);

					$('.webnumtotal').html(data.infos[0].web_quota);

					$('.web_addbtn').attr("userid", data.infos[0].id);
					$('.web_addbtn').attr("userformkey", data.infos[0].form_key);
					$('.web_addbtn').attr("useractive", data.infos[0].active);

					//user name to show on top of modal
					if (data.infos[0].fname == "" || data.infos[0].lname == "") {
						$('div.nameofuser_h h6').html(data.infos[0].uname);
					} else {
						$('div.nameofuser_h h6').html(data.infos[0].fname + " " + data.infos[0].lname);
					}

					//data for website tab
					if (data.webs.length == 0) {
						$("div.website_form_div").append('<p class="text-center no_data text-dark mt-4 font-weight-bolder">USER HAS NO DATA</p>');
						$("div.action_div").hide();
						$('.web_num_total').html("0");
					} else {
						$("div.action_div").show();
						$('.web_num_total').html(data.webs.length);
						for (let index = 0; index < data.webs.length; index++) {
							// console.log(data.webs[index]);
							$("div.website_form_div").append('<div class="row ' + data.webs[index].id + '"><div class="col-md-1 action_web_div" style="display:none;margin:auto"><div class="d-flex" style="display:none"><i style="font-size:16px" class="fas fa-pencil-alt text-success edit_web_btn" web_id="' + data.webs[index].id + '" user_id="' + data.webs[index].user_id + '" form_key="' + data.webs[index].form_key + '" web_name="' + data.webs[index].web_name + '" web_link="' + data.webs[index].web_link + '"></i><i style="font-size:16px" class ="fas fa-minus-circle text-danger del_web_btn" web_id="' + data.webs[index].id + '" user_id="' + data.webs[index].user_id + '" form_key="' + data.webs[index].form_key + '" web_name="' + data.webs[index].web_name + '" web_link="' + data.webs[index].web_link + '"></i></div></div><div class="col"><div class="form-group web_form_group"><label class="web_form_label text-uppercase mb-0" web_id= "' + data.webs[index].id + '">' + data.webs[index].web_name + '</label><input readonly type="url" name="' + data.webs[index].web_name + '" class="form-control web_form_input ' + data.webs[index].web_name + '" web_id="' + data.webs[index].id + '" placeholder="https://domain-name.com" value="' + data.webs[index].web_link + '" required></div></div></div>');
						}
						$("button.user_webpdate").show();
					}

					//data for payments tab
					$('.web_quota').val(data.infos[0].web_quota);
					$('.bought').val(data.quota[0].bought);
					$('.used').val(data.quota[0].used);
					$('.bal').val(data.quota[0].bal);

					if (data.infos[0].sub_active == "0") {
						$('.bought,.bal,.used').removeAttr("readonly disabled").css('cursor', 'text');
						$('.unverifysub_btn').hide();
						$('.verifysub_btn').show();
					} else if (data.infos[0].sub_active == "1") {
						$('.bought,.bal,.used').attr({
							readonly: "true",
							disabled: "true"
						}).css('cursor', 'not-allowed');
						$('.unverifysub_btn').show();
						$('.verifysub_btn').hide();
					}

					if (data.pays.length == 0) {
						$("table.tablepayment").append('<tr class="tr_nopayment"><td colspan="10" class="font-weight-bolder text-dark text-center text-uppercase">No payment data found</td></tr>');
					} else {
						$("div.tr_nopayment").remove();
						for (let index = 0; index < data.pays.length; index++) {
							$("table.tablepayment").append('<tr class="tr_payment text-center"><td class="text-dark text-uppercase">' + data.pays[index].m_id + '</td><td class="text-dark text-lowercase">' + data.pays[index].txn_id + '</td><td class="text-dark text-lowercase">' + data.pays[index].order_id + '</td><td class="text-dark text-uppercase">' + data.pays[index].payment_mode + '</td><td class="text-dark text-uppercase">' + data.pays[index].gateway_name + '</td><td class="text-dark text-uppercase">' + data.pays[index].bank_name + '</td><td class="text-dark text-lowercase">' + data.pays[index].bank_txn_id + '</td><td class="text-dark text-lowercase">' + data.pays[index].paid_amt + '</td><td class="text-dark text-lowercase">' + data.pays[index].status + '</td><td class="text-dark text-lowercase">' + data.pays[index].paid_at + '</td></tr>');
						}
						$("button.user_webpdate").show();
					}

					//for account tab
					if (data.infos[0].active == "0") {
						$(".act_info").html("User verification not done!").show();
						$('button.deacti_act_btn').hide();
						$('button.acti_act_btn').show();
					} else if (data.infos[0].active == "1") {
						$(".act_info").html("Account is active").show();
						$('button.deacti_act_btn').show();
						$('button.acti_act_btn').hide();
					} else if (data.infos[0].active == "2") {
						$(".act_info").html("Account is not active").show();
						$('button.deacti_act_btn').hide();
						$('button.acti_act_btn').show();
					}

					$(".weberr").show()
					$('.updateusermodal').modal('show');
				},
				error: function(data) {
					window.location.reload();
				}
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
				$.ajax({
						url: "<?php echo base_url('admin/delete_user'); ?>",
						method: "post",
						data: {
							user_id: user_id,
							form_key: form_key,
							[csrfName]: csrfHash
						},
						dataType: "json",
						success: function(data) {
							if (data.res == "failed") {
								$(".prof_update_spinner").fadeOut();
								$('.ajax_res_err').html(data.res_msg);
								$('.ajax_err_div').fadeIn();
							} else if (data.res == "success") {
								$(".prof_update_spinner").fadeOut();
								$('.ajax_res_succ').html(data.res_msg);
								$('.ajax_succ_div').fadeIn();
							}
							$('.csrf-token').val(data.token);
						},
						error: function(data) {
							alert('Failed to delete. Please refresh page');
							window.location.reload();
						}
					})
					.done(function() {
						reload_table();
					});
			}
		});

		$(document).on("click", ".add_web_btn", function() {
			var webcount = $(".web_form_input").length;
			var web_quota = $(".web_quota").val();

			if (webcount < web_quota) {
				$('.web_name_add').val("");
				$('.web_link_add').val("");
				$('.updateusermodal').modal('hide');
				$(".addusermodal").modal("show");
			} else if (webcount >= web_quota) {
				var con = confirm("User current quota is " + web_quota + ". Increase user quota to add more websites.")
				if (con === false) {
					return false;
				} else if (con === true) {
					$('div.website_div,div.account_div,div.profile_div').hide();
					$('a.web_a,a.ac_a,a.prof_a').css('border-bottom', 'initial');
					$("a.pay_a").css('border-bottom', '2px solid #294a63');
					$('div.payment_div').show();
					$(".web_quota").css('border', '2px solid red')
				}
			}
		});

		$(".web_name_add").keyup(function() {
			var csrfName = $(".csrf-token").attr("name");
			var csrfHash = $(".csrf-token").val();
			var user_id = $('.web_addbtn').attr("userid");
			var form_key = $('.web_addbtn').attr("userformkey");
			var web_name_add = $('.web_name_add').val();

			$.ajax({
				url: "<?php echo base_url("user/checkduplicatewebname") ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					form_key: form_key,
					user_id: user_id,
					web_name_add: web_name_add
				},
				success: function(data) {
					$(".csrf-token").val(data.token);

					if (data.webdata > 0) {
						$('.weblinkadd_err').html("Website with this name already exist").show();
						$(".web_name_add").css('border', '1px solid red');
						$(".web_addbtn").attr({
							type: "button",
							disabled: "disabled",
							readonly: "readonly"
						}).css("cursor", "not-allowed");
					} else {
						$('.weblinkadd_err').hide();
						$(".web_name_add").css('border', '1px solid #ced4da');
						$(".web_addbtn").removeAttr("disabled readonly").attr("type", "submit").css("cursor", "pointer");
					}
				},
				error: function(data) {
					window.location.reload();
				}
			});
		});

		$(".web_link_add").keyup(function() {
			var csrfName = $(".csrf-token").attr("name");
			var csrfHash = $(".csrf-token").val();
			var user_id = $('.web_addbtn').attr("userid");
			var form_key = $('.web_addbtn').attr("userformkey");
			var web_link_add = $('.web_link_add').val();

			$.ajax({
				url: "<?php echo base_url("user/checkduplicateweblink") ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					form_key: form_key,
					user_id: user_id,
					web_link_add: web_link_add
				},
				success: function(data) {
					$(".csrf-token").val(data.token);

					if (data.webdata > 0) {
						$(".addweberr").show();
						$('.addweberr_span').html("Website with this Link already exist").show();
						$(".web_link_add").css('border', '1px solid red');
						$(".web_addbtn").attr({
							type: "button",
							disabled: "disabled",
							readonly: "readonly"
						}).css("cursor", "not-allowed");
					} else {
						$(".addweberr").show();
						$('.web_link_err').hide();
						$(".web_link_add").css('border', '1px solid #ced4da');
						$(".web_addbtn").removeAttr("disabled readonly").attr("type", "submit").css("cursor", "pointer");
					}
				},
				error: function(data) {
					window.location.reload();
				}
			});
		});

		$(document).on('click', '.web_addbtn', function(e) {
			e.preventDefault();
			var user_id = $(this).attr("userid");
			var form_key = $(this).attr("userformkey");
			var active = $(this).attr("useractive");
			var csrfHash = $('.csrf-token').val();
			var csrfName = $('.csrf-token').attr('name');
			var web_name_add = $('.web_name_add').val();
			var web_link_add = $('.web_link_add').val();
			var web_num_total = $('.web_num_total').text();


			if (web_name_add == "" || web_name_add == null) {
				$(".web_name_add").css('border', '2px solid red');
				$(".web_add_spinner").hide();
				return false;
			} else {
				$(".web_name_add").css('border', '1px solid #294a63');
			}
			if (web_link_add == "" || web_link_add == null) {
				$(".web_link_add").css('border', '2px solid red');
				return false;
			}
			var patt = new RegExp('^(https?:\\/\\/)?' + // protocol
				'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
				'((\\d{1,3}\\.){3}\\d{1,3}))' + // ip (v4) address
				'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + //port
				'(\\?[;&amp;a-z\\d%_.~+=-]*)?' + // query string
				'(\\#[-a-z\\d_]*)?$', 'i');
			var res = patt.test(web_link_add);
			if (res == true) {
				$(".addweberr").hide();
				$(".web_link_add").css('border', '1px solid #294a63');
				$(".web_add_spinner").hide();
			} else if (res == false) {
				$(".addweberr").show();
				$(".addweberr_span").html("Invalid WEB URL");
				$(".web_link_add").css('border', '2px solid red');
				return false;
			}

			$.ajax({
				url: "<?php echo base_url('admin/add_website') ?>",
				method: "POST",
				data: {
					[csrfName]: csrfHash,
					user_id: user_id,
					form_key: form_key,
					active: active,
					web_name_add: web_name_add,
					web_link_add: web_link_add
				},
				dataType: "json",
				beforeSend: function() {
					$(".web_add_spinner").fadeIn();
					$('.web_addbtn').hide();
				},
				success: function(data) {
					$('.csrf-token').val(data.token);
					$('.web_addbtn').show();

					if (data.res == "failed") {
						$(".web_add_spinner,.ajax_succ_div").fadeOut();
						$('.ajax_res_err').html(data.res_msg);
						$('.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
					} else if (data.res == "success") {
						$(".web_add_spinner,.ajax_err_div").fadeOut();
						$('.ajax_res_succ').html(data.res_msg);
						$('.ajax_succ_div').fadeIn("slow").delay("5000").fadeOut("slow");

						$("div.website_form_div").append('<div class="row ' + data.insert_id + '"><div class="col-md-1 action_web_div" style="display:none;margin:auto"><div class="d-flex" style="display:none"><i style="font-size:16px" class="fas fa-edit text-success edit_web_btn" web_id="' + data.insert_id + '" user_id="' + user_id + '" form_key="' + form_key + '" web_name="' + web_name_add + '" web_link="' + web_link_add + '"></i><i style="font-size:16px" class ="fas fa-minus-circle text-danger del_web_btn" web_id="' + data.insert_id + '" user_id="' + user_id + '" form_key="' + form_key + '" web_name="' + web_name_add + '"></i></div></div><div class="col"><div class="form-group web_form_group"><label class="web_form_label text-uppercase mb-0" web_id= "' + data.insert_id + '">' + web_name_add + '</label><input readonly type="url" name="' + web_name_add + '" class="form-control web_form_input ' + web_name_add + '" web_id="' + data.insert_id + '" placeholder="https://domain-name.com" value="' + web_link_add + '" required></div></div></div>');

						$("div.action_div").show();

						$("p.no_data").hide();

						var new_web_num_total = parseInt(web_num_total) + 1;
						$('.web_num_total').html(new_web_num_total);

						$('.updateusermodal').modal('show');
						$(".addusermodal").modal("hide");
					}

					reload_table();
				},
				error: function(data) {
					// alert("Error updating user profile!");
					window.location.reload();
				}
			})
		});

		$(document).on("click", ".close_add_web_btn", function() {
			$('.updateusermodal').modal('show');
			$(".addusermodal").modal("hide");
			$('.web_name_add').html("");
			$('.web_link_add').html("");
		});

		$(document).on("click", ".action_web_btn", function() {
			$(".action_web_div").toggle();
		});

		$(document).on("click", ".edit_web_btn", function() {
			var web_id = $(this).attr("web_id");
			var web_name = $(this).attr("web_name");
			var web_link = $(this).attr("web_link");

			$(".modal_webid").val(web_id);
			$('.web_name_edit').val(web_name);
			$('.web_link_edit').val(web_link);

			$('.updateusermodal').modal('hide');
			$(".edit_web_modal").modal("show");
		});

		$(document).on('click', '.user_webpdate', function(e) {
			e.preventDefault();
			var id = $('.modal_webid').val();
			var user_id = $('.user_id').val();
			var form_key = $('.user_form_key').val();
			var csrfHash = $('.csrf-token').val();
			var csrfName = $('.csrf-token').attr('name');
			var web_name_edit = $('.web_name_edit').val();
			var web_link_edit = $('.web_link_edit').val();


			if (web_name_edit == "" || web_name_edit == null) {
				$(".web_name_edit").css('border', '2px solid red');
				$(".web_update_spinner").hide();
				return false;
			} else {
				$(".web_name_edit").css('border', '1px solid #294a63');
			}

			if (web_link_edit == "" || web_link_edit == null) {
				$(".web_link_edit").css('border', '2px solid red');
				return false;
			}
			var patt = new RegExp('^(https?:\\/\\/)?' + // protocol
				'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
				'((\\d{1,3}\\.){3}\\d{1,3}))' + // ip (v4) address
				'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + //port
				'(\\?[;&amp;a-z\\d%_.~+=-]*)?' + // query string
				'(\\#[-a-z\\d_]*)?$', 'i');
			var res = patt.test(web_link_edit);
			if (res == true) {
				$(".weberr").hide();
				$(".web_link_edit").css('border', '1px solid #294a63');
				$(".web_update_spinner").hide();
			} else if (res == false) {
				$(".weberr").show();
				$(".weberr_span").html("Invalid WEB URL");
				$(".web_link_edit").css('border', '2px solid red');
				return false;
			}

			$.ajax({
				url: "<?php echo base_url('admin/user_webupdate') ?>",
				method: "POST",
				data: {
					[csrfName]: csrfHash,
					id: id,
					user_id: user_id,
					form_key: form_key,
					web_name_edit: web_name_edit,
					web_link_edit: web_link_edit
				},
				dataType: "json",
				beforeSend: function() {
					$(".web_update_spinner").fadeIn();
					$('.user_webpdate').html("Updating...");
					$('.user_webpdate').attr("disabled", "disabled");
					$('.user_webpdate').css("cursor", "not-allowed");
				},
				success: function(data) {
					$('.user_webpdate').html("Update");
					$('.user_webpdate').removeAttr("disabled");
					$('.user_webpdate').css("cursor", "pointer");
					$('.user_webpdate').css("background", "#294a63");
					$('.csrf-token').val(data.token);

					if (data.res == "failed") {
						$(".web_update_spinner,.ajax_succ_div").fadeOut();
						$('.ajax_res_err').html(data.res_msg);
						$('.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
					} else if (data.res == "success") {
						$(".web_update_spinner,.ajax_err_div").fadeOut();
						$('.ajax_res_succ').html(data.res_msg);
						$('.ajax_succ_div').fadeIn("slow").delay("5000").fadeOut("slow");
						$('label[web_id=' + id + ']').html(web_name_edit);
						$('input[web_id=' + id + ']').val(web_link_edit);
					}

					reload_table();
				},
				error: function(data) {
					alert("Error updating user profile!");
					window.location.reload();
				}
			})
		});

		$(document).on("click", ".close_edit_web_modal", function() {
			$(".edit_web_modal").modal("hide");
			$(".updateusermodal").modal("show");
			$(".action_web_div").hide();
		});

		$(document).on("click", ".del_web_btn", function() {
			var web_id = $(this).attr('web_id');
			var web_name = $(this).attr('web_name');
			var web_link = $(this).attr('web_link');
			var user_id = $(this).attr('user_id');
			var form_key = $(this).attr('form_key');
			var csrfHash = $('.csrf-token').val();
			var csrfName = $('.csrf-token').attr('name');
			var web_num_total = $('.web_num_total').text();

			var con = confirm("Are you sure you want to delete this user website and all of its ratings?");
			if (con == false) {
				return false;
			} else if (con == true) {
				$.ajax({
					url: "<?php echo base_url('admin/delete_user_web'); ?>",
					method: "post",
					data: {
						web_id: web_id,
						web_name: web_name,
						web_link: web_link,
						user_id: user_id,
						form_key: form_key,
						[csrfName]: csrfHash
					},
					dataType: "json",
					success: function(data) {
						if (data.res == "failed") {
							$('.ajax_res_err').html(data.res_msg);
							$('.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
						} else if (data.res == "success") {
							$("div.website_form_div div." + web_id).remove();
							$('.ajax_res_succ').html(data.res_msg);
							$('.ajax_succ_div').fadeIn("slow").delay("5000").fadeOut("slow");
						}
						$('.csrf-token').val(data.token);

						var new_web_num_total = parseInt(web_num_total) - 1;
						$('.web_num_total').html(new_web_num_total);
						if (parseInt(new_web_num_total) <= 0) {
							$("div.action_div").hide();
							$("div.website_form_div").append('<p class="text-center no_data text-dark mt-4 font-weight-bolder">USER HAS NO DATA</p>');
						}
					},
					error: function(data) {
						alert('Failed to delete. Please refresh page');
						window.location.reload();
					}
				})
			}
		});

		$(".uname").keyup(function() {
			var uname_val = $(".uname").val();
			var csrfHash = $('.csrf-token').val();
			var csrfName = $('.csrf-token').attr('name');
			$.ajax({
				url: "<?php echo base_url("user/check_duplicate_username") ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					uname_val: uname_val
				},
				success: function(data) {
					$(".csrf-token").val(data.token);
					if (data.user_data > 0) {
						$('.unameerr').show();
						$(".uname").css('border', '1px solid red');
						$(".user_profileupdate").attr("disabled", "disabled").hide();
					} else {
						$('.unameerr').hide();
						$(".uname").css('border', '1px solid #ced4da');
						$(".user_profileupdate").removeAttr("disabled").show();
					}
				},
				error: function(data) {
					alert('error filtering. Please refresh and try again');
				}
			});
		});

		$(document).on('click', '.user_profileupdate', function(e) {
			e.preventDefault();
			var user_id = $('.user_id').val();
			var form_key = $('.user_form_key').val();
			var csrfHash = $('.csrf-token').val();
			var csrfName = $('.csrf-token').attr('name');
			var uname = $('.uname').val();
			var fname = $('.fname').val();
			var lname = $('.lname').val();
			var email = $('.email').val();
			var mobile = $('.mobile').val();

			if (uname == "" || uname == null) {
				$('.uname').css('border', '2px solid red');
				$(".prof_update_spinner").hide();
				return false;
			} else {
				$('.uname').css('border', '1px solid #294a63');
			}
			if (email == "" || email == null) {
				$('.email').css('border', '2px solid red');
				$(".prof_update_spinner").hide();
				return false;
			} else {
				$('.email').css('border', '1px solid #294a63');
			}
			if (mobile == "" || mobile == null) {
				$('.mobile').css('border', '2px solid red');
				$(".prof_update_spinner").hide();
				return false;
			}
			if (mobile.length !== 10) {
				$('.mobile').css('border', '2px solid red');
				$(".mobileerr").html("Invaid mobile length").show();
				$(".prof_update_spinner").hide();
				return false;
			} else {
				$('.mobile').css('border', '1px solid #294a63');
				$(".mobileerr").hide();
			}

			$.ajax({
				url: "<?php echo base_url('admin/user_profupdate') ?>",
				method: "POST",
				data: {
					[csrfName]: csrfHash,
					user_id: user_id,
					form_key: form_key,
					uname: uname,
					fname: fname,
					lname: lname,
					email: email,
					mobile: mobile,
				},
				dataType: "json",
				beforeSend: function() {
					$(".prof_update_spinner").fadeIn();
					$('.user_profileupdate').html("Updating...");
					$('.user_profileupdate').attr("disabled", "disabled");
					$('.user_profileupdate').css("cursor", "not-allowed");
				},
				success: function(data) {
					$('.user_profileupdate').html("Update");
					$('.user_profileupdate').removeAttr("disabled");
					$('.user_profileupdate').css("cursor", "pointer");
					$('.user_profileupdate').css("background", "#294a63");
					$('.csrf-token').val(data.token);

					if (data.res == "failed") {
						$(".prof_update_spinner,.ajax_succ_div").fadeOut();
						$('.ajax_res_err').html(data.res_msg);
						$('.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
					} else if (data.res == "success") {
						$(".prof_update_spinner,.ajax_err_div").fadeOut();
						$('.ajax_res_succ').html(data.res_msg);
						$('.ajax_succ_div').fadeIn("slow").delay("5000").fadeOut("slow");
					}

					reload_table();
				},
				error: function(data) {
					alert("Error updating user profile!");
					window.location.reload();
				}
			})
		});

		$(document).on('click', 'button.deacti_act_btn', function() {
			var con = confirm("Are you sure you want to de-activate this user account?");
			if (con == false) {
				return false;
			} else if (con == true) {
				var user_id = $('.user_id').val();
				var user_form_key = $('.user_form_key').val();
				var csrfName = $('.csrf-token').attr('name');
				var csrfHash = $('.csrf-token').val();

				$.ajax({
					url: "<?php echo base_url('admin/deactivateuser'); ?>",
					method: "POST",
					data: {
						[csrfName]: csrfHash,
						user_id: user_id,
						user_form_key: user_form_key
					},
					dataType: "json",
					success: function(data) {
						// $('i.' + user_form_key).removeClass("text-success").addClass("text-danger");
						if (data.res == "failed") {
							$(".ajax_succ_div").fadeOut();
							$('.ajax_res_err').html(data.res_msg);
							$('.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
						} else if (data.res == "success") {
							$(".ajax_err_div").fadeOut();
							$('.ajax_res_succ').html(data.res_msg);
							$('.ajax_succ_div').fadeIn("slow").delay("5000").fadeOut("slow");
							$(".act_info").html("Account is not active").show();
							$('.deacti_act_btn').hide();
							$('.acti_act_btn').show();
						}

						reload_table();

						$('.csrf-token').val(data.token);
					},
					error: function(data) {
						window.location.reload();
					}
				});
			}
		});

		$(document).on('click', 'button.acti_act_btn', function() {
			var con = confirm("Are you sure you want to activate this user account?");
			if (con == false) {
				return false;
			} else if (con == true) {
				var user_id = $('.user_id').val();
				var user_form_key = $('.user_form_key').val();
				var csrfName = $('.csrf-token').attr('name');
				var csrfHash = $('.csrf-token').val();

				$.ajax({
					url: "<?php echo base_url('admin/activateuser'); ?>",
					method: "POST",
					data: {
						[csrfName]: csrfHash,
						user_id: user_id,
						user_form_key: user_form_key
					},
					dataType: "json",
					success: function(data) {
						// $('i.' + user_form_key).removeClass("text-danger").addClass("text-success");
						if (data.res == "failed") {
							$('.ajax_res_err').html(data.res_msg);
							$('.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
						} else if (data.res == "success") {
							$('.ajax_res_succ').html(data.res_msg);
							$('.ajax_succ_div').fadeIn("slow").delay("5000").fadeOut("slow");
							$(".act_info").html("Account is active").show();
							$('.deacti_act_btn').show();
							$('.acti_act_btn').hide();
						}
						reload_table();
						$('.csrf-token').val(data.token);
					},
					error: function(data) {
						window.location.reload();
					}
				});
			}
		});

		$(document).on('click', 'button.delact_btn', function() {
			var user_id = $('.user_id').val();
			var form_key = $('.user_form_key').val();
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

		$(document).on('click', 'button.verifysub_btn', function() {
			var user_id = $('.user_id').val();
			var form_key = $('.user_form_key').val();
			var csrfHash = $('.csrf-token').val();
			var csrfName = $('.csrf-token').attr('name');
			var web_quota = $('.web_quota').val();
			var webcount = $(".web_form_input").length;
			var bought = $('.bought').val();
			var balance = $('.bal').val();
			var used = $(".used").val();

			if (web_quota == "" || web_quota == null) {
				$('.web_quota').css('border', '2px solid red');
				$(".web_quota_err").html("Specify a value, the default quota is 10").show();
				$(".prof_update_spinner").hide();
				return false;
			}
			if (parseInt(web_quota) < 10) {
				$('.web_quota').css('border', '2px solid red');
				$(".web_quota_err").html("The default quota is 10").show();
				$(".prof_update_spinner").hide();
				return false;
			}
			if (parseInt(web_quota) < webcount) {
				$('.web_quota').css('border', '2px solid red');
				$(".web_quota_err").html("Number of this user websites(" + webcount + ") cannot be greater than quota(" + web_quota + "). Increase the quota").show();
				$(".prof_update_spinner").hide();
				return false;
			} else {
				$('.web_quota').css('border', '1px solid #294a63');
			}
			if (bought == "" || bought == null) {
				$('.bought').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				return false;
			} else {
				$('.bought').css('border', '1px solid #294a63');
			}
			if (used == "" || used == null) {
				$('.used').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				return false;
			} else {
				$('.used').css('border', '1px solid #294a63');
			}
			if (balance == "" || balance == null) {
				$('.bal').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				return false;
			} else {
				$('.bal').css('border', '1px solid #294a63');
			}
			if (parseInt(bought) < parseInt(balance)) {
				$('.bal').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				$(".quotaerr").html("Balnace can't be greater than Bought").show();
				return false;
			}
			if (parseInt(bought) < parseInt(used)) {
				$('.used').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				$(".quotaerr").html("Used can't be greater than Bought").show();
				return false;
			}
			if ((parseInt(used) + parseInt(balance)) !== parseInt(bought)) {
				$('.bought,.used,.bal').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				$(".quotaerr").html("Values do not match up").show();
				return false;
			}

			var con = confirm("Are you sure you want to perform this action?");
			if (con == false) {
				return false;
			} else if (con == true) {

				$.ajax({
					url: "<?php echo base_url('admin/verify_user_sub'); ?>",
					method: "post",
					data: {
						user_id: user_id,
						web_quota: web_quota,
						form_key: form_key,
						[csrfName]: csrfHash
					},
					dataType: "json",
					success: function(data) {
						$('.csrf-token').val(data.token);

						$('.unverifysub_btn').show();
						$('.verifysub_btn').hide();

						if (data.res == "failed") {
							$('.ajax_res_err').html(data.res_msg);
							$('.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
						} else if (data.res == "success") {
							$('.ajax_res_succ').html(data.res_msg);
							$('.ajax_succ_div').fadeIn("slow").delay("5000").fadeOut("slow");
							$('.bought,.bal,.used').attr({
								readonly: "true",
								disabled: "true",
							}).css('cursor', 'not-allowed');
						}

						reload_table();

					},
					error: function(data) {
						window.location.reload();
					}
				});
			}
		});

		$(document).on('click', 'button.unverifysub_btn', function() {
			var user_id = $('.user_id').val();
			var form_key = $('.user_form_key').val();
			var csrfHash = $('.csrf-token').val();
			var csrfName = $('.csrf-token').attr('name')

			var con = confirm("Are you sure you want to perform this action?");
			if (con == false) {
				return false;
			} else if (con == true) {
				$.ajax({
					url: "<?php echo base_url('admin/unverify_user_sub'); ?>",
					method: "post",
					data: {
						user_id: user_id,
						form_key: form_key,
						[csrfName]: csrfHash
					},
					dataType: "json",
					success: function(data) {
						$('.csrf-token').val(data.token);

						$('.verifysub_btn').show();
						$('.unverifysub_btn').hide();

						if (data.res == "failed") {
							$('.ajax_res_err').html(data.res_msg);
							$('.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
						} else if (data.res == "success") {
							$('.ajax_res_succ').html(data.res_msg);
							$('.ajax_succ_div').fadeIn("slow").delay("5000").fadeOut("slow");
							$('.bought,.bal,.used').removeAttr("readonly disabled").css('cursor', 'text');
						}

						reload_table();

					},
					error: function(data) {
						window.location.reload();
					}
				});
			}
		});

		$(document).on('click', 'button.subbtn_update', function() {
			var user_id = $('.user_id').val();
			var form_key = $('.user_form_key').val();
			var csrfHash = $('.csrf-token').val();
			var csrfName = $('.csrf-token').attr('name');
			var web_quota = $('.web_quota').val();
			var webcount = $(".web_form_input").length;
			var bought = $('.bought').val();
			var balance = $('.bal').val();
			var used = $(".used").val();

			if (web_quota == "" || web_quota == null) {
				$('.web_quota').css('border', '2px solid red');
				$(".web_quota_err").html("Specify a value, the default quota is 10").show();
				$(".quotaupdate_spinner").hide();
				return false;
			}
			if (parseInt(web_quota) < 10) {
				$('.web_quota').css('border', '2px solid red');
				$(".web_quota_err").html("The default quota should be 10").show();
				$(".quotaupdate_spinner").hide();
				return false;
			}
			if (parseInt(web_quota) < webcount) {
				$('.web_quota').css('border', '2px solid red');
				$(".web_quota_err").html("Number of this user websites(" + webcount + ") cannot be greater than quota(" + web_quota + "). Increase the quota").show();
				$(".quotaupdate_spinner").hide();
				return false;
			} else {
				$('.web_quota').css('border', '1px solid #294a63');
			}
			if (bought == "" || bought == null) {
				$('.bought').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				return false;
			} else {
				$('.bought').css('border', '1px solid #294a63');
			}
			if (used == "" || used == null) {
				$('.used').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				return false;
			} else {
				$('.used').css('border', '1px solid #294a63');
			}
			if (balance == "" || balance == null) {
				$('.bal').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				return false;
			} else {
				$('.bal').css('border', '1px solid #294a63');
			}
			if (parseInt(bought) < parseInt(balance)) {
				$('.bal').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				$(".quotaerr").html("Balnace can't be greater than Bought").show();
				return false;
			}
			if (parseInt(bought) < parseInt(used)) {
				$('.used').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				$(".quotaerr").html("Used can't be greater than Bought").show();
				return false;
			}
			if ((parseInt(used) + parseInt(balance)) !== parseInt(bought)) {
				$('.bought,.used,.bal').css('border', '2px solid red');
				$(".quotaupdate_spinner").hide();
				$(".quotaerr").html("Values do not match up").show();
				return false;
			} else {
				$(".quotaerr").hide();
				$('.bought,.used,.bal').css('border', '1px solid #294a63');
			}

			$.ajax({
				url: "<?php echo base_url('admin/updateuser_quota'); ?>",
				method: "post",
				data: {
					user_id: user_id,
					form_key: form_key,
					web_quota: web_quota,
					bought: bought,
					used: used,
					balance: balance,
					[csrfName]: csrfHash
				},
				dataType: "json",
				beforeSend: function() {
					$(".quotaupdate_spinner").fadeIn();
					$('.subbtn_update').html("Updating...");
					$('.subbtn_update').attr("disabled", "disabled");
					$('.subbtn_update').css("cursor", "not-allowed");
				},
				success: function(data) {
					$('.csrf-token').val(data.token);

					if (data.res == "failed") {
						$('.ajax_res_err').html(data.res_msg);
						$('.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
					} else if (data.res == "success") {
						$('.ajax_res_succ').html(data.res_msg);
						$('.ajax_succ_div').fadeIn("slow").delay("5000").fadeOut("slow");
					}

					$(".quotaupdate_spinner").fadeOut();
					$('.subbtn_update').html("Update");
					$('.subbtn_update').removeAttr("disabled");
					$('.subbtn_update').css("cursor", "pointer");
					$('.subbtn_update').css("background", "#294a63");

					reload_table();

				},
				error: function(data) {
					// window.location.reload();
				}
			});
		});

		$('.new_pwd').keyup(function() {
			var new_pwd = $(this).val();

			if (new_pwd == "" || new_pwd == null) {
				$('.new_pwd').css('border', '2px solid red');
				$(".user_accupdate").hide();
				return false;
			}
			if (new_pwd.length < 6) {
				$('.new_pwd').css('border', '2px solid red');
				$('.new_pwderr').removeClass('text-success').addClass('text-danger');
				$('.new_pwderr').show();
				$(".user_accupdate").hide();
				return false;
			} else {
				$('.new_pwd').css('border', '1px solid #294a63');
				$('.new_pwderr').removeClass('text-danger').addClass('text-success');
			}

			$(".user_accupdate").show();
		})

		$(document).on('click', '.user_accupdate', function() {
			var user_id = $('.user_id').val();
			var form_key = $('.user_form_key').val();
			var csrfHash = $('.csrf-token').val();
			var csrfName = $('.csrf-token').attr('name');
			var uname = $('.uname').val();
			var email = $('.email').val();
			var new_pwd = $('.new_pwd').val();

			if (new_pwd == "" || new_pwd == null) {
				$('.new_pwd').css('border', '2px solid red');
				$(".acct_update_spinner").hide();
				return false;
			}
			if (new_pwd.length < 6) {
				$('.new_pwd').css('border', '2px solid red');
				$('.new_pwderr').show();
				$(".acct_update_spinner").hide();
				return false;
			} else {
				$('.new_pwd').css('border', '1px solid #294a63');
				$('.new_pwderr').removeClass('text-danger').addClass('text-success');
			}

			$.ajax({
				url: "<?php echo base_url('admin/user_accupdate') ?>",
				method: "POST",
				data: {
					user_id: user_id,
					form_key: form_key,
					new_pwd: new_pwd,
					uname: uname,
					email: email,
					[csrfName]: csrfHash
				},
				dataType: "json",
				beforeSend: function() {
					$(".acct_update_spinner").fadeIn();
					$('.user_accupdate').html("Updating...");
					$('.user_accupdate').attr("disabled", "disabled");
					$('.user_accupdate').css("cursor", "not-allowed");
				},
				success: function(data) {
					$('.user_accupdate').html("Update");
					$('.user_accupdate').removeAttr("disabled");
					$('.user_accupdate').css("cursor", "pointer");
					$('.user_accupdate').css("background", "#294a63");

					$('.new_pwderr').hide();
					$('.new_pwd').val("");
					$('.new_pwd').css('border', '1px solid #294a63');

					$('.csrf-token').val(data.token);

					if (data.res == "failed") {
						$(".acct_update_spinner,.ajax_succ_div").fadeOut();
						$('.ajax_res_err').html(data.res_msg);
						$('.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
					} else if (data.res == "success") {
						$(".acct_update_spinner").fadeOut();
						$('.ajax_res_succ').html(data.res_msg);
						$('.ajax_succ_div,.ajax_err_div').fadeIn("slow").delay("5000").fadeOut("slow");
					}
				},
				error: function(data) {
					alert("Error updating user profile!. Please refresh");
					// window.location.reload();
				}
			});

		});
	});
</script>