<h4 class="text-dark">Account</h4>
<hr class="account">

<form action="<?php echo base_url('profile-edit'); ?>" method="post">
    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="form-group">
        <label><span class="text-danger font-weight-bolder">* </span>Reset User Password</label><i class="fas fa-question-circle ml-2" title="Password must be over 6 characters long"></i>
        <input type="password" name="auto-pwd" style="opacity: 0; position: absolute">
        <input type="password" name="rspwd" class="form-control rspwd" placeholder="Password must be over 6 characters long" id="rspwd" minlength="6">
        <span class="text-danger pwderr" style="display: none;">Password is too short</span>
    </div>
    <div class="form-group text-right">
        <i class="far fa-eye mr-2"></i>
        <i class="fas fa-eye-slash mr-2"></i>
        <button class="btn text-light genpwdbtn" style="background-color:#294a63" type="button" name="genpwdbtn">
            <i class="fas fa-lock mr-2"></i>Generate Password</button>
    </div>
    <div class="form-group font-weight-bolder text-left d-flex">
        <div>Send login credentials to user email</div>
        <input type="checkbox" name="logincred" class="logincred" style="margin: auto 0 auto 3px;" checked required>
    </div>
</form>

<hr>
<div class="acctbtngrp">
    <div>
        <button class="btn btn-danger deact_btn" type="button" user_id="" form_key="">De-activate user account?</button>
        <button class="btn act_btn btn-success" type="button" user_id="" form_key="">Activate user account?</button>
    </div>
    <div class="ml-1">
        <button class="btn btn-danger subdeact_btn" type="button" user_id="" form_key="">De-activate user subscription?</button>
        <button class="btn subact_btn btn-success" type="button" user_id="" form_key="">Activate user subscription?</button>
    </div>
</div>
<hr>
<div class="text-right">
    <button class="btn text-light updatepwdbtn" type="button" user_id="" user_email="" user_name="" name="updatepwdbtn" style="background-color:#294a63">Update User Password</button>
</div>


<script>
    $(document).ready(function() {

        // de-activate account
        $(document).on('click', 'button.deact_btn', function() {
            var con = confirm("Are you sure you want to perform this operation? User will be unable to login");
            if (con == false) {
                return false;
            } else if (con == true) {

                var user_id = $(this).attr("user_id");
                var form_key = $(this).attr("form_key");

                $.ajax({
                    url: "<?php echo base_url('account-deactivate'); ?>",
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
                    success: function(res) {
                        if (res.status === false) {
                            $(".ajax_succ_div,.ajax_err_div").hide();
                            $(".ajax_res_err").text(res.msg);
                            $(".ajax_err_div").fadeIn().delay("6000").fadeOut();

                        } else if (res.status === true) {
                            $(".ajax_err_div,ajax_succ_div").hide();
                            $(".ajax_res_succ").text(res.msg);
                            $(".ajax_succ_div").fadeIn().delay("6000").fadeOut();

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

                var user_id = $(this).attr("user_id");
                var form_key = $(this).attr("form_key");

                $.ajax({
                    url: "<?php echo base_url('activate-account'); ?>",
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
                    success: function(res) {
                        if (res.status === false) {
                            $(".ajax_succ_div,.ajax_err_div").hide();
                            $(".ajax_res_err").text(res.msg);
                            $(".ajax_err_div").fadeIn().delay("6000").fadeOut();

                        } else if (res.status === true) {
                            $(".ajax_err_div,ajax_succ_div").hide();
                            $(".ajax_res_succ").text(res.msg);
                            $(".ajax_succ_div").fadeIn().delay("6000").fadeOut();

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

                var user_id = $(this).attr("user_id");
                var form_key = $(this).attr("form_key");

                $.ajax({
                    url: "<?php echo base_url('deactivate-sub'); ?>",
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
                    success: function(res) {
                        if (res.status === false) {
                            $(".ajax_succ_div,.ajax_err_div").hide();
                            $(".ajax_res_err").text(res.msg);
                            $(".ajax_err_div").fadeIn().delay("6000").fadeOut();

                        } else if (res.status === true) {
                            $(".ajax_err_div,ajax_succ_div").hide();
                            $(".ajax_res_succ").text(res.msg);
                            $(".ajax_succ_div").fadeIn().delay("6000").fadeOut();

                            $(".subdeact_btn").hide();
                            $(".subact_btn").show();
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

                var user_id = $(this).attr("user_id");
                var form_key = $(this).attr("form_key");

                $.ajax({
                    url: "<?php echo base_url('activate-sub'); ?>",
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
                    success: function(res) {
                        if (res.status === false) {
                            $(".ajax_succ_div,.ajax_err_div").hide();
                            $(".ajax_res_err").text(res.msg);
                            $(".ajax_err_div").fadeIn().delay("6000").fadeOut();

                        } else if (res.status === true) {
                            $(".ajax_err_div,ajax_succ_div").hide();
                            $(".ajax_res_succ").text(res.msg);
                            $(".ajax_succ_div").fadeIn().delay("6000").fadeOut();

                            $(".subact_btn").hide();
                            $(".subdeact_btn").show();
                        }

                        $('.csrf-token').val(res.token);
                    }
                })
            }
        });

        $('button.updatepwdbtn').click(function(e) {
            e.preventDefault();

            var rspwd = $('.rspwd').val();
            var user_id = $(this).attr('user_id');
            var user_email = $(this).attr('user_email');
            var user_name = $(this).attr('user_name');
            var logincred = $(".logincred").is(':checked');

            if (rspwd == "" || rspwd == null) {
                $('.rspwd').css('border', '1px solid red');
                return false;
            }
            if (rspwd.length < 6) {
                $('.rspwd').css('border', '1px solid red');
                $('span.pwderr').show();
                return false;
            } else {
                $('span.pwderr').hide();
                $('.rspwd').css('border', '1px solid #ced4da');
            }

            $.ajax({
                url: "<?php echo base_url('updateuserpwd'); ?>",
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
                    $('.updatepwdbtn').attr('disabled', 'disabled').html('Updating...').css('cursor', 'not-allowed');
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === false) {
                        $(".ajax_succ_div,.ajax_err_div").hide();
                        $(".ajax_res_err").text(res.msg);
                        $(".ajax_err_div").fadeIn().delay("6000").fadeOut();

                    } else if (res.status === true) {
                        $(".ajax_err_div,ajax_succ_div").hide();
                        $(".ajax_res_succ").text(res.msg);
                        $(".ajax_succ_div").fadeIn().delay("6000").fadeOut();

                        $('.rspwd').val("");
                        $('i.fa-eye,i.fa-eye-slash').hide();
                    }

                    $('.updatepwdbtn').removeAttr('disabled').html('Update User Password').css('cursor', 'pointer');
                    $('.csrf_token').val(res.token);
                }
            });
        });
    });
</script>