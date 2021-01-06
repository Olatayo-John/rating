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

<h4 class="text-center text-light font-weight-bolder mb-3">LINKS/RATINGS</h4>
<div class="ls_div row mb-5">
	<div class="col-md-3 tl_col">
		<div class="value temail"><?php echo $ratings ?></div><hr>
		<h4 class="text-center stared mb-4">Total Ratings</h4>
	</div>
	<div class="col-md-3 tl_col text-dark">
		<div class="value tsms"><?php echo $sms[0]['sms'] ?></div><hr>
		<h4 class="text-center stared mb-4">Total SMS</h4>
	</div>
	<div class="col-md-3 tl_col">
		<div class="value temail"><?php echo $email[0]['email'] ?></div><hr>
		<h4 class="text-center stared mb-4">Total Emails</h4>
	</div>
</div>

<h4 class="text-center text-light font-weight-bolder mb-3">OVERRALL RATINGS</h4>
<div class="tr_div row mb-5">
	<div class="col-md-2 tr_col text-secondary">
		<h4 class="text-center text-light">Total Ratings</h4>
		<div class="value text-light"><?php echo $ratings  ?></div>
	</div>
	<div class="col-md-2 tr_col">
		<h4 class="text-center stared text-success">5 stared</h4>
		<div class="value"><?php echo $tr5 ?></div>
	</div>
	<div class="col-md-2 tr_col">
		<h4 class="text-center stared text-info">4 stared</h4>
		<div class="value"><?php echo $tr4 ?></div>
	</div>
	<div class="col-md-2 tr_col">
		<h4 class="text-center stared text-warning">3 stared</h4>
		<div class="value"><?php echo $tr3 ?></div>
	</div>
	<div class="col-md-2 tr_col">
		<h4 class="text-center stared">2 stared</h4>
		<div class="value"><?php echo $tr2 ?></div>
	</div>
	<div class="col-md-2 tr_col">
		<h4 class="text-center stared text-danger">1 stared</h4>
		<div class="value"><?php echo $tr1 ?></div>
	</div>
</div>

<!-- <div class="container yourlink mb-5">
	<label class="font-weight-bolder text-light mb-0 text-right">YOUR LINK</label>
	<div class="linkcopyalert text-success" style="display: none;"><strong>Link copied!</strong>
	</div>
	<input type="text" name="user_link" value="<?php echo base_url()."user/rate/".$user[0]['form_key'] ?>" class="form-control user_link" readonly id="user_link">
	<button class="btn text-light copylinkbtn mt-2" onclick="copyfunc('#user_link')" style="border-radius: 0px;background-color: #0B3954;color: white"><i class="fas fa-copy"></i> Copy link
	</button>
</div> -->

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">

<script type="text/javascript" src="<?php echo base_url('assets/js/quota.js'); ?>"></script>
<script type="text/javascript">
	function copyfunc(element) {
	 var link = $("<input>");
	 $("body").append(link);
	 link.val($(element).val()).select();
	 document.execCommand("copy");
	 link.remove();
	 $('.linkcopyalert').show();
	}

$(document).ready(function() {
  var csrfName= $('.csrf_token').attr('name');
	var csrfHash= $('.csrf_token').val();

	$('.valued').each(function () {
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