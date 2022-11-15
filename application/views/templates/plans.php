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
		<div class="col-md-4 planone" plan="planone">
			<div class="planDetails">
				<h5>Free Plan</h5>
				<h6>
					<span>Rs </span>
					<b>0.00 /per month</b>
				</h6>

				<button type="button" class='btn chooseplanbtn' sms_quota="5" email_quota="100" whatsapp_quota="5" web_quota="5" plan="planthree">Choose Plan</button>

				<ul>
					<li>5 SMS Quota</li>
					<li>100 Email Quota</li>
					<li>5 WhatsApp Quota</li>
					<li>1 Website Quota</li>
					<li class="cmp_fet">Unlimited Users</li>
				</ul>
			</div>
		</div>

		<div class="col-md-4 plantwo" plan="plantwo">
			<div class="planDetails">
				<h5>Basic Plan</h5>
				<h6>
					<span>Rs </span>
					<b>1.00 /per month</b>
				</h6>

				<button type="button" class='btn chooseplanbtn' sms_quota="5" email_quota="100" whatsapp_quota="5" web_quota="5" plan="planthree">Choose Plan</button>

				<ul>
					<li>5 SMS Quota</li>
					<li>100 Email Quota</li>
					<li>5 WhatsApp Quota</li>
					<li>5 Website Quota</li>
					<li class="cmp_fet">Unlimited Users</li>
				</ul>
			</div>
		</div>

		<div class="col-md-4 planthree" plan="planthree">
			<div class="planDetails">
				<h5>Regular Plan</h5>
				<h6>
					<span>Rs </span>
					<b>2.00 /per month</b>
				</h6>

				<button type="button" class='btn chooseplanbtn' sms_quota="5" email_quota="100" whatsapp_quota="5" web_quota="5" plan="planthree">Choose Plan</button>

				<ul>
					<li>5 SMS Quota</li>
					<li>100 Email Quota</li>
					<li>5 WhatsApp Quota</li>
					<li>5 Website Quota</li>
					<li class="cmp_fet">Unlimited Users</li>
				</ul>
			</div>
		</div>

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