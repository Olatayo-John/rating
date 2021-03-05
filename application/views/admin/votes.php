<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/votes.css'); ?>">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_token">
<div class="mr-3 ml-3 mt-4 mb-5 bg-light">
	<div class="modal updateusermodal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header d-flex flex-column pt-0 pb-0 pl-0 pr-0" style="overflow-x:scroll">
					<div class="" style="background:#294a63;display: flex;width: 100%;justify-content: space-between;">
						<div class="username_div ml-3" style="background:#294a63">
							<h6 class="text-light text-uppercase" style="margin: auto;padding: 7px 0;"></h6>
						</div>
						<div class="close_x_div">
							<span class="text-light close_x_icon closeupdatebtn">&times</span>
						</div>
					</div>

					<div class="userweb_div_cal mb-4 mt-3 row col-md-12" style="margin: auto;padding:0;">

					</div>
					<div class="mb-2 d-flex flex-row col-md-12">
						<a href="" class="btn text-light indiv_votes_export_csv col-md-3" style="background:#294a63">
							<i class="fas fa-file-csv mr-2"></i>CSV Export
						</a>
						<input type="hidden" name="input_form_key" class="input_form_key">
						<input type="text" name="search_ind_votes" id="search_ind_votes" class="form-control ml-5 search_ind_votes" placeholder="Search by Name" style="border-radius: 0;border-bottom: 1px solid #294a63;display:none" autofocus>
					</div>

				</div>
				<div class="modal-body pt-2" style="overflow-x:scroll;overflow-y: hidden;">
					<table class="table table-bordered table-center table-hover tableuserreview" id="tableuserreview">
						<tr class="font-weight-bolder text-light text-center" style="background:#294a63;white-space: nowrap;">
							<th><span class="icon">
									Name
								</span></th>
							<th><span>
									Mobile
								</span class="icon"></th>
							<th><span>
									Star
								</span></th>
							<th><span>
									Website
								</span class="icon"></th>
							<th><span>
									IP
								</span></th>
							<th class="text-danger"><span>
									Date
								</span></th>
						</tr>
					</table>
				</div>
				<div class="updatebtngrp text-right mb-2">
					<button class="btn btn-dark closeupdatebtn bradius mr-3">Close</button>
					<input type="hidden" name="ser_id" class="form-control user_id">
				</div>
			</div>
		</div>
	</div>

	<div class="rt_div row mb-5 pt-3" style="margin: 0">
		<div class="rt_col col text-secondary" style="border-left: none;padding:0 15px">
			<div class="value tv text-secondary"><?php echo $get_total_ratings->num_rows() ?></div>
			<h4 class="text-center stared">Reviews</h4>
		</div>
		<div class="col rt_col">
			<div class="value tv"><?php echo $get_total_official->num_rows() ?></div>
			<h4 class="text-center stared">Official</h4>
		</div>
		<div class="col rt_col">
			<div class="value tv"><?php echo $get_total_google->num_rows() ?></div>
			<h4 class="text-center stared">Google</h4>
		</div>
		<div class="col rt_col">
			<div class="value tv"><?php echo $get_total_facebook->num_rows() ?></div>
			<h4 class="text-center stared">Facebook</h4>
		</div>
		<div class="col rt_col">
			<div class="value tv"><?php echo $get_total_gd->num_rows() ?></div>
			<h4 class="text-center stared">Glassdoor</h4>
		</div>
		<div class="col rt_col" style="border-bottom: none;">
			<div class="value tv"><?php echo $get_total_tp->num_rows() ?></div>
			<h4 class="text-center stared">Trust Pilot</h4>
		</div>
		<div class="col rt_col" style="border-bottom: none;">
			<div class="value tv"><?php echo $get_total_other->num_rows() ?></div>
			<h4 class="text-center stared">Others</h4>
		</div>
	</div>

	<div class="d-flex justify-content-column mb-3 pt-3">
		<div class="col">
			<a href="<?php echo base_url('admin/votes_export_csv'); ?>" class="btn text-light csvbtn" style="background:#294a63;">
				<i class="fas fa-file-csv mr-2"></i>CSV Export
			</a>
			<button class="btn text-light reload_btn" data-toggle="tooltip" title="Reload table" style="background:#294a63;">
				<i class="fas fa-sync-alt"></i>
			</button>
		</div>
		<div class="col ml-auto">
			<div class="d-flex flex-row search_user_div" style="border-bottom: 1px solid #294a63">
				<span class="" style="border-radius: 0;display:inline-flex; "><i class="fas fa-search"></i></span>
				<input type="text" name="search_user" id="search_user" class="form-control search_user" placeholder="Search by User" style="border-radius: 0" autofocus>
				<span class="clearsearch" style="border-radius: 0;display:none;margin:auto;"><i class="fas fa-times"></i></span>
			</div>
		</div>
	</div>

	<div class="container-fluid table-responsive mb-4">
		<table class="table table-center table-hover table-md table-light table-bordered" id="result">
			<tr class="font-weight-bolder text-light text-center" style="background:#294a63;white-space:nowrap">
				<th>
					<div class="inh">
						<i class="fas fa-sort" name="uname" type="desc"></i>
						<span>User</span>
					</div>
				</th>
				<th>
					<div class="tr">
						<i class="fas fa-sort" name="total_ratings" type="desc"></i>
						<span>Reviews</span>
					</div class="icon">
				</th>
				<th>
					<div class="inh">
						<i class="fas fa-sort" name="total_sms" type="desc"></i>
						<span>SMS</span>
					</div class="icon">
				</th>
				<th>
					<div class="inh">
						<i class="fas fa-sort" name="total_email" type="desc"></i>
						<span>Email</span>
					</div class="icon">
				</th>
				<th>
					<div class="tr">
						<i class="fas fa-sort" name="form_key" type="desc"></i>
						<span>User Link</span>
					</div>
				</th>
				<th class="text-danger text-center font-weight-bolder">
					Reviews
				</th>
			</tr>

			<?php if ($details->num_rows() == '0') : ?>
				<tr class="text-dark">
					<td colspan='6' class='font-weight-bolder text-dark text-center'>No data found</td>
				</tr>
			<?php endif; ?>
			<?php if ($details->num_rows() > '0') : ?>
				<?php foreach ($details->result_array() as $info) : ?>
					<tr class="text-dark text-center">
						<td class=""><?php echo $info['uname'] ?></td>
						<td class="tv"><?php echo $info['total_ratings'] ?></td>
						<td class="tv"><?php echo $info['total_sms'] ?></td>
						<td class="tv"><?php echo $info['total_email'] ?></td>
						<td class="text-lowercase"><?php echo base_url() . 'user/wtr/' . $info['form_key'] ?></td>
						<td class="font-weight-bolder">
							<button class="btn text-light vv_btn" uname="<?php echo $info['uname'] ?>" form_key="<?php echo $info['form_key'] ?>" style="background:#294a63">
								<i class="fas fa-poll text-light"></i>
							</button>
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

<script type="text/javascript" src="<?php echo base_url('assets/js/votes.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click', 'button.reload_btn', function() {
			reload_table();
		});

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

		function reload_table() {
			var csrfName = $('.csrf-token').attr('name');
			var csrfHash = $('.csrf-token').val();
			$.ajax({
				method: "POST",
				url: "<?php echo base_url('admin/votes_reload_table') ?>",
				data: {
					[csrfName]: csrfHash
				},
				success: function(data) {
					$('table#result').html(data);
					$(".table_pag_div").show();
				}
			})
		}

		function load_data(query) {
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			$.ajax({
				method: "POST",
				url: "<?php echo base_url('admin/votes_search_user') ?>",
				data: {
					query: query,
					[csrfName]: csrfHash
				},
				success: function(data) {
					$('table#result').html(data);
				}
			})
		}

		$(document).on('click', 'i.fa-sort', function() {
			var param = $(this).attr('name');
			var type = $(this).attr('type');
			var csrfName = $('.csrf-token').attr('name');
			var csrfHash = $('.csrf-token').val();
			$.ajax({
				url: "<?php echo base_url('admin/votes_filter_param') ?>",
				method: "post",
				data: {
					param: param,
					type: type,
					[csrfName]: csrfHash,
				},
				success: function(data) {
					$('table#result').html(data);
					if (type == 'desc') {
						$('.fas').attr('type', 'asc');
					} else {
						$('.fas').attr('type', 'desc');
					}
				},
				error: function(data) {
					alert('Refresh the page');
				}
			});
		});

		$(document).on('click', 'button.vv_btn', function() {
			$("tr.truserreview").remove();
			$("div.userweb_div_cal").html("");
			$("#search_ind_votes").val("");

			var key = $(this).attr("form_key");
			var btn_uname = $(this).attr("uname");
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();

			$.ajax({
				url: "<?php echo base_url('admin/votes_get_user') ?>",
				method: "POST",
				data: {
					key: key,
					[csrfName]: csrfHash
				},
				dataType: "json",
				success: function(data) {
					console.log(data['users']);
					console.log(data['user_webs']);

					$('.csrf_token').val(data.token);
					$('.input_form_key').val(key);
					$(".indiv_votes_export_csv").attr("href", "indiv_votes_export_csv/" + key);
					if (data['users'].length == 0) {
						var table = $('table.tableuserreview');
						var tr = $('<tr class="truserreview"></tr>');
						tr.append('<td colspan="6" class="font-weight-bolder text-dark text-center">User has no data</td>');
						table.append(tr);

					} else {
						var table = $('table.tableuserreview');
						for (var i = 0; i < data['users'].length; i++) {
							var tr = $('<tr class="truserreview text-center"></tr>');
							tr.append('<td class="text-dark text-lowercase">' + data['users'][i].name + '</td>');
							tr.append('<td class="text-lowercase">' + data['users'][i].mobile + '</td>');
							tr.append('<td class="">' + data['users'][i].star + '</td>');
							tr.append('<td class="">' + data['users'][i].web_name + '</td>');
							tr.append('<td class="">' + data['users'][i].user_ip + '</td>');
							tr.append('<td class="text-danger">' + data['users'][i].rated_at + '</td>');
							table.append(tr);
						}
					}

					if (data['user_webs'].length > 0) {
						$('div.userweb_div_cal').append('<div class="text-secondary col user_web_div" style="border-left: none;"><div class="value">' + data['user_web_total'][0].total_ratings + '</div><h6 class="text-center font-weight-bolder text-uppercase stared user_web mb-4">Total</h6></div>');
						for (var i = 0; i < data['user_webs'].length; i++) {
							$('div.userweb_div_cal').append('<div class="text-secondary col user_web_div" style="border-left: none;"><div class="value">' + data['user_webs'][i].total_ratings + '</div><h6 class="text-center font-weight-bolder text-uppercase stared user_web mb-4" style="word-break: break-word;">' + data['user_webs'][i].web_name + '</h6></div>');
						}
					}

					$('div.username_div h6').html(btn_uname);
					$('.updateusermodal').modal('show');

				},
				error: function(data) {
					window.location.reload();
				}
			});
		});

		function search_ind_votes_load_data(query) {
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			var key = $('.input_form_key').val();
			$.ajax({
				method: "POST",
				url: "<?php echo base_url('admin/search_ind_votes') ?>",
				data: {
					query: query,
					key: key,
					[csrfName]: csrfHash
				},
				// dataType: "json",
				success: function(data) {
					$('table#tableuserreview').html(data);
				}
			})
		}

		$('#search_ind_votes').keyup(function() {
			var indvotes_search = $(this).val();
			if (indvotes_search != '') {
				search_ind_votes_load_data(indvotes_search);
			} else {
				search_ind_votes_load_data();
			}
		});

		$('.tv').each(function() {
			$(this).prop('Counter', 0).animate({
				Counter: $(this).text()
			}, {
				duration: 1000,
				easing: 'swing',
				step: function(now) {
					$(this).text(Math.ceil(now));
				}
			});
		});
	});
</script>