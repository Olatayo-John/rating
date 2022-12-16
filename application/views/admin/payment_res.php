<div class="wrapper_div">
	<div class="bg-light-custom p-3">
		<?php if ($error === true) : ?>
			<div class="rHeader bg-light-custom p-3">
				<h5 class="text-left text-danger">ERROR</h5>
				<div class="siteD">
					<img class="siteI" src="<?php echo base_url("assets/images/") . $this->st->site_logo ?>" alt="">
					<!-- <div class="siteDi">
						<p><?php echo $this->st->site_logo ?></p>
						<p><?php echo $this->st->site_logo ?></p>
						<p><?php echo $this->st->site_logo ?></p>
					</div> -->
				</div>
			</div>
			<hr>

			<!-- error info -->
			<div class="bg-light-custom p-3">
				<p class="lead"><?php echo $msg ?></p>
			</div>
		<?php endif; ?>

		<?php if ($error === false) : ?>
			<div class="rHeader bg-light-custom p-3">
				<h5 class="text-left text-success"><?php echo $msg ?></h5>
				<div class="siteD">
					<img class="siteI" src="<?php echo base_url("assets/images/") . $this->st->site_logo ?>" alt="">
					<!-- <div class="siteDi">
						<p><?php echo $this->st->site_logo ?></p>
						<p><?php echo $this->st->site_logo ?></p>
						<p><?php echo $this->st->site_logo ?></p>
					</div> -->
				</div>
			</div>
			<hr>

			<!-- payment info -->
			<div class="bg-light-custom p-3">
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
				<p class="text-danger"><strong>Date: </strong><?php echo date('d M Y, h:i:s a', $PaymentInfoData['date']) ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>


<style>
	.wrapper_div {
		padding: 14px;
	}

	.rHeader {
		display: flex;
		justify-content: space-between;
	}

	.rHeader h5 {
		margin: auto 0;
	}

	.siteD {
		display: flex;
	}

	.siteI {
		max-width: 56px;
		max-height: 50px;
		margin: auto 10px auto 0
	}

	.siteDi p {
		margin: 0;
	}

	p strong {
		color: #294a63;
		font-weight: 500;
	}
</style>