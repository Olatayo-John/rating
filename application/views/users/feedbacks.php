<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/feedbacks.css'); ?>">
<div class="mt-3 mr-3 ml-3">
	<div class="bg-light table-responsive">
		<div class="pt-3 pb-3 pl-3">
			<a href="<?php echo base_url("user/export_feedbacks") ?>" class="btn text-light" style="background: #294a63;border-radius: 0">
				<i class="fas fa-file-csv mr-2"></i>CSV Download
			</a>
		</div>
		<table class="table">
			<tr class="text-center text-light" style="background: #294a63">
				<th>ID</th>
				<th>Name</th>
				<th>E-mail</th>
				<th>Message</th>
			</tr>
			<?php if ($feedbacks->num_rows() <= 0) : ?>
				<tr>
					<td colspan="4" class="text-dark text-center font-weight-bolder">No data</td>
				</tr>
			<?php endif; ?>
			<?php if ($feedbacks->num_rows() > 0) : ?>
				<?php foreach ($feedbacks->result_array() as $msg) : ?>
					<tr class="text-center">
						<td><?php echo $msg['id'] ?></td>
						<td><?php echo $msg['name'] ?></td>
						<td><?php echo $msg['user_mail'] ?></td>
						<td><?php echo $msg['bdy'] ?></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</div>