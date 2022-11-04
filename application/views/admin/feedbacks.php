<div style="margin-top: 74px;">
	<?php if ($feedbacks->num_rows() > 0) : ?>
		<div class="bg-light-custom p-2 text-right">
			<a href="<?php echo base_url('clearfeedbacks'); ?>" class="btn btn-danger clear_feedbacks">
				<i class="fas fa-trash-alt mr-2"></i>Clear all Contacts
			</a>
		</div>
	<?php endif; ?>
</div>

<div class="bg-light-custom p-3 mt-3">
	<table id="feedbackstable" data-toggle="table" data-search="true" data-show-export="true" data-show-columns="true" data-buttons-prefix="btn-md btn" data-buttons-align="left" data-pagination="true">
		<thead class="text-light" style="background:#294a63">
			<tr>
				<th data-field="name" data-sortable="true">Name</th>
				<th data-field="mail" data-sortable="true">E-mail</th>
				<th data-field="msg" data-sortable="true">Message</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($feedbacks->result_array() as $msg) : ?>
				<tr>
					<td><?php echo $msg['name'] ?></td>
					<td><a href="mailto:<?php echo $msg['user_mail'] ?>"><?php echo $msg['user_mail'] ?></a></td>
					<td><?php echo $msg['bdy'] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>


<style>
	.search-input {
		border: none;
		border-bottom: 1px solid #294a63;
	}

	.btn-md {
		background: #294a63 !important;
	}
</style>
<script>
	$(document).ready(function() {
		$(document).on('click', '.clear_feedbacks', function(e) {
			e.preventDefault();
			var con = confirm("Are you sure you want to clear this data?");
			if (con === false) {
				return false;
			} else {
				var linkurl = $(this).attr('href');
				window.location.assign(linkurl);
			}
		});
	});
</script>