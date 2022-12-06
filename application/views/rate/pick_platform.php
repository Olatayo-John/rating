<div class="set_wrapper">
	<div class="bg-light-custom">
		<form action="#" method="post" id="platformForm" class="p-3">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">

			<div class="form-group">
				<label for="">Select Platform</label>
				<select name="platform" id="platform" class="form-control" required>
					<?php if ($platforms->num_rows() > 0) : ?>
						<option value="">Select Platform</option>
						<?php foreach ($platforms->result_array() as $p) : ?>
							<?php if ($p['active'] === '1') : ?>
								<option value="<?php echo $p['id'] ?>"><?php echo $p['web_name'] ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php else : ?>
						<option value="">No platform created</option>
					<?php endif; ?>
				</select>
			</div>

			<hr>
			<div class="form-group text-right">
				<button name="" class="btn text-light" type="submit" style="background-color:#294a63">Continue</button>
			</div>
		</form>

	</div>
</div>
<style type="text/css">
	.set_wrapper {
		padding: 14px;
	}
</style>

<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('change', '#platform', function(e) {
			e.preventDefault();

			var platformid = $(this).val();

			if (platformid && platformid !== "" && platformid !== null && platformid !== undefined) {
				var b = "<?php echo base_url('wtr') ?>";
				var r = "<?php echo $k ?>";
				var newURL = b + "/" + r + "/" + platformid;

				// console.log(newURL);
				$('#platformForm').attr('action',newURL)
			}

		});
	});
</script>