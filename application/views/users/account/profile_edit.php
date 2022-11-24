<!-- <h4 class="text-dark">Personal Information</h4> -->
<!-- <hr class="p_i"> -->
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
        <div class="d-flex" style="justify-content:space-between">
            <label>Your Link<i class="fas fa-copy ml-2 copy_i" style="cursor:pointer" onclick="copylink_fun('#linkshare')"></i></label>
            <div class="linkcopyalert font-weight-bolder" style="display:none;color:#294a63">Copied to your clipboard</div>
        </div>
        <input type="text" name="linkshare" class="form-control linkshare" id='linkshare' value="<?php echo base_url("wtr/") . $user_info->form_key ?>" required disabled style="cursor: not-allowed;">
    </div>
    <hr>
    <div class="form-group text-right">
        <button class="btn text-light save_pinfo_btn" type="submit" style="background-color:#294a63">
            Update</button>
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
        $('form#profileForm').submit(function(e) {
            // e.preventDefault();
            var uname = $('.uname').val();
            var email = $('.email').val();
            var mobile = $('.mobile').val();
            var formErr = null;

            if (uname == "" || uname == null) {
                formErr = true;
            } else {
                formErr = "";
            }

            if (email == "" || email == null) {
                formErr = true;
            } else {
                formErr = "";
            }

            if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
                formErr = true;
                $('.mobileerr').show();
            } else {
                formErr = "";
                $('.mobileerr').hide();
            }


            if (formErr === true) {
                return false;
            }
        });


    });
</script>