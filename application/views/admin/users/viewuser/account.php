<!-- <h4 class="text-dark">Account</h4>
<hr class="account"> -->

<form action="<?php echo base_url(''); ?>" method="post" id="useraccount_Form">
    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="form-group">
        <label>Reset user password</label> <span> *</span>
        <input type="password" name="auto-pwd" style="opacity: 0; position: absolute">
        <input type="password" name="rspwd" class="form-control rspwd" placeholder="Password must be over 6 characters long" id="rspwd" minlength="6" required>
        <span class="err pwderr">Password is too short</span>
    </div>

    <div class="form-group text-right">
        <i class="far fa-eye mr-2"></i>
        <i class="fas fa-eye-slash mr-2"></i>
        <button class="btn text-light genpwdbtn" style="background-color:#294a63" type="button" name="genpwdbtn">Generate Password</button>
    </div>

    <div class="form-group font-weight-bolder text-left d-flex">
        <div>Send new password to user email</div>
        <input type="checkbox" name="logincred" class="logincred" style="margin: auto 0 auto 3px;" checked required>
    </div>

    <hr>
    <div class="acctbtngrp">
        <div>
            <button class="btn btn-danger deact_btn" type="button">De-activate Account</button>
            <button class="btn act_btn btn-success" type="button">Verify Account</button>
        </div>
        <div class="ml-1">
            <button class="btn btn-danger subdeact_btn" type="button">De-activate Subscription</button>
            <button class="btn subact_btn btn-success" type="button">Activate Subscription</button>
        </div>
    </div>
    <hr>
    <div class="text-right">
        <button class="btn text-light updatepwdbtn" type="submit" name="updatepwdbtn" style="background-color:#294a63">Update</button>
    </div>
</form>


<script>
    $(document).ready(function() {

        // de-activate account
        $(document).on('click', 'button.deact_btn', function() {
            var con = confirm("Are you sure you want to perform this operation? User will be unable to login");
            if (con == false) {
                return false;
            } else if (con == true) {
                var user_id = $('#currentUserId').attr("user_id");
                var form_key = $('#currentUserId').attr("form_key");

                $.ajax({
                    url: "<?php echo base_url('deactivate-user-account'); ?>",
                    method: "post",
                    dataType: "json",
                    data: {
                        user_id: user_id,
                        form_key: form_key,
                        [csrfName]: csrfHash
                    },
                    error: function(res) {
                        window.location.reload();
                    },
                    beforeSend: function() {
                        clearAlert();
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

                            $(".deact_btn").hide();
                            $(".act_btn").show();
                        }

                        $('.csrf-token').val(res.token);
                    }
                })
            }
        });

        // activate account
        $(document).on('click', 'button.act_btn', function() {
            var con = confirm("Are you sure you want to perform this operation?");
            if (con == false) {
                return false;
            } else if (con == true) {
                var user_id = $('#currentUserId').attr("user_id");
                var form_key = $('#currentUserId').attr("form_key");

                $.ajax({
                    url: "<?php echo base_url('activate-user-account'); ?>",
                    method: "post",
                    dataType: "json",
                    data: {
                        user_id: user_id,
                        form_key: form_key,
                        [csrfName]: csrfHash
                    },
                    error: function(res) {
                        window.location.reload();
                    },
                    beforeSend: function() {
                        clearAlert();
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

                            $(".act_btn").hide();
                            $(".deact_btn").show();
                        }

                        $('.csrf-token').val(res.token);
                    }
                })
            }
        });

        // de-activate sub
        $(document).on('click', 'button.subdeact_btn', function() {
            var con = confirm("Are you sure you want to perform this operation? User will be denied access to services");
            if (con == false) {
                return false;
            } else if (con == true) {
                var user_id = $('#currentUserId').attr("user_id");
                var form_key = $('#currentUserId').attr("form_key");

                $.ajax({
                    url: "<?php echo base_url('deactivate-user-sub'); ?>",
                    method: "post",
                    dataType: "json",
                    data: {
                        user_id: user_id,
                        form_key: form_key,
                        [csrfName]: csrfHash
                    },
                    error: function(res) {
                        window.location.reload();
                    },
                    beforeSend: function() {
                        clearAlert();
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

                            $(".subdeact_btn").hide();
                            $(".subact_btn").show();

                            $('i.subI[sub_id="' + user_id + '"]').removeClass("fa-toggle-on text-success").addClass("fa-toggle-off text-danger").attr({
								'mod': 'not_active',
								'sub': '0'
							});
                        }

                        $('.csrf-token').val(res.token);
                    }
                })
            }
        });

        // activate sub
        $(document).on('click', 'button.subact_btn', function() {
            var con = confirm("Are you sure you want to perform this operation?");
            if (con == false) {
                return false;
            } else if (con == true) {

                var user_id = $('#currentUserId').attr("user_id");
                var form_key = $('#currentUserId').attr("form_key");

                $.ajax({
                    url: "<?php echo base_url('activate-user-sub'); ?>",
                    method: "post",
                    dataType: "json",
                    data: {
                        user_id: user_id,
                        form_key: form_key,
                        [csrfName]: csrfHash
                    },
                    error: function(res) {
                        window.location.reload();
                    },
                    beforeSend: function() {
                        clearAlert();
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

                            $(".subact_btn").hide();
                            $(".subdeact_btn").show();

                            $('i.subI[sub_id="' + user_id + '"]').removeClass("fa-toggle-off text-danger").addClass("fa-toggle-on text-success").attr({
								'mod': 'active',
								'sub': '1'
							});
                        }

                        $('.csrf-token').val(res.token);
                    }
                })
            }
        });

        $('form#useraccount_Form').submit(function(e) {
            e.preventDefault();

            var rspwd = $('.rspwd').val();
            var logincred = $(".logincred").is(':checked');
            var user_id = $('#currentUserId').attr("user_id");
            var user_email = $('#currentUserId').attr("user_email");
            var user_name = $('#currentUserId').attr("user_name");
            var form_key = $('#currentUserId').attr("form_key");

            if (rspwd == "" || rspwd == null || rspwd.length < 6) {
                $('span.pwderr').show();
                return false;
            } else {
                $('span.pwderr').hide();
            }

            $.ajax({
                url: "<?php echo base_url('update-user-password'); ?>",
                method: "post",
                data: {
                    user_id: user_id,
                    user_email: user_email,
                    user_name: user_name,
                    rspwd: rspwd,
                    logincred: logincred,
                    [csrfName]: csrfHash
                },
                beforeSend: function() {
                    clearAlert();

                    $('.updatepwdbtn').attr('disabled', 'disabled').html('Updating...').css('cursor', 'not-allowed');
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === false) {
                        $(".ajax_succ_div,.ajax_err_div").hide();
                        $(".ajax_res_err").text(res.msg);
                        $(".ajax_err_div").fadeIn();

                    } else if (res.status === true) {
                        $(".ajax_err_div,ajax_succ_div").hide();
                        $(".ajax_res_succ").text(res.msg);
                        $(".ajax_succ_div").fadeIn();

                        $('.rspwd').val("");
                        $('i.fa-eye,i.fa-eye-slash').hide();
                    }

                    $('.updatepwdbtn').removeAttr('disabled').html('Update').css('cursor', 'pointer');
                    $('.csrf_token').val(res.token);
                },
                error: function(res) {
                    var con = confirm('Some error occured. Refresh?');
                    if (con === true) {
                        window.location.reload();
                    } else if (con === false) {
                        return false;
                    }
                },
            });
        });
    });
</script>