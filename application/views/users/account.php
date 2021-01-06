<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/quota.css'); ?>">
<div class="modal emailsmsusermodal">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="mb-2 modal-header">
				<a href="<?php echo base_url('admin/emailsms_export_csv'); ?>" class="btn emailsms_export_csv col-md-3" style="background: #023E8A;color: #ffff">
					<i class="fas fa-file-csv mr-2"></i>Export as CSV
				</a>
			</div>
			<div class="modal-body" style="height:400px;overflow:scroll;">
				<table class="table table-bordered table-center table-hover tableuserreview" id="tableuserreview">
					<tr class="font-weight-bolder" style="background-color: #1B5E20">
						<th class="text-light"><span class="icon">							
							Sent To
						</span></th>
						<th class="text-light"><span>
							Body
						</span class="icon"></th>
						<th class="text-light"><span>					
							Date
						</span></th>
					</tr>
					<?php foreach($sent_links as $row): ?>
						<tr>
							<?php if(!$row->mobile ): ?>
								<td><?php echo $row->email ?></td>
							<?php endif; ?>
							<?php if(!$row->email ): ?>
								<td><?php echo $row->mobile ?></td>
							<?php endif; ?>
							<td><?php echo $row->body ?></td>
							<td class="text-danger font-weight-bolder"><?php echo $row->sent_at ?></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div class="updatebtngrp text-right mb-2">
				<button class="btn btn-dark closeemailsmsbtn bradius mr-3">Close</button>
			</div>
		</div>
	</div>
</div>

<h4 class="text-center font-weight-bolder mt-4 mr-3 ml-3 mb-0 pb-3 pt-3">QUOTA</h4>
<div class="quota_div row mb-3 mr-3 ml-3">
	<div class="col-md-3 quota_col" style="border-left: none;">
		<div class="value"><?php echo $balance->bought ?></div><hr>
		<h4 class="text-center stared mb-4">BOUGHT</h4>
	</div>
	<div class="col-md-3 quota_col mid">
		<div class="value"><?php echo $balance->used ?></div><hr>
		<h4 class="text-center stared mb-4">USED</h4>
	</div>
	<div class="col-md-3 quota_col" style="border-bottom: none;">
		<div class="value"><?php echo $balance->bal ?></div><hr>
		<h4 class="text-center stared mb-4 text-danger">BALANCE</h4>
	</div>
</div>

<h4 class="text-center font-weight-bolder mt-4 mr-3 ml-3 mb-0 pb-3 pt-3">LINKS AND RATINGS</h4>
<div class="ls_div row mb-3 mr-3 ml-3">
	<div class="col-md-3 tl_col" style="border-left: none;">
		<div class="value temail"><?php echo $user[0]['total_links'] ?></div><hr>
		<h4 class="text-center stared mb-4">Total Ratings</h4>
	</div>
	<div class="col-md-3 tl_col text-dark">
		<div class="value tsms"><?php echo $user[0]['sms'] ?></div><hr>
		<h4 class="text-center stared mb-4">SMS sent</h4>
	</div>
	<div class="col-md-3 tl_col" style="border-bottom: none;">
		<div class="value temail"><?php echo $user[0]['email'] ?></div><hr>
		<h4 class="text-center stared mb-4">Emails sent</h4>
	</div>
</div>

<h4 class="text-center font-weight-bolder mt-4 mr-3 ml-3 mb-0 pb-5 pt-3">OVERRALL RATINGS</h4>
<div class="tr_div row pb-5 mb-5 mr-3 ml-3">
	<div class="col-md-2 tr_col text-secondary" style="border-left: none;">
		<h4 class="text-center text-dark">Total Ratings</h4>
		<div class="value"><?php echo $user[0]['total_links'] ?></div>
	</div>
	<div class="col-md-2 tr_col">
		<h4 class="text-center stared">5 stared</h4>
		<div class="value"><?php echo $user[0]['5_star'] ?></div>
	</div>
	<div class="col-md-2 tr_col">
		<h4 class="text-center stared">4 stared</h4>
		<div class="value"><?php echo $user[0]['4_star'] ?></div>
	</div>
	<div class="col-md-2 tr_col">
		<h4 class="text-center stared">3 stared</h4>
		<div class="value"><?php echo $user[0]['3_star'] ?></div>
	</div>
	<div class="col-md-2 tr_col">
		<h4 class="text-center stared">2 stared</h4>
		<div class="value"><?php echo $user[0]['2_star'] ?></div>
	</div>
	<div class="col-md-2 tr_col" style="border-right: none;border-bottom: none;">
		<h4 class="text-center stared text-danger">1 stared</h4>
		<div class="value"><?php echo $user[0]['1_star'] ?></div>
	</div>
</div>

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">

<script type="text/javascript" src="<?php echo base_url('assets/js/quota.js'); ?>"></script>
<script type="text/javascript">
	// function copyfunc(element) {
	//  var link = $("<input>");
	//  $("body").append(link);
	//  link.val($(element).val()).select();
	//  document.execCommand("copy");
	//  link.remove();
	//  $('.linkcopyalert').show();
	// }

	$(document).ready(function() {
		var csrfName= $('.csrf_token').attr('name');
		var csrfHash= $('.csrf_token').val();
		$.ajax({
			url: "<?php echo base_url('user/bar_data'); ?>",
			method: "post",
			dataType: "json",
			data: {
				[csrfName]:csrfHash,
			},
			success: function(data){
				$('.tr').html(data.tl);
				$('.atl5').html(data.tl5);
				$('.atl4').html(data.tl4);
				$('.atl3').html(data.tl3);
				$('.atl2').html(data.tl2);
				$('.atl1').html(data.tl1);
				$('.csrf_token').val(data.token);
			},
			error: function(data){
				alert('Error showing');
			}
		});

		$('.value').each(function () {
			$(this).prop('Counter',0).animate({
				Counter: $(this).text()
			}, {
				duration: 1000,
				easing: 'swing',
				step: function (now) {
					$(this).text(Math.ceil(now));
				}
			});
		});

	});
</script>