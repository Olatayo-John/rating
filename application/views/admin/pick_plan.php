<form method="post" name="renew_plan_form" class="renew_plan_form" action="<?php echo base_url('admin/save_plan'); ?>" target>
	<input type="hidden" name="plan_amount" class="plan_amount">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
</form>

<input type="hidden" value="<?php echo $this->session->userdata('rr_form_key'); ?>" class="form_key">

<div class="container-fluid row mt-5">
	<div class="col-md-3 plan-one">
		<div class="card">
			<div class="card-header text-center bg-primary text-light">
				<label>BASIC</label>
			</div>
			<div class="text-center mt-2 mb-0 text-primary font-weight-bolder amount bg-primary text-light">
				<i class="fas fa-rupee-sign"></i>
				500
			</div>
			<div class="card-body">
				<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<h5 class="text-center text-primary">BENEFITS</h5>
				<div class="row">
					<div class="col-md-6">
						<i class="far fa-check-circle text-success"></i>First Point<br>
						<i class="fas fa-times text-danger"></i>Second Point<br>
						<i class="far fa-check-circle text-success"></i>Third Point<br>
					</div>
					<div class="col-md-6">
						<i class="far fa-check-circle text-success"></i>First Point<br>
						<i class="fas fa-times text-danger"></i>Second Point<br>
						<i class="fas fa-times text-danger"></i>Third Point<br>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?php if ($this->session->userdata('mr_sub') == '0') : ?>
					<button class="btn  btn-block sub_btn renewplanbtn" amount="500" type="submit">Choose Plan</button>
				<?php endif; ?>
				<?php if ($this->session->userdata('mr_sub') == '1') : ?>
					<button class="btn  btn-block sub_btn renewplanbtn" amount="500" type="submit">Renew Plan</button>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-md-3 plan-two">
		<div class="card bg-light">
			<div class="card-header text-center bg-secondary">
				<label>SILVER</label>
			</div>
			<div class="text-center mt-2 mb-0 text-secondary font-weight-bolder amount bg-secondary text-light">
				<i class="fas fa-rupee-sign"></i>
				1000
			</div>
			<div class="card-body">
				<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<h5 class="text-center text-secondary">BENEFITS</h5>
				<div class="row">
					<div class="col-md-6">
						<i class="far fa-check-circle text-success"></i>First Point<br>
						<i class="fas fa-times text-danger"></i>Second Point<br>
						<i class="far fa-check-circle text-success"></i>Third Point<br>
					</div>
					<div class="col-md-6">
						<i class="far fa-check-circle text-success"></i>First Point<br>
						<i class="fas fa-times text-danger"></i>Second Point<br>
						<i class="far fa-check-circle text-success"></i>Third Point<br>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?php if ($this->session->userdata('mr_sub') == '0') : ?>
					<button class="btn  btn-block sub_btn renewplanbtn" amount="1000" type="submit">Choose Plan</button>
				<?php endif; ?>
				<?php if ($this->session->userdata('mr_sub') == '1') : ?>
					<button class="btn  btn-block sub_btn renewplanbtn" amount="1000" type="submit">Renew Plan</button>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-md-3 plan-three">
		<div class="card ">
			<div class="card-header text-center bg-warning">
				<label>GOLD</label>
			</div>
			<div class="text-center mt-2 mb-0 text-warning font-weight-bolder amount bg-warning text-light">
				<i class="fas fa-rupee-sign"></i>
				1500
			</div>
			<div class="card-body">
				<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<h5 class="text-center text-warning">BENEFITS</h5>
				<div class="row">
					<div class="col-md-6">
						<i class="far fa-check-circle text-success"></i>First Point<br>
						<i class="far fa-check-circle text-success"></i>Second Point<br>
						<i class="far fa-check-circle text-success"></i>Third Point<br>
					</div>
					<div class="col-md-6">
						<i class="far fa-check-circle text-success"></i>First Point<br>
						<i class="fas fa-times text-danger"></i>Second Point<br>
						<i class="far fa-check-circle text-success"></i>Third Point<br>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?php if ($this->session->userdata('mr_sub') == '0') : ?>
					<button class="btn  btn-block sub_btn renewplanbtn" amount="1500" type="submit">Choose Plan</button>
				<?php endif; ?>
				<?php if ($this->session->userdata('mr_sub') == '1') : ?>
					<button class="btn  btn-block sub_btn renewplanbtn" amount="1500" type="submit">Renew Plan</button>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-md-3 plan-four">
		<div class="card">
			<div class="card-header text-center bg-dark text-light">
				<label>PLATINUM</label>
			</div>
			<div class="text-center mt-2 mb-0 font-weight-bolder amount bg-dark text-light">
				<i class="fas fa-rupee-sign"></i>
				2000
			</div>
			<div class="card-body">
				<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<h5 class="text-center text-dark">BENEFITS</h5>
				<div class="row">
					<div class="col-md-6">
						<i class="far fa-check-circle text-success"></i>First Point<br>
						<i class="far fa-check-circle text-success"></i>Second Point<br>
						<i class="far fa-check-circle text-success"></i>Third Point<br>
					</div>
					<div class="col-md-6">
						<i class="far fa-check-circle text-success"></i>First Point<br>
						<i class="far fa-check-circle text-success"></i>Second Point<br>
						<i class="far fa-check-circle text-success"></i>Third Point<br>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?php if ($this->session->userdata('mr_sub') == '0') : ?>
					<button class="btn  btn-block sub_btn renewplanbtn" amount="2000" type="submit">Choose Plan</button>
				<?php endif; ?>
				<?php if ($this->session->userdata('mr_sub') == '1') : ?>
					<button class="btn  btn-block sub_btn renewplanbtn" amount="2000" type="submit">Renew Plan</button>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="ml-3 mr-3 bg-light pb-3 mb-5 payment_div" style="padding: 10px 30px">
	<p class="text-center font-weight-bolder">Kindly find the details below for payment</p>
	<p class="mb-0"><strong>Bank: </strong> ICICI Bank </p>
	<p class="mb-0"> <strong>A/c Name: </strong> NKTechnologies ITSOL Private Limited</p>
	<p class="mb-0"> <strong>A/c No.: </strong> 721805000099</p>
	<p class="mb-0"><strong>IFSC: </strong> ICIC0007218</p>
	<p class="mb-0"><strong>Branch: </strong> SEC-62 Noida</p>
	<p class="mb-0"><strong>Addresses: </strong> Office No.308,3rd Floor,A-40, I-Thum Tower, Noida Sector-62, 201301</p>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$('.renewplanbtn').click(function() {
			//e.preventDefault();
			var amount = $(this).attr("amount");
			$('.plan_amount').attr('value', amount);
			$('form.renew_plan_form').submit();
		});

	});
</script>