<!-- <h4 class="text-dark">Personal Information</h4>
<hr class="p_i"> -->
<form action="<?php echo base_url('update-user-quota'); ?>" method="post" id="userquota_sadminForm">
    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="form-group">
        <label>Current Email Quota</label> <span>*</span>
        <input type="number" name="email_quota" class="form-control email_quota" value="" required>
    </div>

    <div class="form-group">
        <label>Current SMS Quota</label> <span>*</span>
        <input type="number" name="sms_quota" class="form-control sms_quota" value="" required>
    </div>

    <div class="form-group">
        <label>Current Whatsapp Quota</label> <span>*</span>
        <input type="number" name="whatsapp_quota" class="form-control whatsapp_quota" value="" required>
    </div>

    <div class="form-group">
        <label>Current Web Quota</label> <span>*</span>
        <input type="number" name="web_quota" class="form-control web_quota" value="" required>
    </div>

    <hr>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control amount" readonly value="">
        </div>
        <div class="form-group col-md-6">
            <label>Due Amount</label>
            <input type="number" name="balance" class="form-control balance" readonly value="">
        </div>
    </div>


    <hr>
    <div class="form-group text-right">
        <button class="btn text-light save_qt_btn" type="submit" style="background-color:#294a63">Save</button>
    </div>
    <hr>
</form>


<script>
    $(document).ready(function() {
        $('form#userquota_sadminForm').submit(function(e) {
            e.preventDefault();

            var email_quota = $('.email_quota').val();
            var sms_quota = $('.sms_quota').val();
            var whatsapp_quota = $('.whatsapp_quota').val();
            var web_quota = $('.web_quota').val();
            var user_id = $('#currentUserId').attr("user_id");
            var user_name = $('#currentUserId').attr("user_name");
            var form_key = $('#currentUserId').attr("form_key");
            var user_isadmin = $('#currentUserId').attr("user_isadmin");
            var user_iscmpy = $('#currentUserId').attr("user_iscmpy");

            if (email_quota == "" || email_quota == null || sms_quota == "" || sms_quota == null || whatsapp_quota == "" || whatsapp_quota == null || web_quota == "" || web_quota == null) {
                return false;
            }

            $.ajax({
                url: "<?php echo base_url('update-user-quota'); ?>",
                method: "post",
                data: {
                    user_id: user_id,
                    user_name:user_name,
                    form_key: form_key,
                    user_isadmin: user_isadmin,
                    user_iscmpy: user_iscmpy,
                    email_quota: email_quota,
                    sms_quota: sms_quota,
                    whatsapp_quota: whatsapp_quota,
                    web_quota: web_quota,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                beforeSend: function() {
                    clearAlert();

                    $('.save_qt_btn').html('Saving...').attr('disabled', 'disabled').css('cursor', 'not-allowed');
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
                        $(".ajax_res_err").text(res.msg);
                        $(".ajax_err_div").fadeIn();

                    } else if (res.status === true) {
                        $(".ajax_res_succ").text(res.msg);
                        $(".ajax_succ_div").fadeIn();
                    }

                    $('.save_qt_btn').html('Save').removeAttr('disabled').css('cursor', 'pointer');
                    $('.csrf-token').val(res.token);
                }
            })
        });

    });
</script>