<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/feedbacks.css'); ?>">
<div class="pt-3 pb-3 pl-3 mt-3 mr-3 ml-3 bg-light">
	<a href="<?php echo base_url("user/export_feedbacks") ?>" class="btn text-light" style="background: #294a63;border-radius: 0">
		<i class="fas fa-file-csv mr-2"></i>CSV Download
	</a>
</div>

<div class="mr-3 ml-3 mt-3 mb-5 bg-light" style="overflow-x:scroll;overflow-y:hidden;">
	<table class="table table-bordered table-center table-hover">
		<tr class="font-weight-bolder text-light text-center" style="background:#294a63;white-space: nowrap;">
			<th>ID</th>
			<th>Name</th>
			<th>E-mail</th>
			<th>Message</th>
		</tr>
		<?php if ($feedbacks->num_rows() <= 0) : ?>
			<tr>
				<td colspan="4" class="text-dark text-center text-uppercase font-weight-bolder">No data</td>
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