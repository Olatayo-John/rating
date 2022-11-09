<!-- <h4 class="text-dark">Account</h4> -->
<!-- <hr class="account"> -->
<hr>
<div class="text-right">
    <button class="btn btn-danger deact_btn" type="button" user_id="<?php echo $user_info->id ?>"><i class="fas fa-user-alt-slash mr-2"></i>De-activate account?</button>
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
                    beforeSend: function(data) {
                        $('button.deact_btn').html("Deactivating...");
                    },
                    success: function(data) {
                        var url = "<?php echo base_url('logout') ?>";
                        window.location.assign(url);
                    }
                })
            }
        });
    });
</script>