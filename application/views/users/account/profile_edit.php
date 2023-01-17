<!-- <h4 class="text-dark">Personal Information</h4> -->
<!-- <hr class="p_i"> -->
<!-- modals -->
<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">


<div class="">
    <div class="qrcodeModal modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modalcloseDiv">
                        <h6></h6>
                        <i class="fas fa-times closeqrcodeModalBtn text-danger"></i>
                    </div>

                    <div id="qrcode"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<form action="<?php echo base_url('profile-edit'); ?>" method="post" id="profileForm">
    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="row">
        <div class="form-group col-md-6">
            <label>First Name</label>
            <input type="text" name="fname" class="form-control fname" value="<?php echo $user_info->fname ?>" placeholder="Your First Name">
        </div>
        <div class="form-group col-md-6">
            <label>Last Name</label>
            <input type="text" name="lname" class="form-control lname" value="<?php echo $user_info->lname ?>" placeholder="Your Last Name">
        </div>
    </div>

    <div class="form-group">
        <label>Email</label> <span>*</span>
        <input type="email" name="email" class="form-control email" value="<?php echo $user_info->email ?>" placeholder="example@domain-name.com" required>
    </div>

    <div class="form-group">
        <label>Mobile</label> <span>*</span>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">+91</span>
            </div>

            <input type="number" name="mobile" class="form-control mobile" value="<?php echo $user_info->mobile ?>" placeholder="0123456789" required>
        </div>
        <div class="err mobileerr">Invalid mobile length</div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Gender</label>
            <select name="gender" id="gender" class="form-control gender">
                <option value=""></option>
                <option value="Male" <?php echo ($user_info->gender === 'Male') ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?php echo ($user_info->gender === 'Female') ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?php echo ($user_info->gender === 'Other') ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Date Of Birth</label>
            <input type="date" name="dob" class="form-control dob" value="<?php echo $user_info->dob ?>">
        </div>
    </div>

    <?php if ($this->session->userdata('mr_iscmpy') === "1") : ?>
        <div class="form-group">
            <label>Company</label>
            <input type="text" name="uname" class="form-control uname" readonly disabled value="<?php echo $user_info->cmpy ?>" required disabled style="cursor: not-allowed;">
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label>Your Link</label>
        <div class="input-group">
            <input type="text" name="linkshare" class="form-control linkshare" id='linkshare' value="<?php echo base_url("wtr/") . $user_info->form_key ?>" required disabled style="cursor: not-allowed;">

            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-copy ml-2 copy_i" style="cursor:pointer" onclick="copylink_fun('#linkshare')"></i></span>
                <span class="input-group-text"><i class="fa-solid fa-qrcode genQrcode" style="cursor:pointer"></i></span>
            </div>
        </div>
        <div class="linkcopyalert" style="display:none;color:#294a63">Copied to your clipboard</div>
    </div>
    <hr>
    <div class="form-group text-right">
        <button class="btn text-light save_pinfo_btn" type="submit" style="background-color:#294a63">
            Save</button>
    </div>
    <hr>
</form>


<script>
    function copylink_fun(element) {
        var link = $("<input>");
        $("body").append(link);
        link.val($(element).val()).select();
        document.execCommand("copy");
        link.remove();
        $('.linkcopyalert').fadeIn("slow").delay("5000").fadeOut("slow");
    }

    $(document).ready(function() {

        //close modal
        $('.closeqrcodeModalBtn').click(function(e) {
            $('.qrcodeModal').modal('hide');

            $('#qrcode').children().remove();
        });

        //generate qr code
        $(document).on('click', '.genQrcode', function(e) {
            e.preventDefault();

            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var id = "<?php echo $this->session->userdata('mr_id'); ?>";
            var form_key = "<?php echo $this->session->userdata('mr_form_key'); ?>";
            var link = "<?php echo base_url("wtr/") . $user_info->form_key ?>";

            $.ajax({
                url: "<?php echo base_url('generate-qr-code') ?>",
                method: "post",
                dataType: 'json',
                data: {
                    [csrfName]: csrfHash,
                    id: id,
                    form_key: form_key,
                    link: link
                },
                beforeSend: function() {
                    clearAlert();
                },
                success: function(data) {
                    if (data.status === false) {
                        $(".ajax_res_err").append(data.msg);
                        $(".ajax_err_div").fadeIn();
                    } else if (data.status === 'error') {
                        window.location.assign(data.redirect);
                    } else if (data.status === true) {
                        $('#qrcode').append('<img src="'+data.qr+'">');
                        $('.qrcodeModal').modal('show');
                    }

                    $('.csrf_token').val(data.token);

                },
                error: function() {
                    alert("Error sending messages. Please try again");
                    // window.location.reload();
                }
            })
        })

        $('form#profileForm').submit(function(e) {
            // e.preventDefault();

            var uname = $('.uname').val();
            var email = $('.email').val();
            var mobile = $('.mobile').val();

            if (email == "" || email == null) {
                return false;
            }

            if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
                return false;
                $('.mobileerr').show();
            } else {
                $('.mobileerr').hide();
            }

            $.ajax({
                beforeSend: function() {
                    $('button.save_pinfo_btn').addClass('bg-danger').html('Saving...').attr('disabled', 'disabled').css({
                        'cursor': 'not-allowed',
                    })
                }
            });

        });
    });
</script>