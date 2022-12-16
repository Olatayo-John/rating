<!-- <h4 class="text-dark">Account</h4> -->
<!-- <hr class="account"> -->
<hr>
<div class="text-right">
    <button class="btn btn-danger deact_btn" type="button" user_id="<?php echo $user_info->id ?>">De-activate account?</button>
</div>
<hr>


<script>
    $(document).ready(function() {
        // de-activate account
        $(document).on('click', 'button.deact_btn', function() {
            var con = confirm("Are you sure you want to perform this operation? Your account will be de-activated and you'll be logged out completely");
            if (con == false) {
                return false;
            } else if (con == true) {

                var userid = $(this).attr("user_id");
                var csrfHash = $('.csrf_token').val();
                var csrfName = $('.csrf_token').attr("name");

                $.ajax({
                    url: "<?php echo base_url('deactivate-account'); ?>",
                    method: "post",
                    data: {
                        userid: userid,
                        [csrfName]: csrfHash
                    },
                    dataType: 'json',
                    beforeSend: function(data) {
                        clearAlert();

                        $('.deact_btn').html("Deactivating...").attr('disabled', 'disabled').css({
                            'cursor': 'not-allowed',
                        });
                    },
                    success: function(data) {

                        if (data.status === false) {
                            $(".ajax_res_err").text(data.msg);
                            $(".ajax_err_div").fadeIn();
                        } else if (data.status === true) {
                            $(".ajax_res_succ").text(data.msg);
                            $(".ajax_succ_div").fadeIn();

                            window.location.assign(data.redirect);

                        } else if (data.status == "error") {
                            window.location.assign(data.redirect);
                        }

                        $(".deact_btn").html('De-activate account?').removeAttr("disabled").css("cursor", "pointer");
                    }
                })
            }
        });
    });
</script>