<div class="wrapper_div">
	<div class="bg-light-custom p-3">
		<?php if ($error === true) : ?>
			<h4 class="display-5 text-danger">ERROR</h4>
			<hr>

			<p class="lead"><?php echo $msg ?></p>
		<?php endif; ?>

		<?php if ($error === false) : ?>
			<h5 class="text-left text-success"><?php echo $msg ?></h5>
			<hr>

			<p class="lead m-0 text-right"><?php echo $PaymentInfoData['email']  ?></p>
			<p class="lead m-0 text-right"><?php echo $PaymentInfoData['mobile']  ?></p>

			<p><strong>Payment ID: </strong><?php echo $PaymentInfoData['payment_id'] ?></p>
			<p><strong>Order ID: </strong><?php echo $PaymentInfoData['order_id'] ?></p>
			<p><strong>Amount: </strong><?php echo $PaymentInfoData['currency'] ?> <?php echo $PaymentInfoData['amount'] ?></p>
			<p><strong>Mode Of Payment: </strong><?php echo $PaymentInfoData['mop'] ?></p>
			<?php if ($PaymentInfoData['bank']) : ?>
				<p><strong>Bank: </strong><?php echo $PaymentInfoData['bank'] ?></p>
				<p><strong>Transaction ID: </strong><?php echo $PaymentInfoData['transaction_id'] ?></p>
			<?php elseif ($PaymentInfoData['vpa']) : ?>
				<p><strong>VPA: </strong><?php echo $PaymentInfoData['vpa'] ?></p>
				<p><strong>Transaction ID: </strong><?php echo $PaymentInfoData['transaction_id'] ?></p>
			<?php elseif ($PaymentInfoData['wallet']) : ?>
				<p><strong>Wallet: </strong><?php echo $PaymentInfoData['wallet'] ?></p>
			<?php endif ?>
			<p><strong>Description: </strong><?php echo $PaymentInfoData['description'] ?></p>
			<p class="text-danger"><strong>Date: </strong><?php echo date('d M Y, h:i:s a',$PaymentInfoData['date']) ?></p>
		<?php endif; ?>
	</div>
</div>


<style>
	.wrapper_div {
		padding: 14px;
	}
	p strong{
		color: #294a63;
		font-weight: 500;
	}
</style>