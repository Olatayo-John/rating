<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/account.css'); ?>">

<div class="set_wrapper_out">
	<div class="oudiv_wrapper p-3 bg-light-custom">
		<a href="account-edit"><i class="fa-solid fa-pen-to-square"></i></a>

		<div class="oudiv mb-4">
			<h3>Profile</h3>
			<table class="table table-hover">
				<tbody>
					<tr>
						<td>Username</td>
						<td><?php echo ($user_info->uname) ?></td>
					</tr>
					<tr>
						<td>First Name</td>
						<td><?php echo ($user_info->fname) ?></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><?php echo ($user_info->lname) ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><a href="mailto:<?php echo ($user_info->email) ?>"><?php echo ($user_info->email) ?></a></td>
					</tr>
					<tr>
						<td>Mobile Number</td>
						<td><a href="tel:<?php echo $user_info->mobile ?>"><?php echo ($user_info->mobile) ?></a></td>
					</tr>
					<tr>
						<td>Gender</td>
						<td><?php echo ($user_info->gender) ?></td>
					</tr>
					<tr>
						<td>DOB</td>
						<td><?php echo ($user_info->dob) ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="oudiv mb-4">
			<h3>Websites</h3>
			<table class="table table-hover">
				<tbody>
					<?php foreach ($websites->result_array() as $web) : ?>
						<tr>
							<td><a target="_blank" class="webA" href="<?php echo $web['web_link'] ?>"><?php echo $web['web_name'] ?></a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/account.js'); ?>"></script>