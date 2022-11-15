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

    <div class="form-group">
        <label>Company Logo</label>
        <span>Max size: 2MB</span>
        <input type="file" name="cmpyLogo" class="form-control cmpyLogo">
    </div>

    <hr>
    <div class="form-group text-right">
        <button class="btn text-light save_cmpy_btn" type="submit" style="background-color:#294a63">Update</button>
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
        });


    });
</script>