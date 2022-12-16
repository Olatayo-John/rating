<!-- <h4 class="text-dark">Reset Password</h4> -->
<!-- <hr class="preset"> -->
<form action="<?php echo base_url('password-update'); ?>" method="post" id="pwdForm">
    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="form-group">
        <label>Current Password</label> <span>*</span>
        <input type="password" name="c_pwd" class="form-control c_pwd" placeholder="Your current password" required>
    </div>
    <hr>

    <div class="form-group">
        <button class="btn text-light genpwdbtn" style="background-color:#294a63" type="button" name="genpwdbtn">
            Generate Password
        </button>
        <input type="text" class="genptext">
    </div>

    <div class="form-group">
        <label>New Password</label> <span>*</span>
        <input type="password" minlenght="6" name="n_pwd" class="form-control n_pwd" placeholder="Password must be at least 6 characters long" required>
        <span class="err n_pwd_err">Password is too short</span>
    </div>
    <div class="form-group">
        <label>Re-type Password</label> <span>*</span>
        <input type="password" minlenght="6" name="rtn_pwd" class="form-control rtn_pwd" placeholder="Re-type Password" required>
        <span class="err rtn_pwd_err">Passwords do not match</span>
    </div>
    <hr>
    <div class="d-flex" style="justify-content:space-between;">
        <div class="text-left">
            <button class="btn btn-danger pwd_f" type="button" user_id="<?php echo $user_info->id ?>">Forgot Password?</button>
        </div>
        <div class="text-right">
            <button class="btn text-light saveact_btn" type="submit saveact_btn" style="background-color:#294a63">
                Update Password
            </button>
        </div>
    </div>
    <hr>
</form>

<div class="modal fade forgotpass_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modalcloseDiv">
                    <h6></h6>
                    <i class="fas fa-times close_forgotpass_modal text-danger"></i>
                </div>

                <form action="<?php echo base_url('password-update'); ?>" method="post">
                    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <span class="text-success codeinstruct">Verfication code will be sent to this email</span>
                    <div class="form-group">
                        <input type="email" name="fp_email" value="<?php echo $user_info->email ?>" class="fp_email form-control" required readonly disabled style="cursor:not-allowed">
                    </div>
                    <hr>
                    <div class="d-flex" style="justify-content: space-between;">
                        <div class="form-group rsendcodebtndiv">
                            <button class="btn text-light rsendcodebtn bg-danger" type="button">Resend Code</button>
                        </div>
                        <div class="form-group sendcodebtndiv">
                            <button class="btn text-light sendcodebtn" type="button" style="background:#294a63">Send verfication code</button>
                        </div>
                    </div>

                    <div class="form-group vcodediv">
                        <label for="vcode">Enter the verfication code sent to your email</label>
                        <input type="text" class="vcode form-control" required>
                        <span class="vcodeerr err"></span>
                    </div>
                    <hr>
                    <div class="form-group text-right vcodebtndiv">
                        <button class="btn text-light vcodebtn" type="button" style="background:#294a63">Verify Code</button>
                    </div>

                    <div class="form-group fp_pwddiv">
                        <label for="fp_pwd font-weight-bolder">Enter a new Password</label>
                        <input type="password" name="fp_pwd" class="fp_pwd form-control" placeholder="Password must be over 6 characters long">
                        <span class="fp_passerr err"></span>
                    </div>
                    <hr>
                    <div class="form-group text-right fp_newpwdbtndiv">
                        <button class="btn text-light fp_newpwdbtn" type="button" style="background:#294a63">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('form#pwdForm').submit(function(e) {
            // e.preventDefault();
            var c_pwd = $('.c_pwd').val();
            var n_pwd = $('.n_pwd').val();
            var rtn_pwd = $('.rtn_pwd').val();
            var formErr = null;

            if (c_pwd == "" || c_pwd == null) {
                formErr = true;
            } else {
                formErr = "";
            }

            if (n_pwd == "" || n_pwd == null || n_pwd.length < 6) {
                formErr = true;
                $('span.n_pwd_err').show();
            } else {
                $('span.n_pwd_err').hide();
                formErr = "";
            }

            if (rtn_pwd == "" || rtn_pwd == null) {
                formErr = true;
            }
            if (n_pwd !== rtn_pwd) {
                formErr = true;
                $('span.rtn_pwd_err').show();
            } else {
                $('span.rtn_pwd_err').hide();
                formErr = "";
            }

            if (formErr === true) {
                return false;
            }
        });

        // forgot password modal
        $(document).on('click', 'button.pwd_f', function() {
            $('.forgotpass_modal').modal("show");
        });

        $(document).on('click', 'button.sendcodebtn,button.rsendcodebtn', function(e) {
            e.preventDefault();

            var csrfHash = $('.csrf_token').val();
            var csrfName = $('.csrf_token').attr("name");
            var userid = "<?php echo $this->session->userdata('mr_id') ?>";
            var useremail = $(".fp_email").val();
            var vcode_init = returnPassword();

            $.ajax({
                url: "<?php echo base_url('resetpassword_vcode'); ?>",
                method: "post",
                data: {
                    userid: userid,
                    useremail: useremail,
                    vcode_init: vcode_init,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                beforeSend: function(data) {
                    clearAlert();

                    $(".sendcodebtn,.rsendcodebtn ").html("Sending...").attr("disabled", "disabled").css("cursor", "not-allowed");
                },
                success: function(data) {
                    if (data.status === false) {
                        $(".ajax_succ_div,.ajax_err_div").hide();
                        $(".ajax_res_err").text(data.msg);
                        $(".ajax_err_div").fadeIn();

                        $(".sendcodebtn,.rsendcodebtn ").html("Send Verfication Code").removeAttr("disabled").css("cursor", "pointer");;

                    } else if (data.status === true) {
                        $(".ajax_err_div,.ajax_succ_div").hide();
                        $(".ajax_res_succ").text(data.msg);
                        $(".ajax_succ_div").fadeIn();

                        $(".codeinstruct").html("Verification code sent to this email");

                        //rsendcode brn
                        $('.rsendcodebtndiv').css('visibility', 'initial');

                        //send vcode btn
                        $(".sendcodebtn").css({
                            'visibility': 'hidden',
                            'cursor': 'not-allowed',
                        }).attr("disabled", "disabled").html("Sent");

                        //vcode input and btn
                        $(".vcodediv,.vcodebtndiv").fadeIn();
                        $(".vcode").val("");
                    }
                    $(".rsendcodebtn").html("Resend Code").removeAttr("disabled").css("cursor", "pointer");
                    $('.csrf_token').val(data.token);
                }
            });
        });

        $(document).on('click', 'button.vcodebtn', function(e) {
            e.preventDefault();

            var csrfHash = $('.csrf_token').val();
            var csrfName = $('.csrf_token').attr("name");
            var vecode = $('.vcode').val();
            var userid = "<?php echo $this->session->userdata('mr_id') ?>";


            if (vecode == "" || vecode == undefined || vecode == null) {
                $('.vcode').css('border-bottom', '2px solid #dc3545');
                $('.vcodeerr').text('Verfication code is required').show();
                return false;
            } else {
                $('.vcode').css('border', '1px solid #ced4da');
                $('.vcodeerr').hide();
            }

            $.ajax({
                url: "<?php echo base_url('verify'); ?>",
                method: "post",
                data: {
                    userid: userid,
                    vecode: vecode,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                beforeSend: function(data) {
                    clearAlert();
                },
                success: function(data) {
                    if (data.status === false) {
                        $(".ajax_res_err").text(data.msg);
                        $(".ajax_err_div").fadeIn();

                        $(".sendcodebtn").html("Send Verfication Code");

                    } else if (data.status === true) {
                        $(".ajax_res_succ").text(data.msg);
                        $(".ajax_succ_div").fadeIn();

                        //rsendcode btn
                        $(".rsendcodebtn").css({
                            'cursor': 'not-allowed',
                        }).attr('disabled', 'disabled').fadeOut();

                        //vcode input
                        $('.vcode').css({
                            'cursor': 'not-allowed',
                        }).attr({
                            'readonly': 'readonly',
                            'disabled': 'disabled'
                        });
                        //vcode btn
                        $(".vcodebtn").css({
                            'cursor': 'not-allowed',
                        }).addClass("bg-success").attr('disabled', 'disabled').html("Verified!").fadeOut();


                        $(".fp_pwddiv,.fp_newpwdbtndiv").fadeIn();
                        $(".fp_pwd").val("");
                        $(".close_forgotpass_modal").attr("proc", true);
                    }

                    $('.csrf_token').val(data.token);
                }
            });

        });

        $(document).on('click', 'button.fp_newpwdbtn', function(e) {
            e.preventDefault();

            var csrfHash = $('.csrf_token').val();
            var csrfName = $('.csrf_token').attr("name");
            var newpwd = $('.fp_pwd').val();
            var userid = "<?php echo $this->session->userdata('mr_id') ?>";

            if (newpwd == "" || newpwd == undefined || newpwd == null || newpwd.length < 6) {
                $('.fp_pwd').css('border-bottom', '2px solid #dc3545');
                $('.fp_passerr').text('Password too short').show();
                return false;
            } else {
                $('.fp_pwd').css('border', '1px solid #ced4da');
                $('.fp_passerr').hide();
            }

            $.ajax({
                url: "<?php echo base_url('passwordreset'); ?>",
                method: "post",
                data: {
                    userid: userid,
                    newpwd: newpwd,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                beforeSend: function() {
                    clearAlert();

                    $('.fp_newpwdbtn').addClass('bg-danger').html("Saving...").attr('disabled', 'disabled').css({
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

                        //newpwd input
                        $('.fp_pwd').css({
                            'cursor': 'not-allowed',
                        }).attr({
                            'readonly': 'readonly',
                            'disabled': 'disabled'
                        });

                        //newpwd btn
                        $(".fp_newpwdbtn").removeClass("bg-danger").html("Save").removeAttr('disabled').css({
                            'cursor': 'pointer'
                        });

                        window.location.reload();
                    }
                }
            });
        });

        $(document).on('click', '.close_forgotpass_modal', function(e) {
            e.preventDefault();

            var inproc = $(".close_forgotpass_modal").attr("proc");

            if (inproc === "true") {
                var con = confirm("Are you sure you want to exit this process?");
                if (con === false) {
                    return false;
                } else if (con === true) {
                    $('.forgotpass_modal').modal("hide");

                    $(".codeinstruct").html("Verfication code will be sent to this email");

                    $(".rsendcodebtndiv").css({
                        'visibility': 'hidden',
                    });
                    $(".sendcodebtn").css({
                        'visibility': 'initial',
                    });

                    $(".rsendcodebtn,.sendcodebtn,.vcodebtn").removeAttr("disabled").css("cursor", "pointer");
                    $(".vcode").removeAttr("disabled readonly").css("cursor", "text");

                    $(".sendcodebtn").html("Send Verfication Code");
                    $(".vcodebtn ").html("Verify").css("background", "#294a63");

                    $(".fp_pwddiv,.fp_passerr,.fp_newpwdbtndiv,.vcodediv,.vcodeerr,.vcodebtndiv").hide();
                    $(".fp_pwd,.vcode").val("");
                    $(".close_forgotpass_modal").attr("proc", "");

                    return true;
                }
            } else if (inproc === "false" || inproc === undefined || inproc === null || inproc === "") {
                $('.forgotpass_modal').modal("hide");
            }

        });
    });
</script>