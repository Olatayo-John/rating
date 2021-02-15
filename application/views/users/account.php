<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/quota.css'); ?>">
<!-- <div class="modal emailsmsusermodal">
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
					<?php foreach ($sent_links as $row) : ?>
						<tr>
							<?php if (!$row->mobile) : ?>
								<td><?php echo $row->email ?></td>
							<?php endif; ?>
							<?php if (!$row->email) : ?>
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
</div> -->

<h4 class="text-center font-weight-bolder mt-4 mr-3 ml-3 mb-0 pb-3 pt-3">QUOTA</h4>
<div class="ls_div mr-3 ml-3">
	<a class="btn text-light" style="outline: none;"><i class="fas fa-user mr-2"></i>YOU</a>
</div>
<div class="quota_div row mb-3 mr-3 ml-3 pb-4">
	<div class="col-md-3 quota_col" style="border-left: none;">
		<div class="value"><?php echo $balance->bought ?></div>
		<hr>
		<h4 class="text-center stared mb-4">BOUGHT</h4>
	</div>
	<div class="col-md-3 quota_col mid">
		<div class="value"><?php echo $balance->used ?></div>
		<hr>
		<h4 class="text-center stared mb-4">USED</h4>
	</div>
	<div class="col-md-3 quota_col" style="border-bottom: none;">
		<div class="value"><?php echo $balance->bal ?></div>
		<hr>
		<h4 class="text-center stared mb-4 text-danger">BALANCE</h4>
	</div>
</div>

<h4 class="text-center font-weight-bolder mt-4 mr-3 ml-3 mb-0 pb-3 pt-3">LINKS</h4>
<?php if ($this->session->userdata("mr_admin") === '1') : ?>
	<div class="ls_div mr-3 ml-3">
		<a href="#" class="btn text-light you_sentlinks_btn" style="outline: none;"><i class="fas fa-user mr-2"></i>YOU</a>
		<a href="#" class="btn text-light total_sentlinks_btn" style="outline: none;opacity: 0.9"><i class="fas fa-users mr-2"></i>ALL USERS</a>
	</div>
<?php endif; ?>
<div class="mr-3 ml-3 pb-4" style="background:white">
	<div class="ls_div you_sentlinks_div row mb-3 mr-3 ml-3">
		<div class="col-md-3 tl_col" style="border-left: none;">
			<div class="value temail"><?php echo $user->total_sms + $user->total_email ?></div>
			<hr>
			<h4 class="text-center stared mb-4">Total Sent</h4>
		</div>
		<div class="col-md-3 tl_col text-dark">
			<div class="value tsms"><?php echo $user->total_sms ?></div>
			<hr>
			<h4 class="text-center stared mb-4">SMS Sent</h4>
		</div>
		<div class="col-md-3 tl_col" style="border-bottom: none;">
			<div class="value temail"><?php echo $user->total_email ?></div>
			<hr>
			<h4 class="text-center stared mb-4">Emails Sent</h4>
		</div>
	</div>
	<?php if ($this->session->userdata("mr_admin") === '1') : ?>
		<div class="ls_div total_sentlinks_div row mb-3 mr-3 ml-3" style="display: none">
			<div class="col-md-3 tl_col" style="border-left: none;">
				<div class="value temail"><?php echo $sent_links->num_rows() ?></div>
				<hr>
				<h4 class="text-center stared mb-4">Total Sent</h4>
			</div>
			<div class="col-md-3 tl_col text-dark">
				<div class="value tsms"><?php echo $sent_links_sms->num_rows() ?></div>
				<hr>
				<h4 class="text-center stared mb-4">SMS Sent</h4>
			</div>
			<div class="col-md-3 tl_col" style="border-bottom: none;">
				<div class="value temail"><?php echo $sent_links_email->num_rows() ?></div>
				<hr>
				<h4 class="text-center stared mb-4">Emails Sent</h4>
			</div>
		</div>
	<?php endif; ?>
</div>

<h4 class="text-center font-weight-bolder mt-4 mr-3 ml-3 mb-0 pb-3 pt-3">WEB RATINGS</h4>
<div style="color:#141E30;font-weight:600;background:white" class="ml-3 mr-3 pl-3 pb-4">
	<span class="web_num_total"><?php echo $user_web->num_rows(); ?></span> Website(s) out of <?php echo $this->session->userdata("mr_web_quota") ?> <i class="fas fa-question-circle help_i" title="For more website quota, contact us at nktech.in@gmail.com"></i>
</div>
<div class="tr_div row pb-5 mb-5 mr-3 ml-3">
	<div class="col-md-2 tr_col text-secondary">
		<div class="value"><?php echo $user->total_ratings ?></div>
		<hr>
		<h4 class="text-center stared mb-4">Total Ratings</h4>
	</div>
	<?php if ($user_web->num_rows() <= 10) : ?>
		<?php foreach ($user_web->result_array() as $info) : ?>
			<div class="col-md-2 tr_col text-secondary user_web_div">
				<div class="value"><?php echo $info['total_ratings'] ?></div>
				<hr>
				<h4 class="text-center stared user_web mb-4"><?php echo ucfirst($info['web_name']) ?></h4>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">

<script type="text/javascript" src="<?php echo base_url('assets/js/quota.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var csrfName = $('.csrf_token').attr('name');
		var csrfHash = $('.csrf_token').val();

		$('.value').each(function() {
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