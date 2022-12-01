<!-- plans -->
<div class="pt-4">
	<!-- <h4 class="text-dark">Subscriptions</h4> -->
	<!-- <hr class="sub"> -->
	<input type="hidden" name="sms_quota" class="sms_quota" id="sms_quota">
	<input type="hidden" name="email_quota" class="email_quota" id="email_quota">
	<input type="hidden" name="whatsapp_quota" class="whatsapp_quota" id="whatsapp_quota">
	<input type="hidden" name="web_quota" class="web_quota" id="web_quota">

	<div class="text-center">
		<h3>Simple Pricing for Everyone!</h3>
		<p>All plans come with a 100% money-back guarantee.</p>
	</div>

	<div class="plansDiv row">
		<?php foreach ($plans->result_array() as $p) : ?>
			<?php if ($p['active'] === '1') : ?>
				<div class="col" planID="plan<?php echo $p['id'] ?>">
					<div class="planDetails">
						<h5><?php echo $p['name'] ?></h5>
						<h6>
							<span>Rs </span>
							<b><?php echo $p['amount'] ?></b>
						</h6>

						<button type="button" class='btn chooseplanbtn' sms_quota="<?php echo $p['sms_quota'] ?>" email_quota="<?php echo $p['email_quota'] ?>" whatsapp_quota="<?php echo $p['whatsapp_quota'] ?>" web_quota="<?php echo $p['web_quota'] ?>" plan="planthree">Choose Plan</button>

						<ul>
							<li><?php echo $p['sms_quota'] ?> SMS Quota</li>
							<li><?php echo $p['email_quota'] ?> Email Quota</li>
							<li><?php echo $p['whatsapp_quota'] ?> WhatsApp Quota</li>
							<li><?php echo $p['web_quota'] ?> Website Quota</li>
							<li class="cmp_fet">Unlimited Users</li>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>

</div>
<hr>


<style>
	hr.sub {
		margin: auto 0;
		margin-bottom: 30px;
		border-bottom: 3px solid #294a63;
		width: 100px;
	}

	li.cmp_fet {
		display: none;
	}

	/* plans */
	.planDetails {
		text-align: center;
		box-shadow: 0 10px 15px #294a63;
		/* border-radius: 10px; */
		padding: 40px 30px;
		margin: 0 14px;
		background: #fff;
	}

	.planDetails h6 {
		font-weight: bold;
	}

	.planDetails button {
		border: 1px solid #294a63;
		color: #294a63;
		line-height: 34px;
		padding: 0 30px;
		border-radius: 20px;
		margin: 10px 0;
		transition: .5s;
	}

	.planDetails button:hover {
		color: #fff !important;
		background: #294a63 !important;
		transform: scale(1);
	}

	.planDetails ul {
		padding-top: 20px;
		text-align: left;
	}

	.planDetails ul li {
		font-weight: 500;
		padding: 8px;
		border-bottom: 1px solid #294a63
	}

	/*  */
</style>


<script>
	$(document).ready(function() {
		//on selecting any plan
		$(document).on('click', '.chooseplanbtn', function() {
			var plan = $(this).attr("plan");
			var sms_quota = $(this).attr("sms_quota");
			var email_quota = $(this).attr("email_quota");
			var whatsapp_quota = $(this).attr("whatsapp_quota");
			var web_quota = $(this).attr("web_quota");

			$(".sms_quota,.email_quota,.whatsapp_quota,.web_quota").val("");

			if (plan !== "" && sms_quota !== "" && email_quota !== "" && whatsapp_quota !== "" && web_quota !== "") {
				$(".sms_quota").val(sms_quota);
				$(".email_quota").val(email_quota);
				$(".whatsapp_quota").val(whatsapp_quota);
				$(".web_quota").val(web_quota);

				$(".chooseplanbtn").html("Choose Plan").css({
					background: '#fff',
					color: '#294a63'
				});
				$(this).html("Current Plan").css({
					background: '#294a63',
					color: '#fff'
				});
			} else {
				window.location.reload();
			}
		});
	});
</script>