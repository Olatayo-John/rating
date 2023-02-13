<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.0/gsap.min.js"></script>

<link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>

<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>

<link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">

<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/export/bootstrap-table-export.min.js"></script>

<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/print/bootstrap-table-print.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<div class="wrapper">
	<div class="bg-light-custom platforms">
		<?php if ($status === true) : ?>
			<?php foreach ($info->result_array() as $p) : ?>
				<?php $arr = parse_url($p['web_link']); ?>

				<a href="<?php echo (count($arr) > 1) ? $p['web_link'] : 'https://' . $p['web_link'] ?>" target="_blank" class='p-2'>
					<?php if ($p['logo']) : ?>
						<img src="<?php echo base_url("uploads/platform/") . $p['logo'] ?>" class="frameImg">
					<?php elseif ($p['icon']) : ?>
						<i class="<?php echo $p['icon'] ?> frameIcon"></i>
					<?php else : ?>
						<i class="fa-solid fa-globe frameIcon"></i>
					<?php endif; ?>
					<span><?php echo $p['web_name'] ?></span>
				</a>
			<?php endforeach; ?>
		<?php elseif ($status === false) : ?>
			<p class="text-danger"><?php echo $msg ?></p>
		<?php endif; ?>
	</div>
</div>




<style>
	.bg-light-custom {
		background: #fff;
		border: 1px solid #c5d6de;
	}

	.wrapper {
		padding: 14px;
	}

	p {
		text-align: center;
		margin: 0;
	}

	a:hover {
		text-decoration: none !important;
	}

	a,
	a i {
		color: #294a63;
	}

	.platforms {
		display: flex;
		justify-content: space-between;
		flex-wrap: wrap;
	}

	.frameIcon {}

	.frameImg {
		max-width: 60px;
		max-height: 60px;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {

		$(document).on('click', '.', function(e) {});

	});
</script>