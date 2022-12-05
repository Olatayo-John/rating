<!-- <h4 class="text-dark">Personal Information</h4>
<hr class="p_i"> -->
<form action="<?php echo base_url('update-user-company'); ?>" enctype="multipart/form-data" method="post" id="usercmpy_sadminForm">
    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="form-group">
        <label>Company Name</label> <span>*</span>
        <input type="text" name="cmpyName" class="form-control cmpyName" value="" placeholder="Company Name" required>
    </div>

    <div class="form-group">
        <label>Company Email</label>
        <input type="email" name="cmpyEmail" class="form-control cmpyEmail" value="" placeholder="example@domain-name.com">
    </div>

    <div class="form-group">
        <label>Company Mobile</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">+91</span>
            </div>

            <input type="number" name="cmpyMobile" class="form-control cmpyMobile" value="">
        </div>
        <div class="err mobileerr">Invalid mobile length</div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Company Logo</label>
            <span>Max size: 2MB</span>
            <input type="file" name="cmpyLogo" class="form-control cmpyLogo">
        </div>
        <div class="form-group col-md-6 cmpyLogoDiv">
            <img src="" alt="" class="cmpyLogoImg">
            <input type="hidden" name="h_cmpyLogoName" class="h_cmpyLogoName" value="">
            <input type="hidden" name="h_userid" class="h_userid" value="">
            <input type="hidden" name="h_form_key" class="h_form_key" value="">
            <input type="hidden" name="h_cmpydetailID" class="h_cmpydetailID" value="">
        </div>
    </div>

    <hr>
    <div class="form-group text-right">
        <button class="btn text-light save_cmpy_btn" type="submit" style="background-color:#294a63">Update</button>
    </div>
    <hr>
</form>


<script>
    $(document).ready(function() {
        $('form#usercmpy_sadminForm').submit(function(e) {
            e.preventDefault();

            var cmpyName = $('.cmpyName').val();
            var cmpyMobile = $('.cmpyMobile').val();

            if (cmpyName == "" || cmpyName == null) {
                return false;
            }

            if (cmpyMobile) {
                if (cmpyMobile.length < 10 || cmpyMobile.length > 10) {
                    $('.mobileerr').show();
                    return false;
                } else {
                    $('.mobileerr').hide();
                }
            }

            $.ajax({
                url: "<?php echo base_url('update-user-company'); ?>",
                method: "post",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    clearAlert();

                    $('.save_cmpy_btn').attr('disabled', 'disabled').html('Updating...').css('cursor', 'not-allowed');
                },
                error: function(res) {
                    var con = confirm('Some error occured. Refresh?');
                    if (con === true) {
                        window.location.reload();
                    } else if (con === false) {
                        return false;
                    }
                },
                success: function(res) {
                    if (res.status === false) {
                        $(".ajax_succ_div,.ajax_err_div").hide();
                        $(".ajax_res_err").text(res.msg);
                        $(".ajax_err_div").fadeIn();

                    } else if (res.status === true) {
                        $(".ajax_err_div,ajax_succ_div").hide();
                        $(".ajax_res_succ").text(res.msg);
                        $(".ajax_succ_div").fadeIn();
                        
                        $(".cmpyLogoImg").attr('src', res.logopath);
                    }

                    $('.save_cmpy_btn').removeAttr('disabled').html('Update').css('cursor', 'pointer');
                    $('.csrf-token').val(res.token);
                }
            })
        });

    });
</script>