<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pay_stat.css'); ?>">

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token form-control">

<div class="container mt-3 mb-5 pb-3" style="background:white">
	<?php if ($userData['status'] == 'TXN_FAILURE') : ?>
		<h4 class="text-center text-danger pt-3">Payment Failed</h4>
		<hr class="pb-2 h_hr" style="width: 90px;">
		<div class="form-group mt-4">
			<label>STATUS</label>
			<input type="text" name="STATUS" value="<?php echo $userData['status'] ?>" class="form-control" readonly>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label>MERCHANT ID</label>
				<input type="text" name="MERCHANT ID" value="<?php echo $userData['m_id'] ?>" class="form-control" readonly>
			</div>
			<div class="col-md-6 second">
				<label>TRANSACTION ID</label>
				<input type="text" name="TRANSACTION ID" value="<?php echo $userData['txn_id'] ?>" class="form-control" readonly>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label>ORDER ID</label>
				<input type="text" name="ORDER ID" value="<?php echo $userData['order_id'] ?>" class="form-control" readonly>
			</div>
			<div class="col-md-6 second">
				<label>BANK TRANSACTION ID</label>
				<input type="text" name="BANK TRANSACTION ID" value="<?php echo $userData['bank_txn_id'] ?>" class="form-control" readonly>
			</div>
		</div>
		<div class="form-group">
			<label>BANK</label>
			<input type="text" name="BANK" value="<?php echo $userData['bank_name'] ?>" class="form-control" readonly>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label>PAYMENT MODE</label>
				<input type="text" name="PAYMENT MODE" value="<?php echo $userData['payment_mode'] ?>" class="form-control" readonly>
			</div>
			<div class="col-md-6 second">
				<label>GATEWAY NAME</label>
				<input type="text" name="GATEWAY NAME" value="<?php echo $userData['gateway_name'] ?>" class="form-control" readonly>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label>AMOUNT TO BE PAID</label>
				<input type="text" name="AMOUNT PAID" value="<?php echo $userData['paid_amt'] ?>" class="form-control" readonly>
			</div>
			<div class="col-md-6 second">
				<label>CURRENCY</label>
				<input type="text" name="CURRENCY" value="<?php echo $userData['currency'] ?>" class="form-control" readonly>
			</div>
		</div>
	<?php endif; ?>

	<?php if ($userData['status'] == 'TXN_SUCCESS') : ?>
		<h4 class="text-center text-uppercase pt-3">Payment Successfull</h4>
		<hr class="pb-2 h_hr">
		<div class="text-danger text-left">
			<p>Payment Done</p>
			<p>You'll be notified once your payment has been verified</p>
			<p>For any queries, contact us at <a href="mailto:hr@nktech.in">nktech.in</a></p>
			<p>Save this details for future reference</p>
		</div>
		<div class="form-group mt-4">
			<label>STATUS</label>
			<input type="text" name="STATUS" value="<?php echo $userData['status'] ?>" class="form-control" readonly>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label>MERCHANT ID</label>
				<input type="text" name="MERCHANT ID" value="<?php echo $userData['m_id'] ?>" class="form-control" readonly>
			</div>
			<div class="col-md-6 second">
				<label>TRANSACTION ID</label>
				<input type="text" name="TRANSACTION ID" value="<?php echo $userData['txn_id'] ?>" class="form-control" readonly>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label>ORDER ID</label>
				<input type="text" name="ORDER ID" value="<?php echo $userData['order_id'] ?>" class="form-control" readonly>
			</div>
			<div class="col-md-6 second">
				<label>BANK TRANSACTION ID</label>
				<input type="text" name="BANK TRANSACTION ID" value="<?php echo $userData['bank_txn_id'] ?>" class="form-control" readonly>
			</div>
		</div>
		<div class="form-group">
			<label>BANK</label>
			<input type="text" name="BANK" value="<?php echo $userData['bank_name'] ?>" class="form-control" readonly>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label>PAYMENT MODE</label>
				<input type="text" name="PAYMENT MODE" value="<?php echo $userData['payment_mode'] ?>" class="form-control" readonly>
			</div>
			<div class="col-md-6 second">
				<label>GATEWAY NAME</label>
				<input type="text" name="GATEWAY NAME" value="<?php echo $userData['gateway_name'] ?>" class="form-control" readonly>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label>AMOUNT PAID</label>
				<input type="text" name="AMOUNT PAID" value="<?php echo $userData['paid_amt'] ?>" class="form-control" readonly>
			</div>
			<div class="col-md-6 second">
				<label>CURRENCY</label>
				<input type="text" name="CURRENCY" value="<?php echo $userData['currency'] ?>" class="form-control" readonly>
			</div>
		</div>
	<?php endif; ?>

</div>