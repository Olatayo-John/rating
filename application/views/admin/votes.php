<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/votes.css'); ?>">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_token">
<div class="mr-3 ml-3 mt-4 bg-light">
	<div class="modal updateusermodal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="mb-2 d-flex flex-row modal-header">
					<a href="" class="btn text-light indiv_votes_export_csv col-md-3" style="background: linear-gradient(to right, #243B55, #141E30)">
						<i class="fas fa-file-csv mr-2"></i>Export as CSV
					</a>
					<input type="hidden" name="input_form_key" class="input_form_key">
					<input type="text" name="search_ind_votes" id="search_ind_votes" class="form-control ml-5 search_ind_votes" placeholder="Search by Name" style="border-radius: 0;border-bottom: 1px solid #141E30" autofocus>
				</div>
				<div class="modal-body" style="height:400px;overflow:scroll;">
					<table class="table table-bordered table-center table-hover tableuserreview" id="tableuserreview">
						<tr class="font-weight-bolder text-light" style="background: linear-gradient(to right, #243B55, #141E30);">
							<th><span class="icon">
									Name
								</span></th>
							<th><span>
									Message
								</span class="icon"></th>
							<th><span>
									Star
								</span></th>
							<th><span>
									Mobile
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
		<div class="col-md-2 rt_col text-secondary" style="border-left: none;">
			<div class="value tl text-secondary"></div>
			<h4 class="text-center stared">Reviews</h4>
		</div>
		<div class="col-md-2 rt_col">
			<div class="value tl5"></div>
			<h4 class="text-center stared">Official</h4>
		</div>
		<div class="col-md-2 rt_col">
			<div class="value tl4"></div>
			<h4 class="text-center stared">Google</h4>
		</div>
		<div class="col-md-2 rt_col">
			<div class="value tl3"></div>
			<h4 class="text-center stared">Facebook</h4>
		</div>
		<div class="col-md-2 rt_col">
			<div class="value tl2"></div>
			<h4 class="text-center stared">Glassdoor</h4>
		</div>
		<div class="col-md-2 rt_col" style="border-bottom: none;">
			<div class="value tl1"></div>
			<h4 class="text-center stared">Trust Pilot</h4>
		</div>
	</div>

	<div class="mb-3 mr-3 ml-3 pt-3 col-md-6 ml-auto">
		<div class="d-flex flex-row" style="border-bottom: 1px solid #141E30">
			<span class="" style="border-radius: 0;display:inline-flex; "><i class="fas fa-search"></i></span>
			<input type="text" name="search_user" id="search_user" class="form-control search_user" placeholder="Search by Name" style="border-radius: 0" autofocus>
		</div>
	</div>

	<div class="mt-3 mr-3 ml-3 mb-3">
		<a href="<?php echo base_url('admin/votes_export_csv'); ?>" class="btn text-light csvbtn" style="background: linear-gradient(to right, #243B55, #141E30);">
			<i class="fas fa-file-csv mr-2"></i>CSV Download
		</a>
		<button class="btn text-light reload_btn" data-toggle="tooltip" title="Reload table" style="background: linear-gradient(to right, #243B55, #141E30);">
			<i class="fas fa-sync-alt"></i>
		</button>
	</div>

	<div class="container-fluid table-responsive mb-4">
		<table class="table table-center table-hover table-md table-light" id="result">
			<tr class="font-weight-bolder text-light" style="background: linear-gradient(to right, #243B55, #141E30);">
				<th>
					<div class="inh">
						<i class="fas fa-sort" name="name" type="desc"></i>
						<span>User</span>
					</div>
				</th>
				<th>
					<div class="tr">
						<i class="fas fa-sort" name="total_links" type="desc"></i>
						<span>Reviews</span>
					</div class="icon">
				</th>
				<th>
					<div class="inh">
						<i class="fas fa-sort" name="sms" type="desc"></i>
						<span>SMS</span>
					</div class="icon">
				</th>
				<th>
					<div class="inh">
						<i class="fas fa-sort" name="email" type="desc"></i>
						<span>Email</span>
					</div class="icon">
				</th>
				<th>
					<div class="tr">
						<i class="fas fa-sort" name="ow_r" type="desc"></i>
						<span>Official</span>
					</div>
				</th>
				<th>
					<div class="tr">
						<i class="fas fa-sort" name="fb_r" type="desc"></i>
						<span>Facebook</span>
					</div>
				</th>
				<th>
					<div class="tr">
						<i class="fas fa-sort" name="g_r" type="desc"></i>
						<span>Google</span>
					</div>
				</th>
				<th>
					<div class="tr">
						<i class="fas fa-sort" name="gb_r" type="desc"></i>
						<span>Glassdoor</span>
					</div>
				</th>
				<th>
					<div class="tr">
						<i class="fas fa-sort" name="tp_r" type="desc"></i>
						<span>Trust Pilot</span>
					</div>
				</th>
				<th class="text-danger text-center font-weight-bolder">
					View Feedbacks
				</th>
			</tr>

			<?php if ($details->num_rows() == '0') : ?>
				<tr class="text-dark">
					<td colspan='8' class='font-weight-bolder text-dark text-center'>No data found</td>
				</tr>
			<?php endif; ?>
			<?php if ($details->num_rows() > '0') : ?>
				<?php foreach ($details->result_array() as $info) : ?>
					<tr class="text-dark text-center">
						<td class=""><?php echo $info['uname'] ?></td>
						<td class="tv"><?php echo $info['total_ratings'] ?></td>
						<td class="tv"><?php echo $info['total_sms'] ?></td>
						<td class="tv"><?php echo $info['total_email'] ?></td>
						<td class="tv"><?php echo $info['total_one'] ?></td>
						<td class="tv"><?php echo $info['total_two'] ?></td>
						<td class="tv"><?php echo $info['total_three'] ?></td>
						<td class="tv"><?php echo $info['total_four'] ?></td>
						<td class="tv"><?php echo $info['total_five'] ?></td>
						<td class="font-weight-bolder">
							<button class="btn text-light vv_btn" form_key="<?php echo $info['form_key'] ?>" style="width: 100px;background: linear-gradient(to right, #243B55, #141E30);"><i class="fas fa-poll text-light mr-2"></i>Votes</button>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table><?php echo $links; ?>
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
				load_data(search);
			} else {
				reload_table();
			}
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

		var csrfName = $('.csrf_token').attr('name');
		var csrfHash = $('.csrf_token').val();
		// $.ajax({
		// 	url: "<?php echo base_url('user/total_bar_data'); ?>",
		// 	method: "post",
		// 	dataType: "json",
		// 	data: {
		// 		[csrfName]: csrfHash,
		// 	},
		// 	success: function(data) {
		// 		$('.tl').html(data.atr);
		// 		$('.tl5').html(data.tr5);
		// 		$('.tl4').html(data.tr4);
		// 		$('.tl3').html(data.tr3);
		// 		$('.tl2').html(data.tr2);
		// 		$('.tl1').html(data.tr1);
		// 		$('.csrf_token').val(data.token);
		// 	},
		// 	error: function(data) {
		// 		alert('Error showing');
		// 	}
		// });

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
			var key = $(this).attr("form_key");
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
					$('.csrf_token').val(data.token);
					$('.input_form_key').val(key);
					$(".indiv_votes_export_csv").attr("href", "indiv_votes_export_csv/" + key);
					if (data['users'].length == 0) {
						var table = $('table.tableuserreview');
						var tr = $('<tr class="truserreview"></tr>');
						tr.append('<td colspan="6" class="font-weight-bolder text-dark text-center">User has no data</td>');
						table.append(tr);
						$('.updateusermodal').modal('show');
					}
					var table = $('table.tableuserreview');
					for (var i = 0; i < data['users'].length; i++) {
						var tr = $('<tr class="truserreview"></tr>');
						tr.append('<td class="font-weight-bolder text-dark text-lowercase">' + data['users'][i].name + '</td>');
						tr.append('<td class="font-weight-bolder text-lowercase">' + data['users'][i].review_msg + '</td>');
						tr.append('<td class="font-weight-bolder">' + data['users'][i].star + '</td>');
						tr.append('<td class="font-weight-bolder">' + data['users'][i].mobile + '</td>');
						tr.append('<td class="font-weight-bolder">' + data['users'][i].user_ip + '</td>');
						tr.append('<td class="text-danger font-weight-bolder">' + data['users'][i].rated_at + '</td>');
						table.append(tr);
						$('.updateusermodal').modal('show');
					}
				}
			});
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