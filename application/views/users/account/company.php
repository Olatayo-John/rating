<!-- <h4 class="text-dark">Company</h4> -->
<!-- <hr class="p_i"> -->
<form action="<?php echo base_url('company-edit'); ?>" enctype="multipart/form-data" method="post" id="cmpyForm">
    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="form-group">
        <label>Company Name</label> <span>*</span>
        <input type="text" name="cmpyName" class="form-control cmpyName" value="<?php echo $cmpyInfo->cmpyName ?>" placeholder="Company Name" required>
    </div>

    <div class="form-group">
        <label>Company Email</label>
        <input type="email" name="cmpyEmail" class="form-control cmpyEmail" value="<?php echo $cmpyInfo->cmpyEmail ?>" placeholder="example@domain-name.com">
    </div>

    <div class="form-group">
        <label>Company Mobile</label>
        <input type="number" name="cmpyMobile" class="form-control cmpyMobile" value="<?php echo $cmpyInfo->cmpyMobile ?>">
        <div class="err mobileerr">Invalid mobile length</div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Company Logo</label>
            <span>Max size: 2MB</span>
            <input type="file" name="cmpyLogo" class="form-control cmpyLogo">
        </div>
        <div class="form-group col-md-6 cmpyLogoDiv">
            <img src="<?php echo base_url('uploads/') . $this->session->userdata('mr_cmpy_logo'); ?>" alt="" class="cmpyLogoImg">
        </div>
    </div>

    <hr>
    <div class="form-group text-right">
        <button class="btn text-light save_cmpy_btn" type="submit" style="background-color:#294a63">Save</button>
    </div>
    <hr>
</form>


<script>
    $(document).ready(function() {
        $('form#cmpyForm').submit(function(e) {
            // e.preventDefault();
            var cmpyName = $('.cmpyName').val();

            if (cmpyName == "" || cmpyName == null) {
                return false;
            }

            $.ajax({
				beforeSend: function() {
					$('button.save_cmpy_btn').addClass('bg-danger').html('Saving...').attr('disabled', 'disabled').css({
						'cursor': 'not-allowed',
					});
				}
			});
        });


    });
</script>